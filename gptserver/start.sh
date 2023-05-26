#!/bin/bash

nginx

php /app/gptserver/hyperf migrate

php /app/gptserver/hyperf start
