<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('tasks:check-due-soon')->hourly();
Schedule::command('tasks:check-overdue')->everyTenMinutes();
