<style>
/* Global responsive layout system. Presentation only: no resource, route, permission or workflow changes. */
html,
body {
    width: 100%;
    max-width: 100%;
    margin: 0;
}

*,
*::before,
*::after {
    box-sizing: border-box;
}

/* The custom shell owns the viewport. The content width must be calculated after the sidebar,
   rather than being 100% plus a sidebar margin. This is the primary desktop overflow fix. */
.fi-layout,
.fi-body,
.fi-main {
    width: 100% !important;
    min-width: 0 !important;
    max-width: 100% !important;
}

.fi-main {
    margin-left: var(--pm-shell-sidebar) !important;
    width: calc(100% - var(--pm-shell-sidebar)) !important;
    max-width: calc(100% - var(--pm-shell-sidebar)) !important;
    overflow-x: clip !important;
}

.fi-main-ctn {
    width: 100% !important;
    min-width: 0 !important;
    max-width: none !important;
    margin: 0 !important;
    padding-left: clamp(16px, 2.5vw, 36px) !important;
    padding-right: clamp(16px, 2.5vw, 36px) !important;
    overflow-x: clip !important;
}

.fi-page,
.fi-page-content,
.fi-header {
    width: 100% !important;
    min-width: 0 !important;
    max-width: 1440px !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

.fi-page-content {
    overflow: visible !important;
}

/* Every direct content child must respect the page's available width. */
.fi-page-content > *,
.fi-page-content > * > * {
    min-width: 0;
    max-width: 100%;
}

/* Resource headers are fluid: title consumes remaining space and actions are allowed to wrap. */
.fi-header {
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: flex-start !important;
    gap: 16px 24px !important;
    padding-top: 26px !important;
}

.fi-header > * {
    min-width: 0 !important;
    max-width: 100% !important;
}

.fi-header-heading {
    flex: 1 1 280px !important;
    min-width: 0 !important;
}

.fi-header-actions {
    flex: 0 1 auto !important;
    min-width: 0 !important;
    max-width: 100% !important;
}

.fi-header-actions > div,
.fi-header-actions > section,
.fi-actions,
.fi-ac-btn-group {
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 8px !important;
    min-width: 0 !important;
    max-width: 100% !important;
}

.fi-header-actions .fi-btn,
.fi-actions .fi-btn,
.fi-ac-btn-group .fi-btn {
    flex: 0 0 auto !important;
    max-width: 100% !important;
    white-space: nowrap;
}

/* Tables, grids and sections cannot expand their parent workspace. */
.fi-section,
.fi-section-content,
.fi-ta-ctn,
.fi-ta-content,
.fi-wi-widget,
.fi-fo-component-ctn {
    width: 100% !important;
    min-width: 0 !important;
    max-width: 100% !important;
}

.fi-ta-ctn {
    overflow-x: auto !important;
    overflow-y: visible !important;
    -webkit-overflow-scrolling: touch;
}

.fi-ta-table {
    max-width: none !important;
}

/* Forms: let Filament grids shrink instead of forcing the page wider. */
.fi-fo-component-ctn,
.fi-fo-component-ctn > div,
.fi-fo-grid,
.fi-grid {
    min-width: 0 !important;
    max-width: 100% !important;
}

/* Prevent long labels, URLs and action content from becoming layout-wide overflow. */
.fi-page-content :where(h1,h2,h3,h4,h5,h6,p,span,label,button,a) {
    max-width: 100%;
}

/* Tablet / compact desktop: dedicate a full row to page actions. */
@media (max-width: 1100px) and (min-width: 761px) {
    :root { --pm-shell-sidebar: 232px; }

    .fi-main {
        margin-left: var(--pm-shell-sidebar) !important;
        width: calc(100% - var(--pm-shell-sidebar)) !important;
        max-width: calc(100% - var(--pm-shell-sidebar)) !important;
    }

    .fi-header {
        gap: 12px 18px !important;
    }

    .fi-header-actions {
        flex: 1 1 100% !important;
        width: 100% !important;
    }

    .fi-header-actions > div,
    .fi-actions,
    .fi-ac-btn-group {
        justify-content: flex-start !important;
    }
}

/* Phone: sidebar becomes an overlay and the content receives the entire viewport. */
@media (max-width: 760px) {
    .fi-main {
        margin-left: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        padding-top: var(--pm-shell-top) !important;
    }

    .fi-main-ctn {
        padding-left: 16px !important;
        padding-right: 16px !important;
    }

    .fi-header {
        padding-top: 18px !important;
        gap: 12px !important;
    }

    .fi-header-heading,
    .fi-header-actions {
        flex: 1 1 100% !important;
        width: 100% !important;
    }

    .fi-header-actions > div,
    .fi-actions,
    .fi-ac-btn-group {
        justify-content: flex-start !important;
        width: 100% !important;
    }
}

@media (max-width: 480px) {
    .fi-main-ctn {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }

    .fi-header {
        padding-top: 14px !important;
    }

    .fi-header-actions .fi-btn,
    .fi-actions .fi-btn,
    .fi-ac-btn-group .fi-btn {
        max-width: 100% !important;
    }
}
</style>
