@php
    $settings = \App\Models\Setting::current();
    $primary = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $settings->primary_color) ? $settings->primary_color : '#2563EB';
    $secondary = preg_match('/^#[0-9a-fA-F]{6}$/', (string) $settings->secondary_color) ? $settings->secondary_color : '#0F172A';
@endphp
<style>
/* Runtime brand layer: reads the saved Company Settings colors on every page render. */
:root{
    --pm-accent:{{ $primary }}!important;
    --pm-accent-hover:color-mix(in srgb, {{ $primary }} 88%, #000)!important;
    --pm-secondary:{{ $secondary }}!important;
    --pm-shell-blue:{{ $primary }}!important;
    --pm-brand-soft:color-mix(in srgb, {{ $primary }} 10%, #fff)!important;
    --pm-brand-soft-strong:color-mix(in srgb, {{ $primary }} 16%, #fff)!important;
}
.fi-btn-color-primary{background:{{ $primary }}!important;border-color:{{ $primary }}!important}
.fi-btn-color-primary:hover{background:color-mix(in srgb, {{ $primary }} 88%, #000)!important;border-color:color-mix(in srgb, {{ $primary }} 88%, #000)!important}
.fi-input:focus,.fi-select:focus,.fi-textarea:focus,.fi-fo-text-input:focus,.fi-fo-select:focus,.fi-fo-textarea:focus{border-color:{{ $primary }}!important;box-shadow:0 0 0 3px color-mix(in srgb, {{ $primary }} 12%, transparent)!important}
.fi-sidebar-item-active .fi-sidebar-item-button{background:{{ $primary }}!important;border-color:{{ $primary }}!important}
.fi-sidebar-item-active .fi-sidebar-item-icon{color:#fff!important}
.pm-nav-item.is-active{background:color-mix(in srgb, {{ $primary }} 10%, #fff)!important;color:{{ $primary }}!important}
.pm-nav-item.is-active:before,.pm-nav-item.is-active .pm-nav-icon{background:{{ $primary }}!important;color:{{ $primary }}!important}
.pm-nav-item.is-active:before{background:{{ $primary }}!important}
.pm-clock-button,.pm-board-button-primary{background:{{ $primary }}!important;border-color:{{ $primary }}!important}
.pm-clock-button:hover,.pm-board-button-primary:hover{background:color-mix(in srgb, {{ $primary }} 88%, #000)!important}
.pm-kpi-primary strong,.pm-panel-heading a,.pm-text-action,.pm-quick-links a span{color:{{ $primary }}!important}
.pm-topbar-icon i{background:{{ $primary }}!important}
.pm-brand-mark{background:{{ $secondary }}!important}
.pm-attendance-hero{background:{{ $secondary }}!important;border-color:{{ $secondary }}!important}
.pm-attendance-hero.is-working{background:color-mix(in srgb, {{ $secondary }} 92%, #000)!important}
</style>
