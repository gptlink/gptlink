<?php

namespace App\Base\Auth\Admin;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use Ramsey\Uuid\Uuid;

class JwtService
{
    protected $algo = 'AES-128-ECB';

    /**
     * @param array $options
     * @param string $appid
     * @param string $secret
     * @param int $ttl
     * @return string
     */
    public function encode(array $options = [], string $appid = '', string $secret = '', int $ttl = 7200): string
    {
        $payload = [
            'iss' => 'cb-sign-center',
            'exp' => time() + $ttl,
            'iat' => time(),
            'nbf' => time(),
            'jti' => Uuid::uuid4()->toString(),
            'dat' => $this->encryptData($options, $secret),
        ];

        return JWT::encode($payload, base64_encode($appid . $secret), 'HS256');
    }

    /**
     * @param string $jwt
     * @param string $appid
     * @param string $secret
     * @return array
     */
    public function decode(string $jwt, string $appid = '', string $secret = '')
    {
        $data = JWT::decode($jwt, new Key(base64_encode($appid . $secret), 'HS256'));

        if (! property_exists($data, 'dat')) {
            throw new SignatureInvalidException('Signature verification failed');
        }

        return $this->decryptData($data->dat, $secret);
    }

    /**
     * @param array $options
     * @param string $secret
     * @return false|string
     */
    protected function encryptData(array $options = [], string $secret = '')
    {
        return base64_encode(openssl_encrypt(
            json_encode($options),
            $this->algo,
            $this->getPassphrase($secret)
        ));
    }

    /**
     * @param $dat
     * @param $secret
     * @return array
     */
    protected function decryptData($dat, $secret)
    {
        return json_decode(openssl_decrypt(
            base64_decode($dat),
            $this->algo,
            $this->getPassphrase($secret)
        ), true);
    }

    /**
     * @param string $secret
     * @return false|string
     */
    protected function getPassphrase(string $secret = '')
    {
        return substr($secret, 0, 16);
    }
}
