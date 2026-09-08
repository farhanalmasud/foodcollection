#!/usr/bin/env bash
# FoodCollection — apply custom modules after 6amMart update
set -euo pipefail

ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
CUSTOM="$ROOT/foodcollection-custom"

echo "==> FoodCollection custom apply"
echo "    Project root: $ROOT"

# Copy custom modules
if [ -d "$CUSTOM/modules" ]; then
  for mod in "$CUSTOM/modules"/*; do
    [ -d "$mod" ] || continue
    name="$(basename "$mod")"
    echo "==> Copying module: $name"
    mkdir -p "$ROOT/Modules/$name"
    cp -R "$mod/." "$ROOT/Modules/$name/"
  done
fi

# Merge modules_statuses.json additions
ADDITIONS="$CUSTOM/config/modules_statuses.additions.json"
STATUSES="$ROOT/modules_statuses.json"
if [ -f "$ADDITIONS" ] && [ -f "$STATUSES" ]; then
  echo "==> Merge modules_statuses.json (manual check recommended)"
  php -r "
    \$s = json_decode(file_get_contents('$STATUSES'), true);
    \$a = json_decode(file_get_contents('$ADDITIONS'), true);
    foreach (\$a as \$k => \$v) { \$s[\$k] = \$v; }
    file_put_contents('$STATUSES', json_encode(\$s, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL);
  "
fi

cd "$ROOT"

echo "==> composer dump-autoload"
composer dump-autoload --no-interaction 2>/dev/null || composer dump-autoload

echo "==> php artisan migrate"
php artisan migrate --force

echo "==> php artisan optimize:clear"
php artisan optimize:clear

echo ""
echo "Done. Next: apply core PATCHES from foodcollection-custom/patches/"
echo "See: foodcollection-custom/APPLY-AFTER-UPDATE.md"
echo "Or ask Cursor: Apply all foodcollection-custom patches"
