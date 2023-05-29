# 部署文档

## Docker Compose 部署 （推荐）

需要先自行安装 `Docker` 与 `Docker Compose` ，可以自行百度或问 GPT 安装。 此环境包含 `MySQL` 与 `Redis` 等组件，开箱即用

配置文件路径 `docker-compose/.env`

### 运行项目

如果本地已存在旧镜像，建议先删除 `docker rmi overnick/gptlink`

```shell
# clone代码
git clone https://github.com/gptlink/gptlink.git

# 进入 docker compose 目录
cd gptlink/docker-compose

# 复制配置项文件，具体配置内容可以参考文件内注释
# 如无其他需求可不修改此文件内容
cp .env.example .env

# 运行 Mysql 与 Redis 服务
# 如遇端口冲突，可关闭机器中的 MySQL 于 Redis 或 修改 docker-compose/.env 中的配置重新运行，
docker-compose up -d mysql redis

# 以上服务运行成功后运行gptlink
docker-compose up -d gptlink
```


### 更新版本/更新配置

如果本地已存在旧镜像，建议先删除 `docker rmi overnick/gptlink`

```shell
# 更新 gptlink 代码
git pull origin master

# 进入 docker compose 目录
cd docker-compose

docker-compose up -d gptlink
```


## Docker 部署

`Docker` 镜像中不包含数据库与 `Redis`，关于 `Docker` 的安装，可以自行百度或问 GPT。

### 运行项目

```
docker run -d -p 80:80 \
   --name=gptlink \
   -e DB_HOST="数据库连接地址" \
   -e DB_DATABASE="数据库名称" \
   -e DB_USERNAME="数据库用户名" \
   -e DB_PASSWORD="数据库密码" \
   -e REDIS_HOST="Redis 链接地址" \
   -e REDIS_PORT="Redis 端口号" \
   overnick/gptlink:1.0

# 如果你需要指定其他环境变量，请自行在上述命令中增加 `-e 环境变量=环境变量值` 来指定。

测试配置项是否正常
docker run -it --rm gptlink /app/gptserver/test.sh
```

### 更新版本/更新配置

删除运行的容器，并且使用安装命令重新运行指定版本镜像或修改配置即可


## 云主机镜像部署

目前云主机镜像仅制作了 阿里云 与 腾讯云 镜像，可以发送对应账户 ID 加群联系群管理共享镜像， 云主机镜像是基于 Docker Compose 方式进行安装的。


## PHP 环境部署
环境部署需要动手能力较强的同学进行。项目目录结构为

- gptserver  服务器项目目录
- gptweb 用户端项目目录
- gptadmin 管理端项目目录

环境要求

- Nginx
- MySql 5.7 +
- Redis 5.0 +
- PHP 8.0
  - ext-swoole
  - ext-openssl 
  - ext-json
  - ext-pdo_mysql
  - ext-redis
  - ext-bcmath

项目提供的 `Nginx` 配置文件，位于 `conf/nginx-default.conf`，可以参考或借鉴。前端项目目前请求的接口地址是固定的 `/api/`

服务启动命令 `./gptserver/start.sh`

