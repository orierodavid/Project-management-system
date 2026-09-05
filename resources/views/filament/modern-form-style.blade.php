<style>
/* Modern global form system — presentation only. No form behavior or workflow is changed. */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

:root{--pm-form-ink:#172033;--pm-form-muted:#7b8496;--pm-form-border:#d9dee8;--pm-form-focus:#2563eb;--pm-form-surface:#fff;--pm-form-soft:#f8fafc;--pm-form-disabled:#f1f4f8}

html,body,.fi-body,.fi-layout,.fi-main,.fi-page,.fi-page-content,.fi-modal-window,.fi-modal-window *{font-family:'Poppins',ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif!important}

/* GLOBAL FIELD LABEL SYSTEM */
.fi-fo-field-wrp{min-width:0!important}
.fi-fo-field-wrp-label,.fi-fo-field-wrp-label span{font-family:'Poppins',sans-serif!important;color:var(--pm-form-ink)!important;font-size:11px!important;font-weight:600!important;letter-spacing:.01em!important;line-height:1.35!important}
.fi-fo-field-wrp-helper-text{color:var(--pm-form-muted)!important;font-size:10px!important;line-height:1.5!important}
.fi-fo-field-wrp-error-message{font-family:'Poppins',sans-serif!important;font-size:10px!important;font-weight:500!important;line-height:1.45!important}

/* ONE CONTROL LANGUAGE FOR TEXT, SELECT, DATE, SEARCH AND RELATIONSHIP FIELDS */
.fi-fo-field-wrp .fi-input-wrp,
.fi-fo-field-wrp .fi-select,
.fi-fo-field-wrp .fi-date-time-picker,
.fi-fo-field-wrp .fi-date-picker{min-height:44px!important;background:var(--pm-form-surface)!important;border:1px solid var(--pm-form-border)!important;border-radius:10px!important;box-shadow:0 1px 2px rgba(15,23,42,.04)!important;transition:border-color .16s ease,box-shadow .16s ease,background .16s ease!important}
.fi-fo-field-wrp .fi-input-wrp:hover,.fi-fo-field-wrp .fi-select:hover{border-color:#b8c1cf!important}
.fi-fo-field-wrp .fi-input-wrp:focus-within,.fi-fo-field-wrp .fi-select:focus-within{border-color:var(--pm-form-focus)!important;box-shadow:0 0 0 3px rgba(37,99,235,.10)!important}

/* READABLE CONTROL TEXT + CARET */
.fi-fo-field-wrp input,.fi-fo-field-wrp select,.fi-fo-field-wrp textarea,
.fi-input-wrp input,.fi-input-wrp select,.fi-input-wrp textarea,
.fi-input,.fi-select,.fi-textarea,.fi-fo-text-input,.fi-fo-select,.fi-fo-textarea{
color:var(--pm-form-ink)!important;background:transparent!important;opacity:1!important;-webkit-text-fill-color:var(--pm-form-ink)!important;caret-color:var(--pm-form-focus)!important;font-family:'Poppins',sans-serif!important;font-size:12px!important;font-weight:500!important;line-height:1.5!important}

.fi-fo-field-wrp input::placeholder,.fi-fo-field-wrp textarea::placeholder,.fi-input-wrp input::placeholder,.fi-input-wrp textarea::placeholder,.fi-input::placeholder,.fi-textarea::placeholder{color:#9aa3b2!important;opacity:1!important;-webkit-text-fill-color:#9aa3b2!important}
.fi-fo-field-wrp input:disabled,.fi-fo-field-wrp select:disabled,.fi-fo-field-wrp textarea:disabled{background:var(--pm-form-disabled)!important;color:#98a2b3!important;cursor:not-allowed!important}

/* SELECTS / SEARCHABLE SELECTS */
.fi-fo-field-wrp select{min-height:42px!important;padding:0 38px 0 13px!important;cursor:pointer!important}
.fi-fo-field-wrp .fi-select{min-height:44px!important;cursor:pointer!important}
.fi-fo-field-wrp .fi-select [role="option"],.fi-dropdown-list-item{font-family:'Poppins',sans-serif!important;font-size:12px!important;font-weight:500!important;line-height:1.35!important}
.fi-dropdown-list-item{min-height:40px!important;padding:9px 12px!important;border-radius:7px!important}
.fi-dropdown-panel{border:1px solid #e2e7ef!important;border-radius:11px!important;background:#fff!important;box-shadow:0 18px 48px rgba(15,23,42,.14)!important}

/* GLOBAL TABLE SEARCH + FILTER TOOLBAR: keep search and dropdown/filter controls on one product-style row. */
.fi-ta-header-toolbar{display:flex!important;align-items:center!important;justify-content:space-between!important;gap:10px!important;flex-wrap:wrap!important;min-width:0!important}
.fi-ta-header-toolbar > *{min-width:0!important}
.fi-ta-search-field{flex:1 1 260px!important;min-width:220px!important;max-width:560px!important}
.fi-ta-search-field .fi-input-wrp{min-height:42px!important;background:#fff!important;border:1px solid var(--pm-form-border)!important;border-radius:9px!important;box-shadow:0 1px 2px rgba(15,23,42,.04)!important}
.fi-ta-search-field input{font-family:'Poppins',sans-serif!important;color:var(--pm-form-ink)!important;font-size:12px!important;font-weight:500!important;background:transparent!important}
.fi-ta-search-field input::placeholder{color:#9aa3b2!important;opacity:1!important}
.fi-ta-filters-trigger,.fi-ta-header-toolbar .fi-btn{min-height:42px!important;border-radius:9px!important;font-family:'Poppins',sans-serif!important;font-size:11px!important;font-weight:600!important}
.fi-ta-filters-trigger{border:1px solid var(--pm-form-border)!important;background:#fff!important;color:var(--pm-form-ink)!important;box-shadow:0 1px 2px rgba(15,23,42,.04)!important}
.fi-ta-filters-trigger:hover{border-color:#b8c1cf!important;background:#fafbfc!important}
.fi-ta-filters{min-width:0!important}
.fi-ta-filters-form{font-family:'Poppins',sans-serif!important}
.fi-ta-filters-form .fi-fo-field-wrp .fi-input-wrp,.fi-ta-filters-form .fi-fo-field-wrp .fi-select{min-height:42px!important}
.fi-ta-filters-form .fi-fo-field-wrp input,.fi-ta-filters-form .fi-fo-field-wrp select{font-size:11px!important}
.fi-ta-filters-form .fi-fo-field-wrp-label{font-size:10px!important}

/* MULTISELECT / RELATIONSHIP CHIPS */
.fi-fo-field-wrp .fi-badge,.fi-fo-field-wrp [data-selected="true"]{font-family:'Poppins',sans-serif!important;font-size:10px!important;font-weight:600!important;border-radius:7px!important}
.fi-fo-field-wrp .fi-input-wrp:has(input[type="search"]){min-height:44px!important}

/* TEXTAREAS + RICH TEXT */
.fi-fo-field-wrp textarea,.fi-input-wrp textarea,textarea.fi-textarea,.fi-fo-textarea textarea{min-height:156px!important;height:156px!important;padding:13px 14px!important;resize:vertical!important;line-height:1.7!important;vertical-align:top!important;overflow-y:auto!important}
.fi-fo-rich-editor,.fi-fo-rich-editor .tiptap,.fi-fo-rich-editor [contenteditable="true"],.fi-rich-editor,.fi-rich-editor [contenteditable="true"]{color:var(--pm-form-ink)!important;background:#fff!important;font-family:'Poppins',sans-serif!important;font-size:12px!important;line-height:1.7!important;caret-color:var(--pm-form-focus)!important;-webkit-text-fill-color:var(--pm-form-ink)!important}
.fi-fo-rich-editor [contenteditable="true"],.fi-rich-editor [contenteditable="true"]{min-height:156px!important;padding:13px 14px!important;outline:none!important}
.fi-fo-rich-editor [contenteditable="true"]:focus,.fi-rich-editor [contenteditable="true"]:focus{background:#fff!important}

/* CHECKBOXES / RADIOS / TOGGLES — MODERN COMPACT CONTROLS */
.fi-fo-field-wrp input[type="checkbox"],.fi-fo-field-wrp input[type="radio"]{accent-color:var(--pm-form-focus)!important}
.fi-fo-field-wrp .fi-checkbox-list,.fi-fo-field-wrp .fi-radio-list{gap:8px!important}
.fi-fo-field-wrp .fi-checkbox-label,.fi-fo-field-wrp .fi-radio-label{font-family:'Poppins',sans-serif!important;font-size:12px!important;font-weight:500!important;color:var(--pm-form-ink)!important}
.fi-fo-field-wrp [role="switch"]{border-radius:999px!important}

/* FILE UPLOAD / DRAG-DROP */
.fi-fo-field-wrp .fi-fo-file-upload,.fi-fo-field-wrp [data-slot="file-upload"]{border:1px dashed #cbd3df!important;border-radius:10px!important;background:var(--pm-form-soft)!important;font-family:'Poppins',sans-serif!important;transition:border-color .16s ease,background .16s ease!important}
.fi-fo-field-wrp .fi-fo-file-upload:hover,.fi-fo-field-wrp [data-slot="file-upload"]:hover{border-color:var(--pm-form-focus)!important;background:#f8fbff!important}

/* DATE / TIME PICKERS */
.fi-fo-field-wrp [data-datepicker],.fi-fo-field-wrp [role="dialog"]{font-family:'Poppins',sans-serif!important}
.fi-fo-field-wrp [data-datepicker] button,.fi-fo-field-wrp [role="dialog"] button{font-family:'Poppins',sans-serif!important}

/* MODERN FORM LAYOUT RHYTHM */
.fi-fo-component-ctn{min-width:0!important}
.fi-fo-grid{min-width:0!important}
.fi-fo-field-wrp + .fi-fo-field-wrp{margin-top:2px!important}

/* MODERN MODALS */
.fi-modal-window{width:min(780px,calc(100vw - 32px))!important;max-width:780px!important;background:#fff!important;border:1px solid #e3e7ee!important;border-radius:14px!important;box-shadow:0 24px 70px rgba(15,23,42,.16)!important;overflow:hidden!important}
.fi-modal-header{padding:20px 24px!important;background:#fff!important;border-bottom:1px solid #edf0f4!important}
.fi-modal-content{padding:22px 24px!important;background:#fff!important}
.fi-modal-footer{padding:15px 24px!important;background:#fafbfc!important;border-top:1px solid #edf0f4!important}
.fi-modal-header-heading{color:var(--pm-form-ink)!important;font-size:18px!important;font-weight:700!important;letter-spacing:-.02em!important}
.fi-modal-footer .fi-btn,.fi-modal-content .fi-btn{min-height:40px!important;border-radius:8px!important;font-family:'Poppins',sans-serif!important;font-size:11px!important;font-weight:600!important;letter-spacing:.01em!important}

/* FOCUS SYSTEM */
:where(button,a,input,select,textarea,[contenteditable="true"]):focus-visible{outline:2px solid rgba(37,99,235,.45)!important;outline-offset:2px!important}

/* MOBILE */
@media(max-width:760px){
.fi-ta-header-toolbar{align-items:stretch!important;gap:8px!important}
.fi-ta-search-field{flex:1 1 100%!important;max-width:none!important;min-width:0!important}
.fi-ta-header-toolbar .fi-btn,.fi-ta-filters-trigger{flex:0 0 auto!important}
.fi-modal-window{width:calc(100vw - 20px)!important;max-width:none!important;border-radius:12px!important}
.fi-modal-header{padding:17px 16px!important}.fi-modal-content{padding:17px 16px!important}.fi-modal-footer{padding:13px 16px!important}
.fi-fo-field-wrp .fi-input-wrp,.fi-fo-field-wrp .fi-select{min-height:42px!important}
.fi-fo-field-wrp textarea,.fi-input-wrp textarea,textarea.fi-textarea,.fi-fo-textarea textarea,.fi-fo-rich-editor [contenteditable="true"],.fi-rich-editor [contenteditable="true"]{min-height:135px!important;height:135px!important}
}
</style>
