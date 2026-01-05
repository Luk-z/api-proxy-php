#!/bin/bash

# Get the workspace root directory
WORKSPACE_ROOT="/Users/lucaziliani/code/api-proxy-php"
TEMP_DIR="/var/folders"

# Transform arguments: replace host paths with container paths
ARGS=()
for arg in "$@"; do
    # Replace workspace root path with /app
    if [[ "$arg" == *"$WORKSPACE_ROOT"* ]]; then
        arg="${arg//$WORKSPACE_ROOT//app}"
    fi
    # Replace temp directory path
    if [[ "$arg" == *"$TEMP_DIR"* ]]; then
        arg="${arg//$TEMP_DIR//tmp}"
    fi
    ARGS+=("$arg")
done

docker run --rm --interactive \
    --volume "$WORKSPACE_ROOT:/app" \
    --volume "$TEMP_DIR:/tmp" \
    --workdir /app \
    --user "$(id -u):$(id -g)" \
    php:8.2 \
    php /app/vendor/bin/php-cs-fixer "${ARGS[@]}"
