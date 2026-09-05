<style>
/* Desktop workspace guardrails: keep Filament headers/actions inside the usable canvas. */
html, body {
    overflow-x: hidden !important;
}

.fi-main,
.fi-main-ctn,
.fi-page,
.fi-page-content,
.fi-header {
    min-width: 0 !important;
    max-width: 100% !important;
}

.fi-main-ctn {
    overflow-x: hidden !important;
}

.fi-page-content {
    overflow-x: visible !important;
}

/* Resource page header: title and actions may share a row, but actions must never
   force the page wider than the viewport/workspace. */
.fi-header {
    display: flex !important;
    align-items: flex-start !important;
    justify-content: space-between !important;
    gap: 20px !important;
    flex-wrap: wrap !important;
}

.fi-header-heading {
    min-width: 0 !important;
    flex: 1 1 320px !important;
}

.fi-header-actions,
.fi-header > div:last-child {
    min-width: 0 !important;
    max-width: 100% !important;
    flex: 0 1 auto !important;
}

.fi-header-actions > *,
.fi-header > div:last-child > * {
    max-width: 100% !important;
}

/* Filament action groups should wrap instead of disappearing beyond the right edge. */
.fi-ac-btn-group,
.fi-actions,
.fi-header-actions > div,
.fi-header > div:last-child > div {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
    min-width: 0 !important;
    max-width: 100% !important;
}

/* Tables remain usable on narrower desktop widths: scroll the table itself, not the page. */
.fi-ta-ctn {
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    overflow-x: auto !important;
}

.fi-ta-table {
    max-width: 100% !important;
}

/* Keep row/action content from creating an invisible page-wide overflow. */
.fi-ta-content,
.fi-ta-ctn > div,
.fi-section-content {
    min-width: 0 !important;
    max-width: 100% !important;
}

@media (max-width: 1100px) {
    .fi-header {
        gap: 14px !important;
    }

    .fi-header-actions,
    .fi-header > div:last-child {
        flex: 1 1 100% !important;
        width: 100% !important;
    }

    .fi-header-actions > div,
    .fi-header > div:last-child > div {
        justify-content: flex-start !important;
    }
}

@media (max-width: 640px) {
    .fi-header-actions,
    .fi-header > div:last-child,
    .fi-header-actions > div,
    .fi-header > div:last-child > div {
        width: 100% !important;
    }

    .fi-header-actions .fi-btn,
    .fi-header > div:last-child .fi-btn {
        max-width: 100% !important;
    }
}
</style>
