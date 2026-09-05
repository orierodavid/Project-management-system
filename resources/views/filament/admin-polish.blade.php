<style>
/* Admin product polish: presentation only; Filament behavior and authorization remain untouched. */
.pm-topbar-context{display:flex;align-items:center;min-width:0}.pm-topbar-context>div:last-child{display:flex;flex-direction:column;gap:2px}.pm-topbar-context strong{color:#1f2937;font-size:14px;font-weight:700}.pm-topbar-context span{color:#7b809a;font-size:10px}.pm-topbar-create{display:inline-flex;align-items:center;gap:7px;min-height:38px;padding:0 13px;border-radius:8px;background:#e91e63;color:#fff!important;text-decoration:none;font-size:12px;font-weight:700;box-shadow:0 3px 8px rgba(233,30,99,.18)}.pm-topbar-create:hover{background:#d81b60}.pm-topbar-create:focus-visible,.pm-dashboard-action:focus-visible,.pm-nav-item:focus-visible,.pm-account-menu:focus-visible,.pm-shell-brand a:focus-visible{outline:3px solid rgba(37,99,235,.25);outline-offset:2px}.pm-account-popover-heading{padding:7px 8px 2px;color:#1f2937;font-size:12px;font-weight:700}.pm-account-popover-role{padding:0 8px 7px;color:#7b809a;font-size:10px}.pm-account-popover form{border-top:1px solid #e9ecef;padding-top:5px}.pm-account-popover button{color:#344767!important}.pm-dashboard-v5 .pm-kpi{border:1px solid transparent}.pm-dashboard-v5 .pm-kpi-note{color:#667085!important}.pm-dashboard-v5 .pm-kpi strong{font-variant-numeric:tabular-nums}.pm-dashboard-v5 .pm-panel-heading,.pm-dashboard-v5 .pm-chart-heading{min-height:76px}.pm-dashboard-v5 .pm-task-row:last-child{border-bottom:0}.pm-dashboard-v5 .pm-empty{padding:32px 20px}.pm-dashboard-v5 .pm-empty strong{color:#344767;display:block;font-size:13px}.pm-dashboard-v5 .pm-empty span{display:block;margin-top:4px;color:#9aa0b5;font-size:11px}.pm-dashboard-v5 .pm-status-chip,.pm-dashboard-v5 .pm-priority{white-space:nowrap}.pm-shell-backdrop{display:none}.pm-shell-sidebar{transition:transform .2s ease}.pm-mobile-menu{align-items:center;justify-content:center;width:38px;height:38px;margin-right:10px;border-radius:8px}.pm-mobile-menu:hover{background:#fff}.pm-nav-item{position:relative}.pm-nav-item.is-active:before{content:'';position:absolute;left:0;width:3px;height:22px;border-radius:0 3px 3px 0;background:#fff}

/* Global Filament page-title and header contrast: light workspace, dark headings. */
.fi-header,
.fi-header *{color:#1f2937!important}
.fi-header .fi-header-heading,
.fi-header .fi-header-heading *{color:#1f2937!important;font-weight:700!important}
.fi-header .fi-header-subheading,
.fi-header .fi-header-subheading *{color:#667085!important}
.fi-page-header,
.fi-page-header *{color:#1f2937!important}
.fi-page-header .fi-header-heading,
.fi-page-header .fi-header-heading *{color:#1f2937!important}
.fi-page-header .fi-header-subheading,
.fi-page-header .fi-header-subheading *{color:#667085!important}

/* Form controls: white fields with dark text; selectors/dropdowns use a dark control surface. */
.fi-fo-field-wrp-label,
.fi-fo-field-wrp-label span{color:#344767!important}
.fi-input-wrp,
.fi-fo-text-input .fi-input-wrp,
.fi-fo-textarea .fi-input-wrp,
.fi-fo-select .fi-input-wrp{background:#fff!important;color:#344767!important}
.fi-input,
.fi-fo-field-wrp input,
.fi-fo-field-wrp textarea,
.fi-fo-field-wrp select{color:#344767!important;-webkit-text-fill-color:#344767!important;background:transparent!important}
.fi-fo-select .fi-select-input,
.fi-select-input{background:#20242b!important;color:#fff!important;-webkit-text-fill-color:#fff!important;border-color:#343a46!important}
.fi-fo-select .fi-select-input option,
.fi-select-input option{background:#20242b!important;color:#fff!important}
.fi-fo-select .fi-input-wrp:focus-within,
.fi-select-input:focus{border-color:#e91e63!important;box-shadow:0 0 0 2px rgba(233,30,99,.12)!important}

@media(max-width:900px){.pm-shell-topbar{left:0;padding:0 18px}.pm-shell-sidebar{transform:translateX(calc(-100% - 20px))}.pm-shell-sidebar.is-open{transform:translateX(0)}.pm-shell-backdrop{position:fixed;inset:0;z-index:99;background:rgba(16,24,40,.28);backdrop-filter:blur(2px)}.pm-topbar-name{display:none}.pm-topbar-context{flex:1}.pm-topbar-create span{display:inline}.pm-main,.fi-main{padding-left:0!important}}@media(max-width:560px){.pm-shell-topbar{height:64px;padding:0 12px}.pm-topbar-create{padding:0 10px}.pm-topbar-create span{display:none}.pm-topbar-divider{display:none}.pm-user-avatar-small{width:34px;height:34px}.pm-main,.fi-main{padding-top:64px!important}.pm-shell-sidebar{inset:8px auto 8px 8px;height:calc(100vh - 16px)}}
</style>
