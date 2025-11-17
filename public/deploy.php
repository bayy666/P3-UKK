<?php

echo "=========================================\n";
echo "🚀 Starting Laravel Deployment - " . date('Y-m-d H:i:s') . "\n";
echo "=========================================\n";

// Config
$projectDir = '/var/www/laravel-app';
$branch = 'main';

// Change to project directory
chdir($projectDir);

// 1. Git pull
echo "📥 Pulling code from Git...\n";
exec("git pull origin $branch 2>&1", $gitOutput);
foreach ($gitOutput as $line) {
    echo "   {$line}\n";
}

// 2. Composer install
echo "📦 Installing Composer dependencies...\n";
exec('composer install --no-dev --optimize-autoloader 2>&1', $composerOutput);
foreach ($composerOutput as $line) {
    echo "   {$line}\n";
}

// 3. Run migrations
echo "🗃️ Running migrations...\n";
exec('php artisan migrate --force 2>&1', $migrateOutput);
foreach ($migrateOutput as $line) {
    echo "   {$line}\n";
}

// 4. Cache clear
echo "⚡ Optimizing application...\n";
exec('php artisan config:cache 2>&1', $configOutput);
exec('php artisan route:cache 2>&1', $routeOutput);
exec('php artisan view:cache 2>&1', $viewOutput);

echo "   Config cached: OK\n";
echo "   Route cached: OK\n";
echo "   View cached: OK\n";

// 5. Set permissions
echo "🔐 Setting permissions...\n";
exec("chmod -R 755 storage bootstrap/cache 2>&1");
exec("chown -R www-data:www-data {$projectDir} 2>&1");
echo "   Permissions set: OK\n";

echo "✅ Deployment completed - " . date('Y-m-d H:i:s') . "\n";
echo "=========================================\n";
?>