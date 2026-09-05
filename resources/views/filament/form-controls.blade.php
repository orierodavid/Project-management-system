{{-- Global form-control presentation. Behavior and validation remain owned by Filament. --}}
<style>
/* ================================================================
   GLOBAL FORM CONTROL STANDARD
   Light text-entry controls + dark selection controls.
   This is intentionally global so Task, User, Staff, Branch,
   Department, Settings and every other Filament form stay consistent.
   ================================================================ */

:root {
    --form-surface: #ffffff;
    --form-text: #1f2937;
    --form-muted: #667085;
    --form-border: #d0d5dd;
    --form-focus: #e91e63;
    --select-bg: #1f2937;
    --select-bg-hover: #111827;
    --select-text: #ffffff;
    --select-muted: #d1d5db;
}

/* Textbox + textarea: always light, always readable. */
input:not([type="checkbox"]):not([type="radio"]):not([type="range"]),
textarea,
[contenteditable="true"],
.fi-input,
.fi-fo-field-wrp input,
.fi-fo-field-wrp textarea,
.fi-fo-text-input input,
.fi-fo-textarea textarea {
    background: var(--form-surface) !important;
    color: var(--form-text) !important;
    -webkit-text-fill-color: var(--form-text) !important;
    caret-color: var(--form-focus) !important;
}

input:not([type="checkbox"]):not([type="radio"]):not([type="range"])::placeholder,
textarea::placeholder,
.fi-fo-field-wrp input::placeholder,
.fi-fo-field-wrp textarea::placeholder {
    color: var(--form-muted) !important;
    -webkit-text-fill-color: var(--form-muted) !important;
    opacity: 1 !important;
}

/* The actual text-entry wrappers stay light. */
.fi-input-wrp,
.fi-fo-text-input .fi-input-wrp,
.fi-fo-textarea .fi-input-wrp {
    background: var(--form-surface) !important;
    color: var(--form-text) !important;
    border-color: var(--form-border) !important;
}

/* Select/dropdown control: deliberately dark, with white text. */
select,
.fi-select-input,
.fi-fo-select .fi-input-wrp,
.fi-fo-select .fi-select-input,
.fi-fo-select button.fi-select-input {
    background: var(--select-bg) !important;
    color: var(--select-text) !important;
    -webkit-text-fill-color: var(--select-text) !important;
    border-color: var(--select-bg) !important;
}

select:hover,
.fi-select-input:hover,
.fi-fo-select .fi-input-wrp:hover,
.fi-fo-select .fi-select-input:hover {
    background: var(--select-bg-hover) !important;
    color: var(--select-text) !important;
    -webkit-text-fill-color: var(--select-text) !important;
}

select:focus,
.fi-select-input:focus,
.fi-fo-select .fi-input-wrp:focus-within,
.fi-fo-select:focus-within .fi-input-wrp {
    background: var(--select-bg-hover) !important;
    color: var(--select-text) !important;
    -webkit-text-fill-color: var(--select-text) !important;
    border-color: var(--form-focus) !important;
    box-shadow: 0 0 0 2px rgba(233, 30, 99, .16) !important;
}

/* Native option list must remain readable when the browser opens it. */
select option,
select optgroup {
    background: var(--select-bg) !important;
    color: var(--select-text) !important;
}

select option:checked,
select option:hover {
    background: var(--select-bg-hover) !important;
    color: var(--select-text) !important;
}

/* Filament's select/search text and icons on dark selection controls. */
.fi-fo-select .fi-select-input *,
.fi-fo-select .fi-input-wrp svg,
.fi-fo-select .fi-select-input svg {
    color: var(--select-text) !important;
    fill: currentColor !important;
}

.fi-fo-select .fi-input-wrp input,
.fi-fo-select .fi-select-input input {
    background: transparent !important;
    color: var(--select-text) !important;
    -webkit-text-fill-color: var(--select-text) !important;
}

.fi-fo-select .fi-input-wrp input::placeholder,
.fi-fo-select .fi-select-input input::placeholder {
    color: var(--select-muted) !important;
    -webkit-text-fill-color: var(--select-muted) !important;
}

/* Form labels, helper text and validation text stay legible on the light canvas. */
.fi-fo-field-wrp label,
.fi-fo-field-wrp-label,
.fi-fo-field-wrp-label span,
.fi-fo-field-wrp-helper-text,
.fi-fo-field-wrp-error-message {
    color: var(--form-text) !important;
}

.fi-fo-field-wrp-helper-text {
    color: var(--form-muted) !important;
}

/* Disabled controls retain contrast without reverting to white-on-white. */
input:disabled,
textarea:disabled,
select:disabled,
.fi-input:disabled,
.fi-select-input:disabled {
    opacity: .65 !important;
}

/* Never allow a dark-theme text color to make light entry fields unreadable. */
.fi-fo-text-input input,
.fi-fo-textarea textarea,
.fi-fo-field-wrp input:not([type="checkbox"]):not([type="radio"]),
.fi-fo-field-wrp textarea {
    color-scheme: light !important;
}

/* Select controls use dark color-scheme where supported by the browser. */
select,
.fi-select-input {
    color-scheme: dark !important;
}
</style>
