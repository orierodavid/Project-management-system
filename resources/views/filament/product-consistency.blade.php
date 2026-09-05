{{-- Shared product-level refinements. Presentation only; no business logic or routes are changed. --}}
<style>
    :root {
        --pm-surface: #ffffff;
        --pm-canvas: #f8fafc;
        --pm-border: #e4e7ec;
        --pm-border-strong: #d0d5dd;
        --pm-ink: #101828;
        --pm-text: #344054;
        --pm-muted: #667085;
        --pm-subtle: #98a2b3;
        --pm-accent: #2563eb;
        --pm-accent-dark: #1d4ed8;
        --pm-radius: 10px;
    }

    .fi-main {
        background: var(--pm-canvas) !important;
    }

    .fi-page-header {
        margin-bottom: 22px !important;
    }

    .fi-page-header-heading {
        color: var(--pm-ink) !important;
        font-size: 26px !important;
        font-weight: 760 !important;
        letter-spacing: -.035em !important;
    }

    .fi-section,
    .fi-ta-ctn,
    .fi-fo-component-ctn {
        border-color: var(--pm-border) !important;
        border-radius: var(--pm-radius) !important;
        box-shadow: 0 1px 2px rgba(16, 24, 40, .025) !important;
    }

    .fi-section-header {
        padding: 18px 20px !important;
        border-bottom-color: #eef0f3 !important;
    }

    .fi-section-header-heading {
        color: var(--pm-ink) !important;
        font-size: 14px !important;
        font-weight: 720 !important;
    }

    .fi-section-header-description,
    .fi-fo-field-wrp-label,
    .fi-ta-header-cell,
    .fi-ta-record td {
        color: var(--pm-muted) !important;
    }

    .fi-ta-header-cell {
        font-size: 11px !important;
        font-weight: 720 !important;
        letter-spacing: .025em !important;
        text-transform: uppercase !important;
    }

    .fi-ta-record {
        transition: background-color .15s ease;
    }

    .fi-ta-record:hover {
        background: #f8fafc !important;
    }

    .fi-ta-record td {
        border-top-color: #f0f2f5 !important;
        font-size: 13px !important;
    }

    .fi-input,
    .fi-select-input,
    .fi-fo-rich-editor {
        border-color: var(--pm-border-strong) !important;
        border-radius: 8px !important;
        box-shadow: none !important;
    }

    .fi-input:focus,
    .fi-select-input:focus-within,
    .fi-fo-rich-editor:focus-within {
        border-color: var(--pm-accent) !important;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10) !important;
    }

    .fi-btn {
        min-height: 38px;
        border-radius: 8px !important;
        font-size: 12px !important;
        font-weight: 700 !important;
    }

    .fi-pagination {
        border-top-color: #eef0f3 !important;
    }

    @media (max-width: 767px) {
        .fi-page-header-heading { font-size: 23px !important; }
        .fi-section-header { padding: 15px 16px !important; }
        .fi-ta-record td { font-size: 12px !important; }
    }
</style>
