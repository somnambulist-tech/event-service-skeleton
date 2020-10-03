#!/usr/bin/env bash

set -e
cd /app

[[ -d "/app/var" ]] || mkdir -m 0777 "/app/var"
[[ -d "/app/var/cache" ]] || mkdir -m 0777 "/app/var/cache"
[[ -d "/app/var/logs" ]] || mkdir -m 0777 "/app/var/logs"
[[ -d "/app/var/run" ]] || mkdir -m 0777 "/app/var/run"
[[ -d "/app/var/tmp" ]] || mkdir -m 0777 "/app/var/tmp"

# remove -vv to stop outputting per message events
/app/bin/console messenger:consume domain_events --memory-limit=256M -vv
