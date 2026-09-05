@php
    $user = auth()->user();
    $panelId = \Filament\Facades\Filament::getCurrentPanel()?->getId();
    $isStaff = $panelId === 'staff' || ($user?->hasRole('Staff') && ! $user?->hasAnyRole(['Admin', 'Super Admin']));
    $company = \App\Models\Setting::current();
    $companyName = $company->company_name ?: 'Project Management System';
    $initials = collect(preg_split('/\s+/', trim($user?->name ?? 'User')))->filter()->map(fn ($part) => strtoupper(substr($part, 0, 1)))->take(2)->implode('');
    $current = request()->path();
    $active = fn (string $path): bool => $current === trim($path, '/') || str_starts_with($current, trim($path, '/') . '/');
@endphp

@if ($user)
<div class="pm-product-shell" x-data="{ open: false }">
    <div class="pm-shell-backdrop" x-show="open" x-cloak @click="open = false"></div>
    <aside class="pm-shell-sidebar" :class="open ? 'is-open' : ''">
        <div class="pm-shell-brand">
            <a href="{{ url($isStaff ? '/staff' : '/admin') }}" class="pm-brand-link">
                @if ($company->company_logo)
                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($company->company_logo) }}" alt="{{ $companyName }}" class="pm-brand-logo">
                @else
                    <span class="pm-brand-mark">{{ strtoupper(substr($companyName, 0, 1)) }}</span>
                @endif
                <span class="pm-brand-copy"><strong>{{ $companyName }}</strong><small>{{ $isStaff ? 'Staff workspace' : ($user->hasRole('Super Admin') ? 'Super Admin' : 'Admin workspace') }}</small></span>
            </a>
            <button class="pm-sidebar-close" type="button" @click="open = false" aria-label="Close navigation">×</button>
        </div>
        <nav class="pm-shell-nav" aria-label="Primary navigation">
            @if ($isStaff)
                <p class="pm-nav-label">My work</p>
                <a class="pm-nav-item {{ $current === 'staff' ? 'is-active' : '' }}" href="{{ url('/staff') }}"><span class="pm-nav-icon">⌂</span><span>Overview</span></a>
                <a class="pm-nav-item {{ $active('staff/tasks') ? 'is-active' : '' }}" href="{{ url('/staff/tasks') }}"><span class="pm-nav-icon">✓</span><span>My tasks</span></a>
                <a class="pm-nav-item {{ $active('staff/attendance') ? 'is-active' : '' }}" href="{{ url('/staff/attendance') }}"><span class="pm-nav-icon">◷</span><span>Attendance</span></a>
            @else
                <p class="pm-nav-label">Workspace</p>
                <a class="pm-nav-item {{ $current === 'admin' ? 'is-active' : '' }}" href="{{ url('/admin') }}"><span class="pm-nav-icon">⌂</span><span>Dashboard</span></a>
                <a class="pm-nav-item {{ $active('admin/tasks') ? 'is-active' : '' }}" href="{{ url('/admin/tasks') }}"><span class="pm-nav-icon">✓</span><span>Tasks</span></a>
                <p class="pm-nav-label">People</p>
                @can('manage-users')<a class="pm-nav-item {{ $active('admin/users') ? 'is-active' : '' }}" href="{{ url('/admin/users') }}"><span class="pm-nav-icon">◎</span><span>Users</span></a>@endcan
                @can('manage-departments')<a class="pm-nav-item {{ $active('admin/departments') ? 'is-active' : '' }}" href="{{ url('/admin/departments') }}"><span class="pm-nav-icon">◫</span><span>Departments</span></a>@endcan
                @can('manage-branches')<a class="pm-nav-item {{ $active('admin/branches') ? 'is-active' : '' }}" href="{{ url('/admin/branches') }}"><span class="pm-nav-icon">⌖</span><span>Branches</span></a>@endcan
                <a class="pm-nav-item {{ $active('admin/attendance') ? 'is-active' : '' }}" href="{{ url('/admin/attendance') }}"><span class="pm-nav-icon">◷</span><span>Attendance</span></a>
                @can('view-reports')
                    <p class="pm-nav-label">Insights</p>
                    <a class="pm-nav-item {{ $active('admin/attendance-reports') ? 'is-active' : '' }}" href="{{ \App\Filament\Pages\AttendanceReports::getUrl() }}"><span class="pm-nav-icon">▥</span><span>Reports</span></a>
                @endcan
                @can('manage-settings')
                    <p class="pm-nav-label">System</p>
                    <a class="pm-nav-item {{ $active('admin/company-settings') ? 'is-active' : '' }}" href="{{ \App\Filament\Pages\CompanySettings::getUrl() }}"><span class="pm-nav-icon">⚙</span><span>Settings</span></a>
                @endcan
            @endif
        </nav>
        <div class="pm-shell-account">
            <div class="pm-account-card">
                <span class="pm-user-avatar">{{ $initials }}</span>
                <span class="pm-account-copy"><strong>{{ $user->name }}</strong><small>{{ $isStaff ? 'Team member' : ($user->hasRole('Super Admin') ? 'Super Admin' : 'Administrator') }}</small></span>
                <button class="pm-account-menu" type="button" @click="open = !open" aria-label="Account menu">•••</button>
            </div>
            <div class="pm-account-popover" x-show="open" x-cloak @click.outside="open = false">
                <form method="POST" action="{{ \Filament\Facades\Filament::getCurrentPanel()->getLogoutUrl() }}">@csrf<button type="submit">Sign out</button></form>
            </div>
        </div>
    </aside>
    <header class="pm-shell-topbar">
        <button class="pm-mobile-menu" type="button" @click="open = true" aria-label="Open navigation">☰</button>
        <div class="pm-shell-search"><span>⌕</span><input type="search" placeholder="Search workspace" aria-label="Search workspace"><kbd>⌘ K</kbd></div>
        <div class="pm-topbar-actions"><button class="pm-topbar-icon" type="button" aria-label="Notifications">♢<i></i></button><div class="pm-topbar-divider"></div><span class="pm-topbar-name">{{ $user->name }}</span><span class="pm-user-avatar pm-user-avatar-small">{{ $initials }}</span></div>
    </header>
</div>
@endif
