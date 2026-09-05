<style>
/* Modern form system — presentation only. No form behavior or workflow is changed. */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

:root{--pm-form-ink:#172033;--pm-form-muted:#7b8496;--pm-form-border:#d9dee8;--pm-form-focus:#2563eb;--pm-form-surface:#fff;--pm-form-soft:#f8fafc}

html,body,.fi-body,.fi-layout,.fi-main,.fi-page,.fi-page-content,.fi-modal-window,.fi-modal-window *{font-family:'Poppins',ui-sans-serif,system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif!important}

/* Clean, modern field labels */
.fi-fo-field-wrp-label,
.fi-fo-field-wrp-label span{font-family:'Poppins',sans-serif!important;color:var(--pm-form-ink)!important;font-size:11px!important;font-weight:600!important;letter-spacing:.01em!important}
.fi-fo-field-wrp-helper-text{color:var(--pm-form-muted)!important;font-size:10px!important;line-height:1.5!important}

/* Replace the old cramped field treatment with a crisp product-control surface. */
.fi-fo-field-wrp .fi-input-wrp{min-height:44px!important;background:var(--pm-form-surface)!important;border:1px solid var(--pm-form-border)!important;border-radius:9px!important;box-shadow:0 1px 2px rgba(15,23,42,.04)!important;transition:border-color .16s ease,box-shadow .16s ease,transform .16s ease!important;overflow:hidden!important}
.fi-fo-field-wrp .fi-input-wrp:hover{border-color:#b8c1cf!important}
.fi-fo-field-wrp .fi-input-wrp:focus-within{border-color:var(--pm-form-focus)!important;box-shadow:0 0 0 3px rgba(37,99,235,.10)!important}

/* Inputs, selects and textareas: force readable text and caret. */
.fi-fo-field-wrp input,
.fi-fo-field-wrp select,
.fi-fo-field-wrp textarea,
.fi-input-wrp input,
.fi-input-wrp select,
.fi-input-wrp textarea,
.fi-input,
.fi-select,
.fi-textarea,
.fi-fo-text-input,
.fi-fo-select,
.fi-fo-textarea{
  color:var(--pm-form-ink)!important;
  background:transparent!important;
  opacity:1!important;
  -webkit-text-fill-color:var(--pm-form-ink)!important;
  caret-color:var(--pm-form-focus)!important;
  font-family:'Poppins',sans-serif!important;
  font-size:12px!important;
  font-weight:500!important;
  line-height:1.5!important;
}

.fi-fo-field-wrp input::placeholder,
.fi-fo-field-wrp textarea::placeholder,
.fi-input-wrp input::placeholder,
.fi-input-wrp textarea::placeholder{color:#a0a8b7!important;opacity:1!important;-webkit-text-fill-color:#a0a8b7!important}

/* Select controls */
.fi-fo-field-wrp select{min-height:42px!important;padding-left:13px!important;padding-right:38px!important;cursor:pointer!important}
.fi-fo-field-wrp .fi-select{min-height:42px!important}

/* Textarea gets real writing space and a contemporary editor feel. */
.fi-fo-field-wrp textarea,
.fi-input-wrp textarea,
textarea.fi-textarea,
.fi-fo-textarea textarea{
  min-height:156px!important;
  height:156px!important;
  padding:13px 14px!important;
  resize:vertical!important;
  line-height:1.7!important;
  vertical-align:top!important;
  overflow-y:auto!important;
}

/* Filament rich text / Tiptap-style editors */
.fi-fo-rich-editor,
.fi-fo-rich-editor .tiptap,
.fi-fo-rich-editor [contenteditable="true"],
.fi-rich-editor,
.fi-rich-editor [contenteditable="true"]{
  color:var(--pm-form-ink)!important;
  background:#fff!important;
  font-family:'Poppins',sans-serif!important;
  font-size:12px!important;
  line-height:1.7!important;
  caret-color:var(--pm-form-focus)!important;
  -webkit-text-fill-color:var(--pm-form-ink)!important;
}
.fi-fo-rich-editor [contenteditable="true"],
.fi-rich-editor [contenteditable="true"]{min-height:156px!important;padding:13px 14px!important;outline:none!important}
.fi-fo-rich-editor [contenteditable="true"]:focus,
.fi-rich-editor [contenteditable="true"]:focus{background:#fff!important}

/* Task create/edit modal — stronger hierarchy, no glassmorphism. */
.fi-modal-window{width:min(780px,calc(100vw - 32px))!important;max-width:780px!important;background:#fff!important;border:1px solid #e3e7ee!important;border-radius:14px!important;box-shadow:0 24px 70px rgba(15,23,42,.16)!important;overflow:hidden!important}
.fi-modal-header{padding:20px 24px!important;background:#fff!important;border-bottom:1px solid #edf0f4!important}
.fi-modal-content{padding:22px 24px!important;background:#fff!important}
.fi-modal-footer{padding:15px 24px!important;background:#fafbfc!important;border-top:1px solid #edf0f4!important}
.fi-modal-header-heading{color:var(--pm-form-ink)!important;font-size:18px!important;font-weight:700!important;letter-spacing:-.02em!important}

/* Form layout rhythm */
.fi-modal-content .fi-fo-component-ctn{gap:16px!important}
.fi-modal-content .fi-fo-field-wrp{gap:6px!important}
.fi-modal-content .fi-fo-field-wrp + .fi-fo-field-wrp{margin-top:2px!important}

/* Multi-select / relationship controls */
.fi-fo-field-wrp .fi-input-wrp:has(input[type="search"]){min-height:44px!important}
.fi-fo-field-wrp .fi-badge{font-family:'Poppins',sans-serif!important;font-size:10px!important;font-weight:600!important;border-radius:6px!important}

/* Modern action buttons */
.fi-modal-footer .fi-btn,
.fi-modal-content .fi-btn{min-height:40px!important;border-radius:8px!important;font-family:'Poppins',sans-serif!important;font-size:11px!important;font-weight:600!important;letter-spacing:.01em!important}

@media(max-width:760px){
  .fi-modal-window{width:calc(100vw - 20px)!important;max-width:none!important;border-radius:12px!important}
  .fi-modal-header{padding:17px 16px!important}
  .fi-modal-content{padding:17px 16px!important}
  .fi-modal-footer{padding:13px 16px!important}
  .fi-fo-field-wrp textarea,.fi-input-wrp textarea,textarea.fi-textarea,.fi-fo-textarea textarea,.fi-fo-rich-editor [contenteditable="true"],.fi-rich-editor [contenteditable="true"]{min-height:135px!important;height:135px!important}
}
</style>
