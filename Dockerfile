FROM hyperf/hyperf:8.0-alpine-v3.11-swoole

LABEL maintainer="Nick <me@xieying.vip>"

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories && \
sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories && \
sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories

# 安装基本组件
RUN apk update && apk add nginx supervisor vim

RUN mkdir /run/nginx /app /etc/supervisor.d

# Copy代码
COPY gptweb /app/gptweb
COPY gptadmin /app/gptweb/admin
COPY gptserver /app/gptserver

COPY conf/supervisor-server.ini /etc/supervisor.d/server.ini
COPY conf/supervisor-nginx.ini /etc/supervisor.d/nginx.ini
COPY conf/nginx-default.conf /etc/nginx/conf.d/default.conf

RUN chmod +x /app/gptserver/start.sh /app/gptserver/test.sh

RUN cd /app/gptserver && \
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs

CMD ["python3", "/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
