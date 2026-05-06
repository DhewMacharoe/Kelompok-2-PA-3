    <style>
        /* CSS Khusus Halaman Ini (Tetap sama seperti aslinya) */
        .main-container {
            padding: 20px;
            font-family: 'Inter', sans-serif;
        }

        /* Penampil Antrean Utama (Top Card) */
        .serving-display {
            background-color: #2C3E50;
            color: white;
            text-align: center;
            padding: 40px 20px;
            border-radius: 20px;
            margin-bottom: 24px;
        }

        .serving-display p {
            margin: 0;
            opacity: 0.8;
            font-size: 14px;
        }

        .serving-display .queue-number-big {
            font-size: 80px;
            font-weight: bold;
            margin: 10px 0;
            display: block;
        }

        .btn-group-serving {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .btn-panggil {
            background-color: #2F80ED;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            cursor: pointer;
        }

        .btn-batal {
            background-color: #EB5757;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* Tombol Tambah */
        .btn-tambah {
            background-color: #4CC779;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            font-weight: 500;
            cursor: pointer;
        }

        .filter-bar {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 16px;
            align-items: center;
        }

        .filter-btn {
            border: 1px solid #dfe3e8;
            background: #fff;
            color: #2C3E50;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            border-color: #2F80ED;
            color: #2F80ED;
        }

        .filter-btn.active {
            background: #2F80ED;
            border-color: #2F80ED;
            color: white;
        }

        .filter-btn.filter-btn-disabled,
        .filter-btn.filter-btn-disabled:hover {
            background: #e5e7eb;
            border-color: #d1d5db;
            color: #9ca3af;
            box-shadow: none;
        }

        .date-filter-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .date-filter-wrap label {
            font-size: 14px;
            font-weight: 600;
            color: #2C3E50;
        }

        .date-filter-input {
            border: 1px solid #dfe3e8;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 14px;
            min-width: 220px;
        }

        .btn-reset-filter {
            border: 1px solid #dfe3e8;
            background: #fff;
            color: #2C3E50;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }

        /* Styling Tabel */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .custom-table {
            width: 100%;
            min-width: 760px;
            border-collapse: collapse;
            text-align: center;
        }

        .custom-table thead {
            background-color: #2C3E50;
            color: white;
        }

        .custom-table th,
        .custom-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            white-space: nowrap;
        }

        .custom-table th:nth-child(2),
        .custom-table td:nth-child(2) {
            min-width: 170px;
            text-align: left;
            white-space: normal;
        }

        .row-highlight {
            background-color: #2196F3 !important;
            color: white !important;
        }

        .row-highlight td {
            border-color: transparent;
        }

        /* Status Badge */
        .status-text {
            font-weight: 500;
        }

        .action-link {
            color: #4a80da;
            text-decoration: none;
            font-weight: 600;
        }

        /* --- CSS BARU UNTUK CARD FORM (MODAL) --- */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }

        .form-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-card-header h3 {
            margin: 0;
            font-size: 18px;
            color: #2C3E50;
        }

        .btn-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .form-group {
            margin-bottom: 16px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #333;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .form-control[multiple] {
            min-height: 130px;
        }

        .form-help {
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
        }

        .form-error {
            margin-top: 6px;
            font-size: 12px;
            color: #d93025;
        }

        .error-box {
            background: #fff4f4;
            border: 1px solid #ffd8d8;
            color: #8a1c1c;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 12px;
            font-size: 13px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
        }

        .btn-submit {
            background-color: #2F80ED;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .main-container {
                padding: 12px;
            }

            .serving-display {
                border-radius: 14px;
                padding: 24px 14px;
            }

            .serving-display .queue-number-big {
                font-size: 58px;
                line-height: 1;
            }

            .btn-group-serving {
                width: 100%;
                gap: 8px;
            }

            .btn-group-serving button,
            .btn-tambah,
            .btn-reset-filter {
                width: 100%;
            }

            .filter-bar {
                gap: 8px;
            }

            .filter-btn {
                flex: 1 1 calc(50% - 8px);
                text-align: center;
                padding: 9px 10px;
            }

            .date-filter-wrap {
                align-items: stretch;
            }

            .date-filter-wrap label {
                width: 100%;
                margin-bottom: 0;
            }

            .date-filter-input,
            .btn-reset-filter {
                width: 100%;
                min-width: 0;
            }

            .table-container {
                overflow: visible;
                background: transparent;
                box-shadow: none;
            }

            .custom-table,
            .custom-table thead,
            .custom-table tbody,
            .custom-table tr,
            .custom-table td {
                display: block;
                width: 100%;
            }

            .custom-table {
                min-width: 0;
            }

            .custom-table thead {
                display: none;
            }

            .custom-table tbody {
                display: grid;
                gap: 10px;
            }

            .custom-table tr[data-status] {
                background: #fff;
                border: 1px solid #e9edf2;
                border-radius: 12px;
                padding: 10px 12px;
                box-shadow: 0 4px 10px rgba(15, 23, 42, 0.05);
            }

            .custom-table td {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 10px;
                padding: 9px 0;
                font-size: 13px;
                text-align: right;
                white-space: normal;
                border-bottom: 1px dashed #edf1f6;
            }

            .custom-table td::before {
                content: attr(data-label);
                font-weight: 600;
                color: #2C3E50;
                text-align: left;
                min-width: 120px;
            }

            .custom-table td:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }

            .custom-table th:nth-child(2),
            .custom-table td:nth-child(2) {
                min-width: 0;
                text-align: right;
            }

            .row-highlight {
                background: #eaf4ff !important;
                color: #1f3552 !important;
                border-color: #bfd9ff !important;
            }

            .row-highlight td {
                border-color: #d8e8ff;
            }

            .custom-table tr.empty-row-row {
                border: none;
                background: transparent;
                padding: 0;
                box-shadow: none;
            }

            .custom-table td.empty-row-cell {
                display: block;
                text-align: center;
                border: 1px dashed #d8dee8;
                background: #fff;
                border-radius: 12px;
                padding: 20px 12px !important;
            }

            .custom-table td.empty-row-cell::before {
                content: none;
            }
        }

        button:disabled {
            /* Mengurangi kontras agar terlihat "redup" */
            background-color: #cccccc;
            color: #666666;
            border: 1px solid #999999;

            /* Mengubah kursor untuk memberi sinyal dilarang */
            cursor: not-allowed;

            /* Menghilangkan bayangan atau efek elevasi */
            box-shadow: none;

            /* Menurunkan opasitas (opsional) */
            opacity: 0.6;
        }
    </style>