<style>
    .help-page {
        background: linear-gradient(180deg, #fffaf2 0%, #f8f4eb 100%);
    }

    .help-shell {
        width: min(1100px, calc(100% - 32px));
        margin: 0 auto;
        padding: 32px 0 56px;
    }

    .help-hero {
        background: linear-gradient(135deg, #171717 0%, #2b2418 55%, #6a4f1d 100%);
        color: #fff;
        border-radius: 28px;
        padding: 36px;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.16);
        overflow: hidden;
        position: relative;
    }

    .help-hero::after {
        content: '';
        position: absolute;
        inset: auto -60px -80px auto;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
    }

    .help-kicker {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 12px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.12);
        color: #f7e4b5;
        font-weight: 700;
        letter-spacing: 0.04em;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .help-hero h1 {
        margin: 16px 0 12px;
        font-size: clamp(2rem, 4vw, 3.6rem);
        line-height: 1.05;
        font-weight: 800;
        max-width: 13ch;
    }

    .help-hero p {
        margin: 0;
        max-width: 720px;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.7;
        font-size: 1.02rem;
    }

    .help-hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 24px;
    }

    .help-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 16px;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 700;
        transition: transform 0.2s ease, background 0.2s ease, color 0.2s ease;
    }

    .help-pill:hover {
        transform: translateY(-1px);
    }

    .help-pill--light {
        background: #ffffff;
        color: #1f1f1f;
    }

    .help-pill--outline {
        border: 1px solid rgba(255, 255, 255, 0.35);
        color: #fff;
        background: transparent;
    }

    .help-grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 18px;
        margin-top: 22px;
    }

    .help-card,
    .help-panel {
        background: #ffffff;
        border: 1px solid #ebe4d5;
        border-radius: 22px;
        box-shadow: 0 10px 26px rgba(37, 28, 16, 0.06);
    }

    .help-card {
        display: block;
        text-decoration: none;
        color: inherit;
        padding: 20px;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        height: 100%;
    }

    .help-card:hover {
        transform: translateY(-3px);
        border-color: #d9c18b;
        box-shadow: 0 14px 32px rgba(37, 28, 16, 0.1);
    }

    .help-card-icon {
        width: 52px;
        height: 52px;
        border-radius: 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #f6ecd2;
        color: #6c4c16;
        font-size: 1.2rem;
        margin-bottom: 14px;
    }

    .help-card h2,
    .help-panel h2 {
        margin: 0 0 10px;
        font-size: 1.25rem;
        font-weight: 800;
        color: #181818;
    }

    .help-card p,
    .help-panel p,
    .help-panel li {
        color: #5c5c5c;
        line-height: 1.7;
    }

    .help-section {
        margin-top: 22px;
    }

    .help-panel {
        padding: 24px;
    }

    .help-panel-header {
        display: flex;
        align-items: start;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }

    .help-panel-header h2 {
        margin-bottom: 4px;
    }

    .help-panel-header p {
        margin: 0;
    }

    .help-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        background: #f7f1e3;
        color: #6c4c16;
        font-size: 0.82rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .help-steps {
        display: grid;
        gap: 14px;
    }

    .help-step {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 14px;
        align-items: start;
        padding: 16px;
        border-radius: 18px;
        background: #fcfaf6;
        border: 1px solid #efe5d0;
    }

    .help-step-index {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #1c1c1c;
        color: #fff;
        font-weight: 800;
        flex-shrink: 0;
    }

    .help-step h3,
    .help-faq-item summary {
        margin: 0 0 6px;
        font-size: 1.02rem;
        font-weight: 800;
        color: #191919;
    }

    .help-step p,
    .help-step ul,
    .help-faq-item p {
        margin: 0;
    }

    .help-note {
        margin-top: 18px;
        padding: 16px 18px;
        border-radius: 18px;
        background: #fff7e4;
        border: 1px solid #ead7a6;
    }

    .help-note strong {
        color: #6c4c16;
    }

    .help-faq-list {
        display: grid;
        gap: 12px;
    }

    .help-faq-item {
        border: 1px solid #ebdfc6;
        border-radius: 18px;
        background: #fff;
        overflow: hidden;
    }

    .help-faq-item summary {
        cursor: pointer;
        list-style: none;
        padding: 18px 20px;
    }

    .help-faq-item summary::-webkit-details-marker {
        display: none;
    }

    .help-faq-item .help-faq-answer {
        padding: 0 20px 18px;
        color: #5c5c5c;
        line-height: 1.7;
    }

    .help-link-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 18px;
    }

    .help-link-inline {
        color: #6c4c16;
        font-weight: 700;
        text-decoration: none;
    }

    .help-link-inline:hover {
        text-decoration: underline;
    }

    .help-footer-cta {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .help-card-grid-item {
        grid-column: span 4;
    }

    .help-card-grid-item--wide {
        grid-column: span 6;
    }

    @media (max-width: 991.98px) {
        .help-card-grid-item,
        .help-card-grid-item--wide {
            grid-column: span 6;
        }
    }

    @media (max-width: 767.98px) {
        .help-shell {
            width: min(100% - 20px, 1100px);
            padding-top: 20px;
            padding-bottom: 36px;
        }

        .help-hero,
        .help-panel {
            border-radius: 20px;
        }

        .help-hero {
            padding: 24px;
        }

        .help-panel {
            padding: 20px;
        }

        .help-panel-header {
            flex-direction: column;
            align-items: start;
        }

        .help-card-grid-item,
        .help-card-grid-item--wide {
            grid-column: span 12;
        }

        .help-step {
            grid-template-columns: 1fr;
        }
    }
</style>