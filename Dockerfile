FROM hyperf/hyperf:8.0-alpine-v3.11-swoole

LABEL maintainer="Nick <me@xieying.vip>"

ENV TIMEZONE="Asia/Shanghai" \
    APP_ENV=prod \
    SCAN_CACHEABLE=(true)

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories && \
sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories && \
sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/' /etc/apk/repositories

# 安装基本组件
RUN apk update && apk add nginx vim

RUN mkdir /run/nginx /app

# Copy代码
COPY gptweb /app/gptweb
COPY gptadmin /app/gptadmin
COPY gptserver /app/gptserver
COPY conf/nginx-default.conf /etc/nginx/conf.d/default.conf

RUN chmod +x /app/gptserver/start.sh /app/gptserver/test.sh

RUN cd /app/gptserver && \
    composer install --no-dev --optimize-autoloader --ignore-platform-reqs && \
    ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && \
    cd /etc/php8 && \
    { \
       echo "upload_max_filesize=128M"; \
       echo "post_max_size=128M"; \
       echo "memory_limit=1G"; \
       echo "date.timezone=${TIMEZONE}"; \
    } | tee conf.d/99_overrides.ini && \
    rm -rf /var/cache/apk/* /tmp/* /usr/share/man


CMD ["bash", "-i", "/app/gptserver/start.sh"]
