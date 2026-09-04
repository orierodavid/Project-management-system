<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Fresh-install application bootstrap
|--------------------------------------------------------------------------
|
| The installer must boot on a completely fresh XAMPP checkout. Laravel's
| web middleware can resolve the encrypter before the installer controller,
| so APP_KEY must exist during the earliest bootstrap phase.
|
*/
$basePath = dirname(__DIR__);
$envPath = $basePath.'/.env';
$envExamplePath = $basePath.'/.env.example';
$configCachePath = $basePath.'/bootstrap/cache/config.php';

if (! file_exists($envPath) && file_exists($envExamplePath)) {
    copy($envExamplePath, $envPath);
}

$appKey = null;

if (file_exists($envPath)) {
    $environment = file_get_contents($envPath);
    $hasUsableAppKey = preg_match('/^APP_KEY\s*=\s*(.+)$/m', $environment, $matches)
        && trim($matches[1], " \t\"'") !== '';

    if (! $hasUsableAppKey) {
        $appKey = 'base64,'.base64_encode(random_bytes(32));
        $line = 'APP_KEY="'.$appKey.'"';
        $pattern = '/^APP_KEY\s*=.*$/m';

        if (preg_match($pattern, $environment)) {
            $environment = preg_replace($pattern, $line, $environment, 1);
        } else {
            $environment = rtrim($environment).PHP_EOL.$line.PHP_EOL;
        }

        file_put_contents($envPath, $environment, LOCK_EX);
    } else {
        $appKey = trim($matches[1], " \t\"'");
    }
}

if ($appKey !== null && $appKey !== '') {
    // Make the key available immediately, before Laravel loads configuration.
    putenv('APP_KEY='.$appKey);
    $_ENV['APP_KEY'] = $appKey;
    $_SERVER['APP_KEY'] = $appKey;
}

if ($appKey !== null && file_exists($configCachePath)) {
    // A stale compiled config containing an empty app.key must not override
    // the valid key above. Preserve valid compiled production configuration.
    $cachedConfig = @include $configCachePath;

    if (is_array($cachedConfig) && empty($cachedConfig['app']['key'])) {
        @unlink($configCachePath);
    }
}

return Application::configure(basePath: $basePath)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Application middleware is intentionally kept minimal; authorization is
        // enforced through Laravel policies, Filament resources and permissions.
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Central exception configuration belongs here for this Laravel 11 app.
    })->create();
