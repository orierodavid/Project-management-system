<style>
/* Global contrast + component normalization. Keep light surfaces readable everywhere. */
:root{--pm-text:#101828;--pm-text-2:#344054;--pm-muted-2:#667085;--pm-surface-2:#fff;--pm-border-2:#e4e7ec}

/* Light surfaces must never inherit Filament's white text. */
.fi-main,.fi-main-ctn,.fi-section,.fi-section-content,.fi-ta-ctn,.fi-ta-content,.fi-ta-table,.fi-fo-component-ctn,.fi-fo-field-wrp,.fi-modal-window,.fi-modal-content,.fi-dropdown-panel,.fi-popover,.fi-select-content,.fi-user-menu{color:var(--pm-text)!important}
.fi-section *,.fi-ta-ctn *,.fi-fo-component-ctn *,.fi-modal-window *,.fi-dropdown-panel *,.fi-popover *{--tw-text-opacity:1}
.fi-ta-row,.fi-ta-cell,.fi-ta-text,.fi-ta-text-item,.fi-ta-text-item-label,.fi-ta-text-item-description,.fi-fo-field-wrp-label,.fi-fo-field-wrp-label span,.fi-fo-field-wrp-hint,.fi-section-header-heading,.fi-section-header-description{color:var(--pm-text)!important}
.fi-ta-text-item-description,.fi-fo-field-wrp-hint,.fi-section-header-description{color:var(--pm-muted-2)!important}
.fi-ta-header-cell{color:var(--pm-muted-2)!important}
.fi-ta-row a:not(.fi-btn),.fi-ta-row button:not(.fi-btn),.fi-section a:not(.fi-btn),.fi-dropdown-panel a:not(.fi-btn){color:var(--pm-text-2)!important}
.fi-ta-row a:not(.fi-btn):hover,.fi-section a:not(.fi-btn):hover,.fi-dropdown-panel a:not(.fi-btn):hover{color:#2563eb!important}

/* Inputs, selects, textareas and searchable dropdowns. */
.fi-input,.fi-select,.fi-textarea,.fi-fo-text-input input,.fi-fo-textarea textarea,.fi-fo-select button,.fi-fo-tags-input{background:#fff!important;color:var(--pm-text)!important;border-color:#d0d5dd!important}
.fi-input::placeholder,.fi-textarea::placeholder,.fi-fo-text-input input::placeholder,.fi-fo-textarea textarea::placeholder{color:#98a2b3!important;opacity:1!important}
.fi-fo-select button span,.fi-fo-select button svg,.fi-select-option,.fi-select-option span,.fi-dropdown-list-item,.fi-dropdown-list-item span{color:var(--pm-text-2)!important}
.fi-select-option:hover,.fi-dropdown-list-item:hover{background:#f2f4f7!important}
.fi-select-option[aria-selected=true],.fi-dropdown-list-item[aria-selected=true]{background:#eff6ff!important;color:#1d4ed8!important}

/* Checkboxes/radios/toggles keep labels readable. */
.fi-checkbox-list-option-label,.fi-radio-list-option-label,.fi-toggle-label{color:var(--pm-text-2)!important}

/* Tables: predictable alignment, spacing and contrast. */
.fi-ta-header{background:#f8fafc!important}
.fi-ta-header-cell{padding-top:13px!important;padding-bottom:13px!important}
.fi-ta-cell{padding-top:14px!important;padding-bottom:14px!important;vertical-align:middle!important}
.fi-ta-row{background:#fff!important}
.fi-ta-row:hover{background:#f8fafc!important}
.fi-ta-text{font-size:13px!important;line-height:1.45!important}
.fi-ta-actions{gap:6px!important}
.fi-ta-pagination{border-top:1px solid var(--pm-border-2)!important}

/* Keep action buttons intentionally white-on-blue only when they are primary. */
.fi-btn:not(.fi-btn-color-primary):not([class*="danger"]){color:#344054!important;background:#fff!important}
.fi-btn-color-primary,.fi-btn-color-primary *{color:#fff!important}

/* Dark navigation/topbar is the deliberate exception. */
.fi-sidebar,.fi-sidebar *,.fi-topbar,.fi-topbar *{color:inherit}
.fi-sidebar .fi-sidebar-item-button,.fi-sidebar .fi-sidebar-item-button *{color:#9ca3af!important}
.fi-sidebar .fi-sidebar-item-active .fi-sidebar-item-button,.fi-sidebar .fi-sidebar-item-active .fi-sidebar-item-button *{color:#fff!important}

/* Modal/dropdown surfaces must always have dark text on white. */
.fi-modal-window,.fi-modal-window .fi-modal-header,.fi-modal-window .fi-modal-content,.fi-dropdown-panel,.fi-popover,.fi-user-menu{background:#fff!important;color:var(--pm-text)!important}
.fi-modal-window h1,.fi-modal-window h2,.fi-modal-window h3,.fi-modal-window p,.fi-modal-window label,.fi-dropdown-panel label,.fi-dropdown-panel span,.fi-user-menu span{color:var(--pm-text-2)!important}

/* Responsive tables: avoid clipped labels and preserve readable density. */
@media(max-width:900px){.fi-ta-table{min-width:720px}.fi-ta-content{overflow-x:auto}.fi-header-heading{font-size:24px!important}.fi-section{border-radius:10px!important}}
@media(max-width:640px){.fi-ta-cell{padding:11px 10px!important}.fi-ta-header-cell{padding:11px 10px!important}.fi-header{padding-bottom:16px!important}.fi-header-heading{font-size:22px!important}}
</style>
