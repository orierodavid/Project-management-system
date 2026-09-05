<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
@import url('https://fonts.googleapis.com/icon?family=Material+Icons+Round');

:root{
    --md-bg:#f8f9fa; --md-surface:#fff; --md-text:#344767; --md-heading:#1f2937;
    --md-muted:#7b809a; --md-border:#e9ecef; --md-primary:#e91e63; --md-primary-dark:#c2185b;
    --md-primary-soft:#fce4ec; --md-success:#4caf50; --md-warning:#fb8c00; --md-danger:#f44335;
    --md-radius:12px; --md-sidebar:250px; --md-topbar:72px; --md-gutter:24px; --md-max:1480px;
    --md-shadow:0 4px 6px -1px rgba(0,0,0,.08),0 2px 4px -1px rgba(0,0,0,.04);
}
*,*::before,*::after{box-sizing:border-box}
html,body{background:var(--md-bg)!important;color:var(--md-text)!important;font-family:Roboto,Arial,sans-serif!important}
body,.fi-body,.fi-layout,.fi-main,.fi-main-ctn,.fi-page{font-family:Roboto,Arial,sans-serif!important}

/* One layout owner: the application shell. Filament remains responsible for behavior. */
.fi-sidebar,.fi-topbar{display:none!important}
.fi-layout,.fi-body,.fi-main,.fi-main-ctn{width:100%!important;max-width:none!important}
.fi-main{margin:0!important;padding:var(--md-topbar) 0 0 var(--md-sidebar)!important;background:var(--md-bg)!important;min-width:0!important}
.fi-main-ctn{margin:0!important;padding:0 var(--md-gutter) 40px!important;background:var(--md-bg)!important;min-width:0!important}
.fi-main-ctn>*{min-width:0!important}
.fi-page{width:100%!important;max-width:none!important;margin:0!important;padding:0!important;min-width:0!important}
.fi-page-content{width:100%!important;max-width:none!important;min-width:0!important}
.fi-page-content>*{min-width:0!important}
.fi-header{width:min(100%,var(--md-max))!important;max-width:var(--md-max)!important;margin-inline:auto!important;padding-top:22px!important}

/* Material Dashboard shell */
.pm-product-shell{font-family:Roboto,Arial,sans-serif!important}
.pm-shell-sidebar{position:fixed;z-index:100;inset:12px auto 12px 12px;width:var(--md-sidebar);display:flex;flex-direction:column;overflow:hidden;background:#fff;border-radius:var(--md-radius);box-shadow:var(--md-shadow);color:var(--md-text)}
.pm-shell-brand{height:76px;display:flex;align-items:center;padding:0 18px;border-bottom:1px solid var(--md-border)}
.pm-brand-link{display:flex;align-items:center;gap:12px;min-width:0;color:inherit;text-decoration:none}
.pm-brand-mark,.pm-brand-logo{width:40px;height:40px;flex:none;border-radius:10px;object-fit:cover}
.pm-brand-mark{display:grid;place-items:center;background:linear-gradient(135deg,#e91e63,#ad1457);color:#fff;font-size:16px;font-weight:700}
.pm-brand-copy{min-width:0;display:flex;flex-direction:column;line-height:1.25}
.pm-brand-copy strong{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#344767;font-size:14px;font-weight:700}
.pm-brand-copy small{margin-top:4px;color:var(--md-muted);font-size:10px;font-weight:500}
.pm-sidebar-close{display:none;margin-left:auto;border:0;background:none;font-size:24px;color:#7b809a}
.pm-shell-nav{flex:1;overflow-y:auto;padding:12px}
.pm-nav-label{margin:18px 10px 7px;color:#9aa0b5;font-size:10px;font-weight:700;letter-spacing:.08em;text-transform:uppercase}
.pm-nav-label:first-child{margin-top:4px}
.pm-nav-item{display:flex;align-items:center;gap:13px;height:44px;margin:4px 0;padding:0 13px;border-radius:8px;color:#67748e;text-decoration:none;font-size:13px;font-weight:500;transition:.18s ease}
.pm-nav-item:hover{background:#f5f6f8;color:#344767}
.pm-nav-item.is-active{background:linear-gradient(195deg,#ec407a,#d81b60);color:#fff;box-shadow:0 4px 8px rgba(233,30,99,.22);font-weight:700}
.pm-nav-icon{display:grid;place-items:center;width:22px;color:#7b809a;font-size:17px;line-height:1}
.pm-nav-item.is-active .pm-nav-icon{color:#fff}
.pm-shell-account{position:relative;padding:12px;border-top:1px solid var(--md-border)}
.pm-account-card{display:flex;align-items:center;gap:10px;padding:10px;border-radius:9px}
.pm-account-card:hover{background:#f8f9fa}
.pm-account-copy{min-width:0;flex:1;display:flex;flex-direction:column}
.pm-account-copy strong{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#344767;font-size:12px;font-weight:700}
.pm-account-copy small{margin-top:3px;color:#9aa0b5;font-size:10px}
.pm-account-menu{border:0;background:none;color:#7b809a;font-size:13px;cursor:pointer}
.pm-user-avatar{display:grid;place-items:center;flex:none;width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#ec407a,#ab1457);color:#fff;font-size:10px;font-weight:700}
.pm-user-avatar-small{width:36px;height:36px}
.pm-account-popover{position:absolute;right:12px;bottom:62px;width:170px;padding:6px;background:#fff;border:1px solid var(--md-border);border-radius:8px;box-shadow:0 10px 24px rgba(0,0,0,.12)}
.pm-account-popover form,.pm-account-popover button{width:100%}
.pm-account-popover button{padding:10px;border:0;border-radius:6px;background:#fff;color:#344767;text-align:left;font-size:12px;font-weight:500;cursor:pointer}
.pm-account-popover button:hover{background:#f5f6f8}
.pm-shell-topbar{position:fixed;z-index:90;top:0;right:0;left:var(--md-sidebar);height:var(--md-topbar);display:flex;align-items:center;justify-content:space-between;padding:0 32px;background:rgba(248,249,250,.96)}
.pm-shell-search{display:flex;align-items:center;gap:9px;width:300px;height:40px;padding:0 12px;border:1px solid #dce0e5;border-radius:8px;background:#fff;color:#7b809a}
.pm-shell-search input{min-width:0;flex:1;border:0;outline:0;background:transparent;color:#344767;font-size:12px}
.pm-shell-search input::placeholder{color:#9aa0b5}
.pm-shell-search kbd{padding:3px 6px;border:1px solid #e1e4e8;border-radius:4px;background:#f8f9fa;color:#7b809a;font:500 9px monospace}
.pm-topbar-actions{display:flex;align-items:center;gap:13px}
.pm-topbar-icon{position:relative;border:0;background:none;color:#67748e;font-size:20px;cursor:pointer}
.pm-topbar-icon i{position:absolute;top:0;right:0;width:6px;height:6px;border-radius:50%;background:var(--md-primary)}
.pm-topbar-divider{width:1px;height:24px;background:#e9ecef}
.pm-topbar-name{color:#344767;font-size:12px;font-weight:500}
.pm-mobile-menu{display:none;border:0;background:none;color:#344767;font-size:21px}

/* Dashboard canvas */
.pm-dashboard{width:min(100%,var(--md-max))!important;max-width:var(--md-max)!important;margin-inline:auto!important;padding-bottom:32px!important}
.pm-dashboard-header{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin:0 0 24px!important;padding:24px 0 0!important;border:0!important}
.pm-dashboard-heading{min-width:0}
.pm-eyebrow{margin:0;color:var(--md-muted)!important;font-size:10px!important;font-weight:700!important;letter-spacing:.08em!important;text-transform:uppercase}
.pm-dashboard-header h1{margin:5px 0 6px!important;color:var(--md-heading)!important;font-size:28px!important;line-height:1.2!important;font-weight:700!important;letter-spacing:-.015em!important}
.pm-dashboard-header p:not(.pm-eyebrow){margin:0!important;color:var(--md-muted)!important;font-size:13px!important}
.pm-header-actions{display:flex;align-items:center;gap:16px;flex-wrap:wrap;justify-content:flex-end}
.pm-header-date{display:flex;align-items:center;gap:8px;color:#67748e;font-size:12px;font-weight:500;white-space:nowrap}
.pm-date-dot{width:7px;height:7px;border-radius:50%;background:var(--md-success)}
.pm-dashboard-action{display:inline-flex;align-items:center;gap:7px;padding:10px 14px;border-radius:8px;background:linear-gradient(195deg,#ec407a,#d81b60);color:#fff!important;font-size:12px;font-weight:700;text-decoration:none}

/* KPI / analytics */
.pm-admin-kpi-grid,.pm-kpi-grid{display:grid;gap:18px;margin:0 0 20px}
.pm-admin-kpi-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
.pm-kpi-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
.pm-kpi{position:relative;display:flex;flex-direction:column;min-height:126px;padding:20px!important;background:#fff!important;border-radius:var(--md-radius)!important;box-shadow:var(--md-shadow)!important;text-decoration:none!important;overflow:hidden}
.pm-kpi-label{color:var(--md-muted)!important;font-size:10px!important;font-weight:700!important;letter-spacing:.06em;text-transform:uppercase}
.pm-kpi strong{margin-top:8px;color:var(--md-heading)!important;font-size:28px!important;line-height:1!important;font-weight:700!important}
.pm-kpi-note{margin-top:auto;color:#9aa0b5!important;font-size:11px!important}
.pm-kpi-primary strong{color:var(--md-primary)!important}
.pm-kpi-trend{position:absolute;top:20px;right:18px;color:var(--md-success);font-size:10px;font-weight:700}
.pm-analytics-grid{display:grid;grid-template-columns:minmax(0,1.55fr) minmax(0,1fr);gap:18px;margin-bottom:20px}
.pm-content-grid{display:grid;grid-template-columns:1fr;gap:20px}
.pm-panel,.pm-report-strip,.fi-section,.fi-ta-ctn,.fi-wi-widget,.fi-fo-component-ctn{background:#fff!important;border:0!important;border-radius:var(--md-radius)!important;box-shadow:var(--md-shadow)!important}
.pm-panel{overflow:hidden}
.pm-panel-heading,.pm-chart-heading{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:19px 20px;border-bottom:1px solid var(--md-border)}
.pm-panel-heading h2,.pm-chart-heading h2,.pm-focus-panel h2{margin:3px 0 0;color:var(--md-heading);font-size:16px;font-weight:700}
.pm-panel-heading a,.pm-chart-heading a,.pm-text-action{color:var(--md-primary);font-size:11px;font-weight:700;text-decoration:none}
.pm-chart-panel{min-height:330px;padding:0}
.pm-chart-heading{align-items:flex-start}
.pm-chart-heading span{display:block;margin-top:4px;color:#9aa0b5;font-size:11px}
.pm-bar-chart{display:grid;grid-template-columns:repeat(7,minmax(0,1fr));gap:12px;align-items:end;height:235px;padding:20px}
.pm-bar-item{display:flex;flex-direction:column;align-items:center;min-width:0;height:100%}
.pm-bar-value{margin-bottom:5px;color:#67748e;font-size:10px;font-weight:700}
.pm-bar-track{display:flex;align-items:flex-end;width:100%;max-width:28px;height:150px;overflow:hidden;border-radius:5px 5px 2px 2px;background:#f1f3f5}
.pm-bar-fill{width:100%;min-height:8px;border-radius:5px 5px 0 0;background:linear-gradient(180deg,#ec407a,#d81b60)}
.pm-bar-item strong{margin-top:8px;color:#67748e;font-size:10px}
.pm-bar-item small{margin-top:3px;color:#a0a5b5;font-size:8px}
.pm-pipeline-list{padding:22px 20px}
.pm-pipeline-row{margin-bottom:18px}
.pm-pipeline-label{display:flex;justify-content:space-between;margin-bottom:7px;color:#67748e;font-size:11px}
.pm-pipeline-label strong{color:#344767}
.pm-pipeline-track{height:6px;overflow:hidden;border-radius:5px;background:#f0f2f4}
.pm-pipeline-track span{display:block;height:100%;border-radius:5px;background:linear-gradient(90deg,#ec407a,#d81b60)}
.pm-pipeline-total{display:flex;align-items:center;gap:8px;padding:0 20px 20px;color:#9aa0b5;font-size:11px}
.pm-pipeline-total strong{color:var(--md-heading);font-size:20px}

/* Full-width task/data zone */
.pm-tasks-panel{width:100%}
.pm-task-row{display:flex;align-items:center;gap:12px;min-height:58px;padding:14px 20px;border-bottom:1px solid #f1f2f4}
.pm-task-row:hover{background:#fafbfc}
.pm-task-marker{width:8px;height:8px;flex:none;border-radius:50%;background:#fb8c00}
.pm-task-marker.done{background:var(--md-success)}
.pm-task-main{min-width:0;flex:1}
.pm-task-main strong{display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;color:#344767;font-size:13px;font-weight:500}
.pm-task-main span{display:block;margin-top:3px;color:#9aa0b5;font-size:11px}
.pm-status-chip,.pm-priority{padding:5px 8px;border-radius:6px;font-size:9px;font-weight:700;letter-spacing:.03em;text-transform:uppercase}
.pm-status-chip{background:#f1f3f5;color:#67748e}
.priority-high,.pm-priority-high{background:#ffebee;color:#c62828}
.priority-medium,.pm-priority-medium{background:#fff3e0;color:#ef6c00}
.priority-low,.pm-priority-low{background:#e3f2fd;color:#1565c0}
.pm-report-strip{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:20px;padding:18px 20px}
.pm-report-strip>div{display:flex;align-items:center;gap:13px}
.pm-report-strip>div>div{display:flex;flex-direction:column;gap:4px}
.pm-report-strip strong{color:var(--md-heading);font-size:13px}
.pm-report-strip span{color:#9aa0b5;font-size:11px}
.pm-report-strip a{color:var(--md-primary);font-size:11px;font-weight:700;text-decoration:none}
.pm-report-icon{display:grid;place-items:center;width:38px;height:38px;border-radius:10px;background:var(--md-primary-soft);color:var(--md-primary)!important;font-size:16px!important}

/* Filament surfaces/tables/forms use the same visual language without replacing Filament views. */
.fi-section,.fi-ta-ctn,.fi-wi-widget,.fi-fo-component-ctn{overflow:hidden!important}
.fi-section-header{padding:18px 20px!important}
.fi-section-header-heading,.fi-wi-widget-header,.fi-ta-text-item-label{color:var(--md-heading)!important;font-weight:700!important}
.fi-section-header-description,.fi-ta-text-item-description,.fi-wi-widget-header-description{color:var(--md-muted)!important}
.fi-ta-header{background:#fff!important;border-bottom:1px solid var(--md-border)!important}
.fi-ta-header-cell{padding:12px 16px!important;color:#7b809a!important;font-size:10px!important;font-weight:700!important;letter-spacing:.05em!important;text-transform:uppercase!important;background:#fafbfc!important}
.fi-ta-row{min-height:56px!important;background:#fff!important;border-color:#f0f1f3!important}
.fi-ta-row:hover{background:#fbfbfc!important}
.fi-ta-text-item-label{color:#344767!important;font-size:13px!important}
.fi-ta-text-item-description{color:#9aa0b5!important;font-size:11px!important}
.fi-ta-content{overflow-x:auto!important}
.fi-ta-table{min-width:700px!important}
.fi-input-wrp,.fi-select-input,.fi-fo-select .fi-input-wrp,.fi-fo-text-input .fi-input-wrp,.fi-fo-textarea .fi-input-wrp{min-height:42px!important;background:#fff!important;border:1px solid #dce0e5!important;border-radius:7px!important;box-shadow:none!important;color:#344767!important}
.fi-input-wrp:focus-within,.fi-fo-field-wrp:focus-within .fi-input-wrp{border-color:var(--md-primary)!important;box-shadow:0 0 0 2px rgba(233,30,99,.12)!important}
input,textarea,select,[contenteditable=true],.fi-input,.fi-select-input,.fi-fo-field-wrp input,.fi-fo-field-wrp textarea{font-family:Roboto,Arial,sans-serif!important;color:#344767!important;background:transparent!important;-webkit-text-fill-color:#344767!important;font-size:13px!important}
input::placeholder,textarea::placeholder{color:#9aa0b5!important}
.fi-btn{min-height:40px!important;border-radius:7px!important;font-family:Roboto,Arial,sans-serif!important;font-weight:500!important;box-shadow:none!important}
.fi-btn-color-primary{background:linear-gradient(195deg,#ec407a,#d81b60)!important;border:0!important;color:#fff!important;box-shadow:0 3px 6px rgba(233,30,99,.2)!important}
.fi-btn:not(.fi-btn-color-primary){background:#fff!important;border:1px solid #dce0e5!important;color:#344767!important}
.fi-modal-window{width:min(860px,calc(100vw - 32px))!important;max-width:860px!important;background:#fff!important;border-radius:12px!important;box-shadow:0 15px 40px rgba(0,0,0,.16)!important}
.fi-simple-layout{background:var(--md-bg)!important}
.fi-simple-main{background:#fff!important;border-radius:12px!important;box-shadow:var(--md-shadow)!important}

/* Staff attendance */
.pm-attendance-hero{display:flex;align-items:center;justify-content:space-between;gap:30px;padding:25px 28px;margin-bottom:20px;background:linear-gradient(195deg,#42424a,#191919)!important;border-radius:var(--md-radius)!important;color:#fff!important;box-shadow:var(--md-shadow)!important}
.pm-attendance-copy h2{margin:8px 0 5px;color:#fff;font-size:22px;font-weight:700}
.pm-attendance-copy>p{margin:0!important;color:#c5c8d0!important;font-size:12px!important}
.pm-status-line{display:flex;align-items:center;gap:8px;color:#bfc2c9;font-size:10px;font-weight:700;letter-spacing:.08em}
.pm-live-dot{width:7px;height:7px;border-radius:50%;background:var(--md-warning)}
.pm-live-dot.is-live{background:#66bb6a}
.pm-attendance-meta{display:flex;gap:28px;margin-top:18px}
.pm-attendance-meta span{display:flex;flex-direction:column;gap:2px}
.pm-attendance-meta strong{color:#fff;font-size:13px}
.pm-attendance-meta small{color:#9ea1aa;font-size:10px}
.pm-attendance-action{display:flex;flex-direction:column;align-items:flex-end;gap:8px}
.pm-clock-button{display:flex;align-items:center;justify-content:center;gap:9px;min-width:170px;padding:12px 16px;border:0;border-radius:8px;background:linear-gradient(195deg,#ec407a,#d81b60);color:#fff;font-size:12px;font-weight:700}
.pm-focus-panel{padding:22px;border-top:0!important}
.pm-focus-panel>p:not(.pm-eyebrow){color:var(--md-muted);font-size:13px;line-height:1.7}
.pm-focus-rule{height:1px;margin:20px 0;background:var(--md-border)}
.pm-quick-links{display:flex;flex-direction:column;margin-top:16px}
.pm-quick-links a{display:flex;justify-content:space-between;padding:12px 0;border-top:1px solid var(--md-border);color:#344767;font-size:12px;font-weight:500;text-decoration:none}
.pm-quick-links a span{color:var(--md-primary)}

/* Responsive */
@media(max-width:1100px){
    :root{--md-sidebar:230px;--md-gutter:20px}
    .pm-shell-sidebar{left:10px;top:10px;bottom:10px}
    .pm-shell-topbar{left:var(--md-sidebar);padding-inline:22px}
    .fi-main{padding-left:var(--md-sidebar)!important}
    .pm-admin-kpi-grid{grid-template-columns:repeat(2,minmax(0,1fr))}
    .pm-analytics-grid{grid-template-columns:1fr}
}
@media(max-width:760px){
    :root{--md-topbar:62px;--md-gutter:16px}
    .pm-shell-sidebar{left:0;top:0;bottom:0;width:285px;border-radius:0;transform:translateX(-100%);transition:transform .2s ease}
    .pm-shell-sidebar.is-open{transform:translateX(0)}
    .pm-sidebar-close,.pm-mobile-menu{display:block}
    .pm-shell-backdrop{position:fixed;z-index:95;inset:0;background:rgba(0,0,0,.28)}
    .pm-shell-topbar{left:0;height:var(--md-topbar);padding-inline:16px}
    .pm-shell-search,.pm-topbar-name{display:none}
    .fi-main{padding-left:0!important;padding-top:var(--md-topbar)!important}
    .fi-main-ctn{padding-inline:var(--md-gutter)!important}
    .fi-header{padding-top:18px!important}
    .pm-dashboard-header,.pm-attendance-hero{align-items:flex-start;flex-direction:column}
    .pm-header-actions,.pm-attendance-action{width:100%;align-items:stretch;justify-content:flex-start}
    .pm-admin-kpi-grid,.pm-kpi-grid{grid-template-columns:1fr}
    .pm-report-strip{align-items:flex-start;flex-direction:column}
    .pm-report-strip a{width:100%;text-align:right}
    .pm-bar-chart{gap:7px;padding-inline:12px}
    .pm-attendance-hero{padding:20px}
}
@media(max-width:480px){
    :root{--md-gutter:12px}
    .pm-dashboard-header h1{font-size:23px!important}
    .pm-panel-heading,.pm-chart-heading{padding-inline:16px}
    .pm-task-row{padding-inline:16px}
}
</style>