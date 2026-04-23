<style>
    /* Styling khusus yang tidak ada di utilitas default Bootstrap */
    .hero {
        background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=1474&auto=format&fit=crop');
        background-size: cover;
        background-position: center;
        height: 280px;
    }

    .queue-card {
        width: 100%;
        max-width: 380px;
        border-radius: 12px;
        overflow: hidden;
    }

    /* Warna Kustom Barbershop */
    .bg-gold { background-color: #c5a059; }
    .text-gold { color: #c5a059; }
    .border-gold-left { border-left: 4px solid #c5a059; }

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
    .menu-item { font-size: 0.85rem; }
    .menu-item:hover .icon-circle { transform: translateY(-5px); }

    /* Kustomisasi Card Gaya Rambut agar lebih estetik */
    .haircut-card {
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .haircut-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .haircut-img {
        height: 140px; /* Tinggi gambar diperkecil */
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

        #antrian-nomor {
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
