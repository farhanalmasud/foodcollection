#!/usr/bin/env bash
# Fix 6amMart 4.1 "every page 404" after update.
#
# Two common causes:
#   1. RouteServiceProvider.php left in updater-only mode (only routes/update.php)
#   2. APP_HOST_DOMAIN set to apex domain instead of panel subdomain
#
# Run on the production server from the project root:
#   bash foodcollection-custom/scripts/fix-host-domain-404.sh
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
cd "$ROOT"

PANEL_HOST="${PANEL_HOST:-portal.foodcollections.com}"
BASE_DOMAIN="${BASE_DOMAIN:-foodcollections.com}"
APP_URL="${APP_URL:-https://${PANEL_HOST}}"

if [[ ! -f .env ]]; then
  echo "ERROR: .env not found in $ROOT"
  exit 1
fi

echo "==> Restoring production RouteServiceProvider (from .txt template)"
cp app/Providers/RouteServiceProvider.txt app/Providers/RouteServiceProvider.php

echo "==> Backing up .env"
cp .env ".env.bak.$(date +%Y%m%d%H%M%S)"

set_env() {
  local key="$1"
  local value="$2"
  if grep -q "^${key}=" .env; then
    sed -i.bak "s|^${key}=.*|${key}=${value}|" .env 2>/dev/null \
      || sed -i '' "s|^${key}=.*|${key}=${value}|" .env
  else
    echo "${key}=${value}" >> .env
  fi
}

echo "==> Setting panel host env vars"
set_env "APP_URL" "$APP_URL"
set_env "APP_HOST_DOMAIN" "$PANEL_HOST"
set_env "APP_HOST_BASE_DOMAIN" "$BASE_DOMAIN"

echo "==> Clearing Laravel caches"
php artisan optimize:clear

echo ""
echo "Done. Verify:"
echo "  APP_URL=$APP_URL"
echo "  APP_HOST_DOMAIN=$PANEL_HOST"
echo "  APP_HOST_BASE_DOMAIN=$BASE_DOMAIN"
echo ""
echo "Open: ${APP_URL}/admin"
