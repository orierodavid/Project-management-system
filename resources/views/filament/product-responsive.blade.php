<style>
/* Responsive product canvas: keep every Filament page centered inside the available workspace. */
.fi-main,
.fi-main-ctn,
.fi-page,
.fi-page-content {
    width: 100% !important;
    min-width: 0 !important;
}

.fi-main-ctn {
    max-width: none !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    padding-top: 0 !important;
}

.fi-page {
    max-width: 1440px !important;
    margin-left: auto !important;
    margin-right: auto !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
}

.fi-page-content {
    max-width: 1440px !important;
    margin-left: auto !important;
    margin-right: auto !important;
}

/* Give the page a real centered canvas instead of inheriting Filament's old shell offsets. */
@media (min-width: 761px) {
    .fi-main-ctn {
        padding-left: clamp(20px, 3vw, 40px) !important;
        padding-right: clamp(20px, 3vw, 40px) !important;
    }

    .fi-page,
    .fi-page-content {
        width: min(100%, 1440px) !important;
    }
}

/* Tablet: use the custom navigation as an overlay rather than squeezing the workspace. */
@media (max-width: 1024px) and (min-width: 761px) {
    :root {
        --pm-shell-sidebar: 232px;
    }

    .fi-main {
        margin-left: var(--pm-shell-sidebar) !important;
    }

    .fi-main-ctn {
        padding-left: 20px !important;
        padding-right: 20px !important;
    }

    .fi-page,
    .fi-page-content {
        max-width: 100% !important;
    }
}

/* Phone: full-width workspace with a proper off-canvas navigation. */
@media (max-width: 760px) {
    .fi-main {
        width: 100% !important;
        margin-left: 0 !important;
        padding-top: var(--pm-shell-top) !important;
    }

    .fi-main-ctn {
        width: 100% !important;
        padding: 0 16px !important;
    }

    .fi-page,
    .fi-page-content {
        width: 100% !important;
        max-width: none !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
    }

    .fi-header {
        width: 100% !important;
        max-width: none !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding-top: 20px !important;
    }
}

@media (max-width: 480px) {
    .fi-main-ctn {
        padding-left: 12px !important;
        padding-right: 12px !important;
    }
}
</style>
