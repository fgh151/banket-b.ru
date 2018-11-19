#!/usr/bin/env bash
docker exec -ti battle-server_app_1 /var/www/html/yii mailqueue/process
