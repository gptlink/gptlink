<?php

namespace HyperfTest\TestDto;

use Hyperf\Utils\Arr;

class Docs
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $basePath;

    public function __construct($config)
    {
        $this->config = $config;
        $this->basePath = Arr::get($config, 'base_path');
    }

    public function make()
    {
        foreach (scandir($this->basePath) as $path) {

            if (in_array($path, ['.', '..'])) continue;

            if (!Arr::has($this->config, sprintf('config.%s', $path))) continue;

            $swagger = $this->loadSwagger($path);

            if (empty($swagger['paths'])) continue;

            file_put_contents(
                sprintf("%s/storage/swagger/%s-swagger.json", BASE_PATH, $path),
                json_encode($swagger, JSON_UNESCAPED_UNICODE)
            );
        }
    }

    public function loadSwagger($project)
    {
        $swagger = ["swagger" => "2.0", "paths" => []];

        $update = [];

        foreach (scandir($this->basePath .$project) as $file) {
            if (in_array($file, ['.', '..'])) continue;

            list($method, $uri, $content) = $this->getSwaggerByFile($project, $file);

            array_push($update, ['method' => $method, 'url' => $uri]);

            $swagger['paths'][$uri][$method] = $content;
        }

        return $swagger;
    }

    /**
     * 获取swagger信息
     *
     * @param $project
     * @param $file
     * @return array
     */
    public function getSwaggerByFile($project, $file)
    {
        $example = explode("@", substr($file, 0, -5));

        $method = strtolower($example[0]);

        unset($example[0]);

        $content = json_decode(file_get_contents(sprintf("%s%s/%s", $this->basePath, $project, $file)), true);

        return [$method, implode('/', $example), $content];
    }
}
