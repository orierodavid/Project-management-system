<style>
/* Global foreground contract: presentation only. */
:root{--pm-control-text:#111827;--pm-control-muted:#4b5563}
/* Native fields and Filament wrappers */
.fi-fo-field-wrp input,.fi-fo-field-wrp textarea,.fi-fo-field-wrp select,.fi-input-wrp input,.fi-input-wrp textarea,.fi-input-wrp select,.fi-select input,.fi-date-time-picker input{color:var(--pm-control-text)!important;-webkit-text-fill-color:var(--pm-control-text)!important;opacity:1!important}
/* Choices / searchable selects rendered through portals */
.fi-select-content,.fi-select-content *,.fi-select-content-ctn,.fi-select-content-ctn *,.fi-dropdown-panel,.fi-dropdown-panel *,.choices,.choices *,.choices__list,.choices__item,.choices__input{color:var(--pm-control-text)!important;-webkit-text-fill-color:var(--pm-control-text)!important;opacity:1!important;text-shadow:none!important}
.fi-select-content input,.fi-select-content-ctn input,.fi-dropdown-panel input,.choices__input{background:#fff!important;color:#111827!important;-webkit-text-fill-color:#111827!important}
.fi-select-content [role="option"],.fi-select-content-ctn [role="option"],.fi-dropdown-list-item,.choices__item{color:#111827!important}
.fi-select-content [role="option"] svg,.fi-select-content-ctn [role="option"] svg,.fi-dropdown-list-item svg,.choices__item svg{color:#111827!important;stroke:#111827!important;opacity:1!important}
/* Date picker: every textual surface is explicitly dark on white. */
.flatpickr-calendar,.flatpickr-calendar *,.fi-date-time-picker-panel,.fi-date-time-picker-panel *,.fi-date-picker-panel,.fi-date-picker-panel *{color:#111827!important;-webkit-text-fill-color:#111827!important;opacity:1!important;text-shadow:none!important}
.flatpickr-calendar,.flatpickr-months,.flatpickr-month,.flatpickr-current-month,.flatpickr-weekdays,.flatpickr-weekday,.flatpickr-days,.flatpickr-day,.flatpickr-time,.flatpickr-time input{background:#fff!important}
.flatpickr-weekday{color:#374151!important}.flatpickr-day{color:#111827!important}.flatpickr-day.prevMonthDay,.flatpickr-day.nextMonthDay{color:#9ca3af!important}.flatpickr-day.selected,.flatpickr-day.startRange,.flatpickr-day.endRange{background:#2563eb!important;border-color:#2563eb!important;color:#fff!important;-webkit-text-fill-color:#fff!important}.flatpickr-day.selected *,.flatpickr-day.startRange *,.flatpickr-day.endRange *{color:#fff!important;-webkit-text-fill-color:#fff!important}
/* Generic popovers/dialogs used by newer Filament controls. */
[data-floating-ui-portal] [role="option"],[data-floating-ui-portal] input,[data-floating-ui-portal] button,[data-popper-placement] [role="option"],[data-popper-placement] input,[data-popper-placement] button{color:#111827!important;-webkit-text-fill-color:#111827!important;opacity:1!important}
</style>
