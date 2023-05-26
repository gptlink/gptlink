# 疑难解答

### Docker 部署时提示服务器错误或接口返回 `2002` 错误码

检查数据库与 Redis 配置地址是否正常，可以通过命令 `docker exec -it gptlink /app/gptserver/test.sh` 检查

PS: 不要填写 `127.0.0.1` 或 `localhost`，此地址是指向容器内，容器内并不包含 `Mysql` 和 `Redis` 服务，可以填写本机的内网 IP 如 `192.168.1.100` 或 容器的网关 IP

### 接口返回 502 Bad Gateway

通常为后端服务未运行起来，可以进入容器内查看 `/var/log/apiserver.log` 文件查看异常内容，

或在宿主机运行 `docker exec gptlink cat /var/log/apiserver.log` 查看异常内容

### 微信扫码登录提示 AppID 参数错误

需要前往管理后台配置上网站应用的 `APPID` 与 `SECRET` ，网站应用申请 [点击前往](https://open.weixin.qq.com/)

网页授权域名校验文件放置容器内 `/app/gptweb` 目录下即可完成验证。


### 微信登陆提示 redirect_uri 与后台配置不一致

需要前往[微信公众平台](https://mp.weixin.qq.com/)配置网页回调域名为你的域名。

公众号菜单路径：设置与开发 -> 公众号设置 -> 功能设置 -> 网页授权域名

网页授权域名校验文件放置容器内 `/app/gptweb` 目录下即可完成验证。


### 如何配置使用 OpenAI 提供的接口

详见ENV部分说明


### 支付成功但订单显示未支付

检查环境变量 `APP_URL` 是否正确，通常配置为 协议 + 域名 + /api/，以下为示例

```txt
示例配置

APP_URL=https://abc.com/api/
...
```

