<?php

function run($cmd, $desc) {
    echo "{$desc}...\n";
    exec($cmd . ' 2>&1', $output);
    foreach ($output as $line) echo "   {$line}\n";
}

echo "🚀 Deploy Started: " . date('H:i:s') . "\n";

chdir('/var/www/laravel-app');

run('git pull origin main', '📥 Git pull');
run('composer install --no-dev --optimize-autoloader', '📦 Composer');
run('php artisan migrate --force', '🗃️ Migrate');
run('php artisan config:cache && php artisan route:cache', '⚡ Cache');
run('chmod -R 755 storage bootstrap/cache', '🔐 Permissions');

echo "✅ Deploy Finished: " . date('H:i:s') . "\n";

?>  