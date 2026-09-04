<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

/*
|--------------------------------------------------------------------------
| Fresh-install application key bootstrap
|--------------------------------------------------------------------------
|
| The web middleware can require Laravel's encrypter before the browser
| installer controller gets a chance to create an APP_KEY. Ensure a local
| .env file has a valid key before Laravel builds the application container.
| This makes a fresh checkout/ZIP install work without requiring the user to
| run `php artisan key:generate` first.
|
*/
$basePath = dirname(__DIR__);
$envPath = $basePath.'/.env';
$envExamplePath = $basePath.'/.env.example';

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

        file_put_contents($envPath, $environment);
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
