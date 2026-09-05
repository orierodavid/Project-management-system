{{-- Final shared UX polish. Presentation only; business logic, routes and permissions remain unchanged. --}}
<style>
    /* Page rhythm */
    .fi-page {
        gap: 20px !important;
    }

    .fi-page-content {
        gap: 20px !important;
    }

    .fi-header-actions {
        gap: 8px !important;
    }

    /* Forms */
    .fi-fo-field-wrp {
        gap: 7px !important;
    }

    .fi-fo-field-wrp-label {
        font-size: 12px !important;
        font-weight: 650 !important;
        color: #344054 !important;
    }

    .fi-fo-field-wrp-helper-text,
    .fi-fo-field-wrp-error-message {
        font-size: 12px !important;
    }

    .fi-input-wrp {
        border-radius: 8px !important;
        border-color: #d0d5dd !important;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .03) !important;
        transition: border-color .15s ease, box-shadow .15s ease !important;
    }

    .fi-input-wrp:focus-within {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .09) !important;
    }

    /* Filters / table toolbar */
    .fi-ta-header-toolbar {
        padding: 14px 16px !important;
        border-bottom: 1px solid #eef0f3 !important;
        gap: 12px !important;
    }

    .fi-ta-filter-indicators {
        gap: 6px !important;
    }

    .fi-ta-filter-indicators > * {
        border-radius: 999px !important;
        font-size: 11px !important;
        font-weight: 650 !important;
    }

    /* Product-like tabs */
    .fi-tabs {
        border-bottom: 1px solid #e4e7ec !important;
        gap: 2px !important;
    }

    .fi-tabs-item {
        border-radius: 7px 7px 0 0 !important;
        font-size: 12px !important;
        font-weight: 650 !important;
    }

    /* Dropdowns and modals */
    .fi-dropdown-panel,
    .fi-modal-window {
        border: 1px solid #e4e7ec !important;
        border-radius: 10px !important;
        box-shadow: 0 18px 48px rgba(16, 24, 40, .14) !important;
    }

    .fi-dropdown-list-item {
        min-height: 38px !important;
        border-radius: 6px !important;
        font-size: 13px !important;
    }

    .fi-modal-header {
        border-bottom: 1px solid #eef0f3 !important;
        padding: 18px 20px !important;
    }

    .fi-modal-footer {
        border-top: 1px solid #eef0f3 !important;
        padding: 14px 20px !important;
    }

    /* Notifications / alerts */
    .fi-no-notification {
        border-radius: 10px !important;
    }

    /* Actions */
    .fi-ac-btn-action,
    .fi-ac-btn-group {
        gap: 6px !important;
    }

    .fi-ac-btn-action .fi-btn {
        min-height: 36px !important;
    }

    /* Avoid oversized stock Filament content on smaller screens. */
    @media (max-width: 1023px) {
        .fi-page {
            gap: 16px !important;
        }

        .fi-page-content {
            gap: 16px !important;
        }

        .fi-ta-header-toolbar {
            padding: 12px !important;
        }
    }

    @media (max-width: 639px) {
        .fi-page-header {
            margin-bottom: 14px !important;
        }

        .fi-header-actions {
            width: 100% !important;
        }

        .fi-header-actions > * {
            flex: 1 1 auto !important;
        }

        .fi-header-actions .fi-btn {
            width: 100% !important;
        }

        .fi-section-header,
        .fi-modal-header,
        .fi-modal-footer {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }

        .fi-ta-header-toolbar {
            padding: 10px !important;
        }

        .fi-ta-content {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        .fi-ta-table {
            min-width: 680px !important;
        }
    }
</style>
