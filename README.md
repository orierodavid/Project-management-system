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
This repository is a reusable single-company installation. Each company receives its own deployment and database; company branding and structure are stored in the database and are never hardcoded.

## Planned stack
- Laravel
- Filament
- MySQL
- Laravel Sanctum
- spatie/laravel-permission
- spatie/laravel-activitylog
- Laravel Excel
- Laravel Notifications, queues and scheduler

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
