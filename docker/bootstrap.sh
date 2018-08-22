#!/usr/bin/env bash
mkdir -p ./www/assets

until php ./yii migrate --interactive=0; do
    echo "Waiting for database container..."
    sleep 5
done