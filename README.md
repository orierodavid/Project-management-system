# Project Management System

Internal Laravel project management and geofenced attendance system.

## Core modules
- Role-based access: Super Admin, Admin, Staff
- Branches and server-side geofencing
- Departments and staff management
- Task assignment, deadlines, comments and attachments
- Mobile-first staff workspace
- Attendance clock-in/out
- Database-driven company branding and settings
- Notifications, reports and audit trail

## Architecture
This repository is a reusable single-company installation. Each company receives its own deployment and database; company branding and structure are stored in the database and are not hardcoded into the application.

## Stack
- Laravel 11
- Filament 3
- MySQL in production (SQLite can be used for automated tests)
- Laravel Sanctum
- spatie/laravel-permission
- spatie/laravel-activitylog
- Laravel Excel
- Laravel Notifications, queues and scheduler

## Local setup

1. Install PHP 8.2+, Composer, Node.js/npm and a supported database.
2. Copy `.env.example` to `.env` and configure the deployment-specific values.
3. Install PHP dependencies:

```bash
composer install
```

4. Generate the application key:

```bash
php artisan key:generate
```

5. Create the configured database and run migrations/seeders:

```bash
php artisan migrate --seed
```

6. Create the public storage link for uploaded logos and task attachments:

```bash
php artisan storage:link
```

7. Start the application:

```bash
php artisan serve
```

8. Build frontend assets when the project includes frontend changes:

```bash
npm install
npm run build
```

## XAMPP / Windows development

If Apache and MySQL are being provided by XAMPP, run the Laravel commands from the project directory using the PHP and Composer installations available on your machine. The application itself does not require a Git process to run; Git is used to pull repository updates.

After pulling an update, run:

```bash
git pull origin main
composer install
php artisan migrate
php artisan optimize:clear
```

If frontend files changed, also run:

```bash
npm install
npm run build
```

For local development, `php artisan serve` can be used instead of Apache. If the project is served directly through XAMPP Apache, make sure Apache's document root points to Laravel's `public` directory (or configure an equivalent virtual host).

## First installation

The seeders create the default roles, a `Head Office` branch and a Super Admin account. Configure the generated Super Admin credentials through the deployment environment before seeding a production installation; do not rely on the development fallback password in production.

After signing in as Super Admin:

1. Open **Company Settings**.
2. Set the company name, logo, brand colors, timezone and working hours.
3. Edit the default branch and replace its placeholder GPS coordinates with the real branch coordinates and geofence radius.
4. Create departments and staff/admin accounts.
5. Assign each user a primary branch and, where required, additional branch access.

An active branch with placeholder `0,0` coordinates cannot be used for attendance until configured.

## Queue worker

Notifications are designed to use Laravel's notification/queue infrastructure. For a production deployment, run a queue worker using your process manager:

```bash
php artisan queue:work --tries=3
```

For XAMPP/Windows development, start the worker in a separate terminal and leave it running while testing queued notifications:

```bash
php artisan queue:work --tries=3
```

## Scheduler

The application schedules due-soon and overdue task checks. Run Laravel's scheduler every minute in production:

```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### XAMPP / Windows scheduler

Windows does not use the Linux cron example above. For local XAMPP testing, open a second terminal in the Laravel project directory and run:

```bash
php artisan schedule:work
```

Leave that process running while testing scheduled task notifications. For a persistent Windows installation, configure Windows Task Scheduler to run `php artisan schedule:run` every minute using the PHP executable for the Laravel installation and the project directory as the working directory.

For local inspection:

```bash
php artisan schedule:list
```

## Attendance security

The browser supplies GPS coordinates, but the server performs the authoritative geofence calculation against the user's assigned branch. Attendance records retain the historical branch and clock-in/out coordinates and calculated distances so later branch changes do not rewrite attendance history.

## CI

GitHub Actions runs dependency installation, migrations, the Laravel test suite and Laravel Pint against the repository. CI uses SQLite for the database test environment. Formatting checks are read-only; CI does not push changes back to `main`.

## Development phases
1. Foundation and database architecture
2. Roles, permissions and authorization
3. Organization management
4. Task management
5. Mobile-first staff workspace
6. Geofenced attendance
7. Notifications and automation
8. Reports and audit trail
9. Testing and deployment hardening
