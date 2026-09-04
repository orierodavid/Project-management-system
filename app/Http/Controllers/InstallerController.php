<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDO;
use Throwable;

class InstallerController extends Controller
{
    public function index()
    {
        if ($this->isInstalled()) {
            return redirect('/')->with('status', 'The application is already installed.');
        }

        return view('install', [
            'defaults' => [
                'app_name' => env('APP_NAME', 'Project Management System'),
                'app_url' => env('APP_URL', url('/')),
                'db_host' => env('DB_HOST', '127.0.0.1'),
                'db_port' => env('DB_PORT', '3306'),
                'db_database' => env('DB_DATABASE', 'project_management'),
                'db_username' => env('DB_USERNAME', 'root'),
                'db_password' => '',
                'timezone' => env('APP_TIMEZONE', 'Africa/Lagos'),
                'admin_name' => env('SUPER_ADMIN_NAME', 'System Administrator'),
                'admin_email' => env('SUPER_ADMIN_EMAIL', 'admin@example.com'),
            ],
        ]);
    }

    public function install(Request $request)
    {
        if ($this->isInstalled()) {
            return redirect('/')->with('status', 'The application is already installed.');
        }

        $data = $request->validate([
            'app_name' => ['required', 'string', 'max:120'],
            'app_url' => ['required', 'url', 'max:255'],
            'db_host' => ['required', 'string', 'max:255'],
            'db_port' => ['required', 'integer', 'between:1,65535'],
            'db_database' => ['required', 'string', 'max:64', 'regex:/^[A-Za-z0-9_]+$/'],
            'db_username' => ['required', 'string', 'max:255'],
            'db_password' => ['nullable', 'string', 'max:255'],
            'timezone' => ['required', 'timezone'],
            'admin_name' => ['required', 'string', 'max:120'],
            'admin_email' => ['required', 'email', 'max:255'],
            'admin_password' => ['required', 'string', 'min:8', 'max:255'],
        ]);

        try {
            $this->writeEnvironment($data);
            $this->applyRuntimeEnvironment($data);
            $this->createDatabaseIfMissing($data);

            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            Artisan::call('migrate', ['--force' => true]);
            Artisan::call('db:seed', ['--class' => 'RolesAndPermissionsSeeder', '--force' => true]);
            Artisan::call('db:seed', ['--class' => 'BranchSeeder', '--force' => true]);

            $admin = User::updateOrCreate(
                ['email' => $data['admin_email']],
                [
                    'name' => $data['admin_name'],
                    'password' => Hash::make($data['admin_password']),
                    'status' => 'active',
                    'primary_branch_id' => DB::table('branches')->value('id'),
                ],
            );
            $admin->syncRoles(['Super Admin']);

            Setting::updateOrCreate([], [
                'company_name' => $data['app_name'],
                'timezone' => $data['timezone'],
            ]);

            Artisan::call('storage:link');
            Artisan::call('optimize:clear');

            $this->markInstalled();

            return view('install-success', [
                'email' => $data['admin_email'],
                'appUrl' => rtrim($data['app_url'], '/'),
            ]);
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput($request->except('admin_password', 'db_password'))
                ->withErrors(['install' => $e->getMessage()]);
        }
    }

    private function isInstalled(): bool
    {
        return file_exists(storage_path('app/installed.lock'));
    }

    private function markInstalled(): void
    {
        file_put_contents(storage_path('app/installed.lock'), now()->toIso8601String());
    }

    private function writeEnvironment(array $data): void
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            copy(base_path('.env.example'), $envPath);
        }

        $contents = file_get_contents($envPath);
        $values = [
            'APP_NAME' => $data['app_name'],
            'APP_ENV' => 'local',
            'APP_DEBUG' => 'true',
            'APP_URL' => rtrim($data['app_url'], '/'),
            'APP_TIMEZONE' => $data['timezone'],
            'APP_KEY' => 'base64,'.base64_encode(random_bytes(32)),
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $data['db_host'],
            'DB_PORT' => (string) $data['db_port'],
            'DB_DATABASE' => $data['db_database'],
            'DB_USERNAME' => $data['db_username'],
            'DB_PASSWORD' => $data['db_password'],
            'SUPER_ADMIN_NAME' => $data['admin_name'],
            'SUPER_ADMIN_EMAIL' => $data['admin_email'],
            'SUPER_ADMIN_PASSWORD' => $data['admin_password'],
        ];

        foreach ($values as $key => $value) {
            $escaped = str_replace(['\\', '"'], ['\\\\', '\\"'], $value);
            $line = $key.'="'.$escaped.'"';
            $pattern = '/^'.preg_quote($key, '/').'=.*$/m';
            $contents = preg_replace($pattern, $line, $contents, 1, $count);

            if ($count === 0) {
                $contents .= PHP_EOL.$line;
            }
        }

        file_put_contents($envPath, $contents);
    }

    private function applyRuntimeEnvironment(array $data): void
    {
        $runtime = [
            'APP_NAME' => $data['app_name'],
            'APP_URL' => rtrim($data['app_url'], '/'),
            'APP_TIMEZONE' => $data['timezone'],
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $data['db_host'],
            'DB_PORT' => (string) $data['db_port'],
            'DB_DATABASE' => $data['db_database'],
            'DB_USERNAME' => $data['db_username'],
            'DB_PASSWORD' => $data['db_password'],
        ];

        foreach ($runtime as $key => $value) {
            putenv($key.'='.$value);
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }

        config([
            'app.name' => $data['app_name'],
            'app.url' => rtrim($data['app_url'], '/'),
            'app.timezone' => $data['timezone'],
            'database.default' => 'mysql',
            'database.connections.mysql.host' => $data['db_host'],
            'database.connections.mysql.port' => $data['db_port'],
            'database.connections.mysql.database' => $data['db_database'],
            'database.connections.mysql.username' => $data['db_username'],
            'database.connections.mysql.password' => $data['db_password'],
        ]);
    }

    private function createDatabaseIfMissing(array $data): void
    {
        $dsn = sprintf('mysql:host=%s;port=%s;charset=utf8mb4', $data['db_host'], $data['db_port']);
        $pdo = new PDO($dsn, $data['db_username'], $data['db_password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $database = str_replace('`', '``', $data['db_database']);
        $pdo->exec('CREATE DATABASE IF NOT EXISTS `'.$database.'` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }
}
