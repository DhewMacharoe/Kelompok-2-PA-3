<style>
        /* HAPUS CSS 'body' dari sini agar tidak bertabrakan dengan layout utama dan Navbar */

        /* Container aplikasi utama */
        .app-card {
            max-width: 900px; /* Lebar maksimal untuk desktop */
            width: 100%;
            margin: 40px auto; /* Margin atas-bawah diperbesar sedikit agar berjarak dari Navbar */
            background-color: #ffffff;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border-radius: 16px;
            overflow: hidden;
        }

        /* Bagian Header (Sedang Dilayani) */
        .header-section {
            background-color: #1a1a1a;
            background-image:
                linear-gradient(rgba(255, 0, 0, 0.15) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 0, 0, 0.15) 1px, transparent 1px);
            background-size: 10px 10px;
            padding: 60px 20px;
            text-align: center;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .text-gold {
            color: #c99c3e;
            letter-spacing: 2px;
            font-size: 0.85rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .active-number-box {
            border: 2px solid #c99c3e;
            padding: 15px 60px;
            margin: 20px 0;
            border-radius: 8px;
        }

        .active-number {
            font-size: 5rem;
            font-weight: 800;
            color: #ffffff;
            line-height: 1;
            margin: 0;
        }

        .active-name {
            color: #a0a0a0;
            font-family: monospace;
            font-size: 1.1rem;
            letter-spacing: 2px;
            margin-top: 20px;
        }

        /* Bagian Daftar Antrean (Kanan/Bawah) */
        .right-panel {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .queue-section {
            padding: 30px;
            flex-grow: 1;
        }

        .section-title {
            display: flex;
            align-items: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #6c757d;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .section-title::after {
            content: "";
            flex: 1;
            margin-left: 15px;
            height: 1px;
            background-color: #e0e0e0;
        }

        .queue-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 12px;
            padding: 10px;
            display: flex;
            align-items: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .queue-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .queue-number-box {
            background-color: #1a1a1a;
            color: white;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            border-radius: 6px;
            flex-shrink: 0;
        }

        .queue-info {
            margin-left: 15px;
            flex-grow: 1;
        }

        .queue-name {
            font-weight: 700;
            font-size: 1rem;
            margin: 0;
            color: #212529;
        }

        .queue-time {
            font-size: 0.8rem;
            color: #888;
            margin: 0;
            font-weight: 600;
        }

        .badge-waiting {
            border: 1px solid #c99c3e;
            color: #c99c3e;
            background-color: transparent;
            font-size: 0.7rem;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Bagian Tombol */
        .footer-section {
            padding: 20px 30px 30px 30px;
            margin-top: auto;
        }

        .btn-add-queue {
            background-color: #c49a45;
            color: #1a1a1a;
            font-weight: 700;
            border: none;
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .btn-add-queue:hover {
            background-color: #b0893a;
            color: #1a1a1a;
        }
    </style>
