    <style>
        .main-container {
            padding: 20px;
            font-family: 'Inter', sans-serif;
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

        /* Styling Filter & Search */
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

        .search-filter-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .search-filter-wrap label {
            font-size: 14px;
            font-weight: 600;
            color: #2C3E50;
        }

        .search-filter-input {
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
            vertical-align: middle;
        }

        .custom-table th:nth-child(2),
        .custom-table td:nth-child(2),
        .custom-table th:nth-child(3),
        .custom-table td:nth-child(3) {
            text-align: left;
            white-space: normal;
        }

        /* Status Badge */
        .status-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-aktif {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .status-nonaktif {
            background-color: #f5f5f5;
            color: #757575;
        }

        /* Action Buttons */
        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 5px;
            color: white;
        }

        .btn-view {
            background-color: #64748b;
        }

        .btn-edit {
            background-color: #3b82f6;
        }

        .btn-hapus {
            background-color: #ef4444;
        }

        .btn-toggle-status {
            background-color: #f59e0b;
        }

        /* Modal Custom Styling (if needed later) */
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

        .btn-close-custom {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
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

        .btn-batal {
            background-color: #EB5757;
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

            .btn-tambah,
            .btn-reset-filter {
                width: 100%;
                text-align: center;
            }

            .filter-bar {
                gap: 8px;
            }

            .filter-btn {
                flex: 1 1 calc(50% - 8px);
                text-align: center;
                padding: 9px 10px;
            }

            .search-filter-wrap {
                align-items: stretch;
            }

            .search-filter-wrap label {
                width: 100%;
                margin-bottom: 0;
            }

            .search-filter-input {
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

            .custom-table tr {
                background: #fff;
                border: 1px solid #e9edf2;
                border-radius: 12px;
                padding: 10px 12px;
                box-shadow: 0 4px 10px rgba(15, 23, 42, 0.05);
            }

            .custom-table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
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
                justify-content: flex-end;
            }

            .custom-table th:nth-child(2),
            .custom-table td:nth-child(2),
            .custom-table th:nth-child(3),
            .custom-table td:nth-child(3) {
                text-align: right;
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
            
            .btn-action {
                margin-bottom: 5px;
            }
        }
    </style>
