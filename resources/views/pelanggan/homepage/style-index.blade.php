<style>
    /* Styling khusus yang tidak ada di utilitas default Bootstrap */
    .hero {
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=1474&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        /* Ubah height menjadi min-height agar bisa menyesuaikan tinggi card */
        min-height: 280px;
        height: auto;
        /* Tambahkan padding atas & bawah agar card tidak menempel di ujung gambar */
        padding-top: 3rem;
        padding-bottom: 3rem;
    }

    .queue-card {
        width: 100%;
        max-width: 380px;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Warna Kustom Barbershop */
    .bg-gold {
        background-color: #c5a059;
    }

    .text-gold {
        color: #c5a059;
    }

    .detail-card-button {
        width: 100%;
        padding: 0;
        border: 0;
        background: transparent;
        text-align: left;
        cursor: pointer;
    }

    .detail-card-button:focus {
        outline: none;
    }

    .detail-card-button .haircut-card {
        height: 100%;
    }

    .detail-card-meta {
        display: flex;
        justify-content: space-between;
        gap: 8px;
        align-items: center;
        font-size: 0.75rem;
        margin-top: 8px;
        color: #6c757d;
    }

    .detail-card-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.72rem;
        font-weight: 600;
        color: #495057;
    }

    .detail-modal-img {
        width: 100%;
        height: 260px;
        object-fit: cover;
        border-radius: 16px;
        background: #f1f3f5;
    }

    .detail-modal-price {
        color: #c5a059;
        font-size: 1.25rem;
        font-weight: 800;
    }

    .detail-modal-text {
        color: #5f6368;
        line-height: 1.7;
    }

    .detail-modal .modal-content {
        border: 0;
        border-radius: 18px;
    }

    .detail-modal .modal-header {
        border-bottom: 1px solid #eef1f5;
    }

    .border-gold-left {
        border-left: 4px solid #c5a059;
    }

    /* Ikon Menu */
    .icon-circle {
        background: #1a1a1a;
        color: #fff;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1.5rem;
        transition: transform 0.2s;
    }

    .menu-item {
        font-size: 0.85rem;
    }

    .menu-item:hover .icon-circle {
        transform: translateY(-5px);
    }

    /* Kustomisasi Card Gaya Rambut agar lebih estetik */
    .haircut-card {
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .haircut-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }

    .haircut-img {
        height: 140px;
        /* Tinggi gambar diperkecil */
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    @media (max-width: 767.98px) {
        .hero {
            height: auto;
            min-height: 240px;
            padding-top: 24px;
            padding-bottom: 24px;
        }

        .queue-card {
            max-width: 100%;
        }

        .icon-circle {
            width: 54px;
            height: 54px;
            font-size: 1.35rem;
            margin-bottom: 8px;
        }

        .menu-item {
            font-size: 0.8rem;
        }

        .haircut-img {
            height: 120px;
        }

        .border-gold-left {
            border-left-width: 3px;
        }
    }

    @media (max-width: 575.98px) {
        .hero {
            min-height: 220px;
        }

        #antrean-nomor {
            letter-spacing: 2px !important;
        }

        .queue-card .bg-gold {
            padding: 0.85rem !important;
        }

        .queue-card .bg-gold h5 {
            font-size: 0.9rem;
        }

        .container.py-5 {
            padding-top: 2rem !important;
            padding-bottom: 2rem !important;
        }
    }
</style>
