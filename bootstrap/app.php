<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Fresh-install application bootstrap
|--------------------------------------------------------------------------
|
| A fresh checkout must be able to boot before an APP_KEY exists. Laravel's
| web middleware resolves the encrypter before the installer controller runs,
| so the key must be established during the earliest bootstrap phase.
|
| We also remove a stale compiled config cache when we have to create the key.
| Otherwise a previous cached configuration containing an empty APP_KEY can
| continue to override the newly written .env value.
|
*/
$basePath = dirname(__DIR__);
$envPath = $basePath.'/.env';
$envExamplePath = $basePath.'/.env.example';
$configCachePath = $basePath.'/bootstrap/cache/config.php';

if (! file_exists($envPath) && file_exists($envExamplePath)) {
    copy($envExamplePath, $envPath);
}

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

        // A compiled config can contain an old empty app.key and override .env.
        // Remove it only when we have just established a fresh application key.
        if (file_exists($configCachePath)) {
            @unlink($configCachePath);
        }
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
