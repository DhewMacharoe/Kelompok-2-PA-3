<style>
    .rekap-wrap {
        --rekap-primary: #0578FB;
        --rekap-surface: #ffffff;
        --rekap-bg: #f4f7f6;
        --rekap-border: #dbe3ee;
        --rekap-text: #17324d;
        --rekap-muted: #6b7a90;
        --rekap-radius: 14px;
        --rekap-shadow: 0 4px 18px rgba(15, 23, 42, 0.06);
        background: linear-gradient(180deg, #f8fbff 0%, #f4f7f6 100%);
        border-radius: 18px;
        padding: 24px;
        min-height: 100%;
    }

    .rekap-wrap * {
        box-sizing: border-box;
    }

    .rekap-header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 22px;
    }

    .rekap-title-group h2 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 6px;
        color: var(--rekap-text);
        font-size: 1.45rem;
        font-weight: 800;
    }

    .rekap-title-group .icon-badge {
        width: 38px;
        height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: var(--dark-bg);
        color: #fff;
        font-size: 1rem;
    }

    .rekap-title-group p {
        margin: 0;
        color: var(--rekap-muted);
        font-size: 0.9rem;
    }

    .filter-card,
    .table-card,
    .stat-box {
        background: var(--rekap-surface);
        border: 1px solid var(--rekap-border);
        border-radius: var(--rekap-radius);
        box-shadow: var(--rekap-shadow);
    }

    .filter-card {
        padding: 18px 20px;
        margin-bottom: 18px;
    }

    .filter-label {
        margin-bottom: 10px;
        color: var(--rekap-muted);
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: flex-end;
    }

    .quick-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 14px;
        border-radius: 999px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: var(--rekap-muted);
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.18s ease;
    }

    .pill:hover {
        color: var(--primary-blue);
        border-color: var(--primary-blue);
        background: rgba(5, 120, 251, 0.08);
    }

    .pill.active {
        background: var(--primary-blue);
        color: #fff;
        border-color: var(--primary-blue);
    }

    .filter-divider {
        width: 1px;
        height: 38px;
        background: #dbe3ee;
    }

    .range-group {
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 10px;
    }

    .range-group label {
        display: block;
        margin-bottom: 4px;
        color: var(--rekap-muted);
        font-size: 0.78rem;
        font-weight: 700;
    }

    .range-group input[type='date'],
    .range-group input[type='month'] {
        width: 100%;
        min-width: 180px;
        height: 40px;
        padding: 0 12px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background: #fff;
        color: var(--rekap-text);
        outline: none;
    }

    .range-group input[type='date']:focus,
    .range-group input[type='month']:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(5, 120, 251, 0.12);
    }

    .btn-filter-apply,
    .btn-export {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 40px;
        padding: 0 16px;
        border: 0;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        transition: transform 0.15s ease, background-color 0.15s ease, color 0.15s ease;
    }

    .btn-filter-apply {
        background: var(--primary-blue);
        color: #fff;
    }

    .btn-filter-apply:hover,
    .btn-export:hover {
        transform: translateY(-1px);
    }

    .btn-export {
        background: var(--dark-bg);
        color: #fff;
    }

    .btn-export:hover {
        color: #fff;
        background: #223241;
    }

    .active-range-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-left: auto;
        padding: 5px 12px;
        border-radius: 999px;
        background: rgba(5, 120, 251, 0.08);
        color: var(--primary-blue);
        border: 1px solid rgba(5, 120, 251, 0.18);
        font-size: 0.78rem;
        font-weight: 700;
    }

    .stat-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
        margin-bottom: 18px;
    }

    .stat-box {
        position: relative;
        overflow: hidden;
        padding: 18px 20px;
    }

    .stat-box::before {
        content: '';
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
        height: 3px;
        background: var(--primary-blue);
    }

    .stat-box.accent::before {
        background: var(--dark-bg);
    }

    .stat-box.info::before {
        background: #0ea5e9;
    }

    .stat-box .stat-icon {
        width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        margin-bottom: 12px;
        background: rgba(5, 120, 251, 0.1);
        color: var(--primary-blue);
    }

    .stat-box.accent .stat-icon {
        background: rgba(44, 62, 80, 0.1);
        color: var(--dark-bg);
    }

    .stat-box.info .stat-icon {
        background: rgba(14, 165, 233, 0.1);
        color: #0284c7;
    }

    .stat-label {
        margin-bottom: 4px;
        color: var(--rekap-muted);
        font-size: 0.72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .stat-value {
        color: var(--rekap-text);
        font-size: 1.4rem;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 4px;
    }

    .stat-value-sm {
        font-size: 1rem;
    }

    .stat-box.primary-big .stat-value {
        color: var(--primary-blue);
    }

    .stat-sub {
        color: var(--rekap-muted);
        font-size: 0.74rem;
    }

    .table-card {
        overflow: hidden;
    }

    .table-card-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 16px 18px;
        border-bottom: 1px solid var(--rekap-border);
    }

    .table-card-header .title {
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--rekap-text);
        font-size: 0.9rem;
        font-weight: 800;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 999px;
        background: var(--primary-blue);
    }

    .row-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 24px;
        height: 22px;
        padding: 0 8px;
        border-radius: 999px;
        background: rgba(5, 120, 251, 0.12);
        color: var(--primary-blue);
        font-size: 0.73rem;
        font-weight: 800;
    }

    .tbl-search-wrap {
        position: relative;
    }

    .tbl-search-wrap input {
        width: 220px;
        height: 40px;
        padding: 0 12px 0 34px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        background: #fff;
        color: var(--rekap-text);
        outline: none;
    }

    .tbl-search-wrap input:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(5, 120, 251, 0.12);
    }

    .search-ico {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--rekap-muted);
        pointer-events: none;
    }

    .table-scroll {
        overflow-x: auto;
    }

    .rekap-table {
        width: 100%;
        border-collapse: collapse;
    }

    .rekap-table thead th {
        padding: 12px 16px;
        background: #f8fbff;
        border-bottom: 1px solid var(--rekap-border);
        color: var(--rekap-muted);
        font-size: 0.72rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .rekap-table tbody tr {
        border-bottom: 1px solid #edf2f7;
        transition: background 0.15s ease;
    }

    .rekap-table tbody tr:hover {
        background: rgba(5, 120, 251, 0.04);
    }

    .rekap-row {
        background: #fff;
    }

    .rekap-table td {
        padding: 13px 16px;
        color: var(--rekap-text);
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .pelanggan-name {
        font-size: 0.88rem;
        font-weight: 800;
    }

    .pelanggan-no,
    .tanggal-time {
        color: var(--rekap-muted);
        font-size: 0.75rem;
    }

    .pelanggan-no {
        margin-top: 2px;
    }

    .layanan-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .layanan-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 999px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #334155;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .harga-cell,
    .grand-total {
        color: var(--primary-blue);
        font-weight: 800;
        font-family: 'DM Mono', monospace;
    }

    .rekap-total-label {
        color: var(--rekap-muted);
        font-weight: 700;
    }

    .rekap-table tfoot tr {
        background: #f8fbff;
        border-top: 2px solid rgba(5, 120, 251, 0.18);
    }

    .rekap-table tfoot td,
    .rekap-table tfoot th {
        padding: 13px 16px;
        font-size: 0.86rem;
    }

    .empty-state {
        text-align: center;
        padding: 56px 20px;
    }

    .empty-icon {
        font-size: 2.6rem;
        margin-bottom: 14px;
        opacity: 0.35;
    }

    .empty-state p,
    .no-search-result {
        color: var(--rekap-muted);
        font-size: 0.9rem;
        margin: 0;
    }

    .rekap-empty-cell {
        padding: 0;
    }

    .no-search-result {
        display: none;
        text-align: center;
        padding: 40px 16px;
    }

    @media (max-width: 768px) {
        .rekap-wrap {
            padding: 16px;
        }

        .filter-divider {
            display: none;
        }

        .filter-card {
            padding: 14px;
        }

        .filter-row {
            gap: 10px;
            align-items: stretch;
        }

        .quick-pills {
            width: 100%;
        }

        .pill {
            flex: 1 1 calc(50% - 8px);
            text-align: center;
            min-width: 0;
        }

        .range-group {
            width: 100%;
        }

        .range-group > div,
        .range-group button {
            width: 100%;
        }

        .btn-filter-apply,
        .btn-export {
            width: 100%;
        }

        .active-range-badge {
            width: 100%;
            justify-content: center;
            margin-left: 0;
        }

        .table-card-header {
            align-items: stretch;
        }

        .table-card-header .title,
        .tbl-search-wrap {
            width: 100%;
        }

        .tbl-search-wrap input {
            width: 100%;
        }

        .table-scroll {
            overflow: visible;
            background: transparent;
            box-shadow: none;
        }

        .rekap-table,
        .rekap-table thead,
        .rekap-table tbody,
        .rekap-table tr,
        .rekap-table td {
            display: block;
            width: 100%;
        }

        .rekap-table {
            min-width: 0;
        }

        .rekap-table thead {
            display: none;
        }

        .rekap-table tbody {
            display: grid;
            gap: 10px;
        }

        .rekap-row {
            background: #fff;
            border: 1px solid #e9edf2;
            border-radius: 12px;
            padding: 12px 14px;
            box-shadow: 0 4px 10px rgba(15, 23, 42, 0.05);
        }

        .rekap-table td {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            padding: 10px 0;
            font-size: 13px;
            white-space: normal;
            border-bottom: 1px dashed #edf1f6;
        }

        .rekap-table td::before {
            content: attr(data-label);
            min-width: 118px;
            font-weight: 700;
            color: #2C3E50;
            text-align: left;
        }

        .rekap-table td:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .rekap-table td.text-end {
            text-align: right;
        }

        .rekap-table td.text-end .harga-cell {
            margin-left: auto;
        }

        .layanan-badges {
            justify-content: flex-end;
        }

        .layanan-badge {
            background: #f8fbff;
        }

        .stat-grid {
            grid-template-columns: 1fr;
        }

        .stat-box .stat-value {
            font-size: 1.2rem;
        }

        .rekap-title-group h2 {
            font-size: 1.25rem;
        }

        .row-count {
            margin-left: auto;
        }

        .empty-state {
            padding: 32px 10px;
        }

        .tbl-search-wrap input,
        .range-group input[type='date'],
        .range-group input[type='month'] {
            width: 100%;
            min-width: 0;
        }

        .active-range-badge {
            margin-left: 0;
        }
    }
</style>