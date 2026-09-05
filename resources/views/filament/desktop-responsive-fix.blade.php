<style>
/* Final responsive guardrails. Layout sizing is defined by product-responsive; this layer
   only protects component boundaries from accidental overflow. */
html,
body {
    max-width: 100%;
}

.fi-page-content,
.fi-page-content > *,
.fi-section,
.fi-section-content,
.fi-ta-ctn,
.fi-wi-widget,
.fi-fo-component-ctn {
    min-width: 0 !important;
    max-width: 100% !important;
}

/* Tables own their horizontal scrolling when their data genuinely needs more width. */
.fi-ta-ctn {
    overflow-x: auto !important;
    overflow-y: visible !important;
    scrollbar-width: thin;
}

/* Long content must wrap within the component instead of expanding the workspace. */
.fi-page-content :where(.fi-ta-cell, .fi-section-header, .fi-fo-field-wrp, .fi-input-wrp) {
    min-width: 0 !important;
}

/* Resource actions always remain in the page canvas. */
.fi-header-actions,
.fi-header-actions > * {
    min-width: 0 !important;
    max-width: 100% !important;
}
</style>
