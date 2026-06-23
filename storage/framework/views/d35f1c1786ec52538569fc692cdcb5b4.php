<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap');

    /* Typography & Global Reset on Homepage */
    body {
        font-family: 'Outfit', sans-serif !important;
        background-color: #f5f6f8 !important;
        color: #333333;
    }

    /* Navbar Dynamic Styling Override */
    .pelanggan-navbar {
        background-color: #ffffff !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04) !important;
        border-bottom: 1px solid #f0f0f0 !important;
        padding-top: 10px !important;
        padding-bottom: 10px !important;
        transition: all 0.3s ease;
    }

    .pelanggan-navbar .navbar-brand img {
        max-height: 44px !important;
        height: 44px !important;
        width: auto !important;
    }

    .pelanggan-navbar .nav-link {
        color: #2b2b2b !important;
        font-weight: 600 !important;
        font-size: 0.92rem;
        padding: 0.5rem 1rem !important;
        border-radius: 6px;
        transition: all 0.2s ease;
    }

    .pelanggan-navbar .nav-link:hover,
    .pelanggan-navbar .nav-link.active {
        color: <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?> !important;
        background-color: <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?>14 !important;
    }

    .pelanggan-navbar .navbar-toggler {
        color: #1a1a1a !important;
        background: transparent !important;
    }

    .pelanggan-navbar .navbar-toggler i {
        color: #1a1a1a !important;
        font-size: 1.35rem !important;
    }

    /* Auth buttons override */
    .pelanggan-navbar .navbar-nav .btn {
        border-radius: 8px !important;
        font-size: 0.85rem !important;
        padding: 6px 16px !important;
        transition: all 0.25s ease;
    }

    .pelanggan-navbar .navbar-nav a[href*="login"] {
        background-color: <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?> !important;
        color: #ffffff !important;
        border: 1px solid <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?> !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="login"]:hover {
        background-color: <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?>e6 !important;
        border-color: <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?>e6 !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="profile"],
    .pelanggan-navbar .navbar-nav button[type="submit"] {
        color: <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?> !important;
        border: 1px solid <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?> !important;
        background: transparent !important;
    }

    .pelanggan-navbar .navbar-nav a[href*="profile"]:hover,
    .pelanggan-navbar .navbar-nav button[type="submit"]:hover {
        background-color: <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?> !important;
        color: #ffffff !important;
    }

    /* Custom Colors */
    .bg-gold-accent {
        background-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
    }

    .text-gold-accent {
        color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
    }

    .border-gold-accent {
        border-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
    }

    .btn-gold-accent {
        background-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
        color: #ffffff !important;
        border: 1px solid <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
        transition: all 0.25s ease;
    }

    .btn-gold-accent:hover {
        background-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>e6 !important;
        border-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>e6 !important;
        color: #ffffff !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>33;
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.75)), url('<?php echo e(isset($activeDesign) && $activeDesign->gambar_hero ? asset($activeDesign->gambar_hero) : "https://images.unsplash.com/photo-1585747860715-2ba37e788b70?q=80&w=1474&auto=format&fit=crop"); ?>');
        background-size: cover;
        background-position: center;
        min-height: 460px;
        padding: 5rem 1.5rem;
        position: relative;
    }

    .hero-subtitle {
        color: #e0b443;
        font-weight: 700;
        letter-spacing: 3px;
        font-size: 0.85rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .hero-title {
        font-family: 'Outfit', sans-serif;
        font-size: 3.6rem;
        font-weight: 900;
        color: #ffffff;
        letter-spacing: 1px;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
    }

    .hero-divider-line {
        height: 1px;
        width: 50px;
        background-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>;
    }

    .hero-divider-text {
        color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>;
        font-weight: 600;
        font-size: 0.95rem;
        letter-spacing: 1.5px;
    }

    .hero-desc {
        color: #e5e5e5;
        font-size: 1.05rem;
        max-width: 520px;
        line-height: 1.6;
        font-weight: 300;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .hero-cta-btn {
        background-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>;
        color: #ffffff !important;
        border-radius: 8px;
        font-weight: 600;
        padding: 12px 30px;
        transition: all 0.3s ease;
        border: 1px solid <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>;
    }

    .hero-cta-btn:hover {
        background-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>e6;
        border-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>e6;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>59;
    }

    /* Queue Status Card */
    .queue-status-card {
        border-radius: 16px;
        margin-top: -50px;
        position: relative;
        z-index: 10;
        background: #ffffff;
        border: 1px solid #eef1f5 !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05) !important;
    }

    .queue-icon-circle {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }

    .queue-icon-circle.border-gold-accent {
        border: 2px solid <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?> !important;
    }

    .queue-large-val {
        font-size: 1.65rem;
        font-weight: 800;
        color: #1a1a1a;
        line-height: 1.2;
    }

    .queue-large-val-gold {
        font-size: 1.65rem;
        font-weight: 800;
        color: <?php echo e($activeDesign->warna_primer ?? '#d4af37'); ?> !important;
        line-height: 1.2;
    }

    .fw-extrabold {
        font-weight: 800 !important;
    }

    .status-pelayanan-box {
        background: #fafbfc;
        border-color: #eef1f5 !important;
    }

    /* Blinking Dot animation for Status */
    @keyframes blink {
        0% { opacity: 0.45; transform: scale(0.9); }
        50% { opacity: 1; transform: scale(1.1); }
        100% { opacity: 0.45; transform: scale(0.9); }
    }
    .dot-blink {
        animation: blink 1.6s infinite ease-in-out;
    }

    /* Navigation Grid Menu */
    .menu-grid-card {
        border-radius: 12px;
        border: 1px solid #f0f0f0 !important;
        background: #ffffff;
        padding: 24px 15px !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .menu-grid-card:hover {
        transform: translateY(-5px);
        border-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
        box-shadow: 0 10px 25px <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>14 !important;
    }

    .menu-grid-icon {
        font-size: 1.95rem;
        color: #1a1a1a;
        margin-bottom: 12px;
        transition: color 0.25s ease;
    }

    .menu-grid-text {
        font-size: 0.95rem;
        font-weight: 600;
        color: #1a1a1a;
        transition: color 0.25s ease;
    }

    .menu-grid-card:hover .menu-grid-icon,
    .menu-grid-card:hover .menu-grid-text {
        color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>;
    }

    /* Section Titles styling */
    .section-title {
        color: #1a1a1a;
        font-weight: 700;
        font-size: 1.3rem;
    }

    .section-title i {
        font-size: 1.1rem;
    }

    .link-hover-effect {
        transition: all 0.2s ease;
        position: relative;
    }

    .link-hover-effect:hover {
        color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?>e6 !important;
        transform: translateX(3px);
    }

    /* Services Card styling */
    .detail-card-button {
        background: transparent;
        border: 0;
        padding: 0;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .detail-card-button:focus {
        outline: none;
    }

    .service-custom-card {
        border-radius: 14px;
        border: 1px solid #eef1f5 !important;
        transition: all 0.25s ease;
    }

    .service-custom-card:hover {
        transform: translateY(-4px);
        border-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05) !important;
    }

    .service-icon-wrapper {
        width: 48px;
        height: 48px;
        font-size: 1.15rem;
        background-color: #111111 !important;
    }

    .service-title-text {
        font-size: 1.05rem;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 4px !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .service-meta-text {
        font-size: 0.8rem;
        margin-bottom: 8px !important;
    }

    .service-desc {
        font-size: 0.82rem;
        line-height: 1.45;
        color: #6c757d;
        margin-bottom: 8px !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        height: 2.9em;
    }

    .service-price-text {
        font-size: 1.15rem;
        color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
    }



    /* Global Footer Override for Homepage */
    .footer-custom {
        background-color: #111111 !important;
        color: #bcbcbc !important;
        border-top: 3px solid <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
        padding-top: 50px !important;
    }

    .footer-custom h5 {
        color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
        font-weight: 700 !important;
        letter-spacing: 1px !important;
        text-transform: uppercase !important;
    }

    .footer-custom a {
        color: #b0b0b0 !important;
    }

    .footer-custom a:hover {
        color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
        transform: translateY(-2px);
    }

    .footer-custom .icon-gold {
        color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
    }

    .footer-custom .map-container {
        border-radius: 10px !important;
        border: 1px solid #2a2a2a !important;
        overflow: hidden;
    }

    #footer-maps-btn {
        background-color: #1a1a1a !important;
        color: #ffffff !important;
        border: 1px solid #333333 !important;
    }

    #footer-maps-btn:hover {
        background-color: #222222 !important;
        border-color: <?php echo e($activeDesign->warna_primer ?? '#e8a53a'); ?> !important;
    }

    /* Layout border helpers */
    @media (min-width: 768px) {
        .border-start-md {
            border-left: 1px solid #eef1f5 !important;
        }
    }

    @media (min-width: 992px) {
        .footer-custom .col-lg-3:not(:last-child) {
            border-right: 1px solid #242424 !important;
        }
    }

    /* Responsive Queries */
    @media (max-width: 991.98px) {
        .hero-title {
            font-size: 2.8rem;
        }
    }

    @media (max-width: 767.98px) {
        .hero {
            min-height: 360px;
            padding: 3.5rem 1rem;
        }

        .hero-title {
            font-size: 2.3rem;
        }

        .queue-status-card {
            margin-top: -30px;
        }

        .queue-info-section {
            border-bottom: 1px solid #f0f0f0;
        }
    }

    @media (max-width: 575.98px) {
        .hero-title {
            font-size: 1.85rem;
        }

        .hero-subtitle {
            letter-spacing: 2px;
            font-size: 0.75rem;
        }

        .hero-divider-text {
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        .hero-divider-line {
            width: 30px;
        }

        .hero-desc {
            font-size: 0.9rem;
        }

        .hero-cta-btn {
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .queue-status-card {
            margin-top: -20px;
            border-radius: 16px;
        }

        .queue-info-section {
            padding: 1.25rem 1rem !important;
            border-bottom: 1px solid #f0f0f0;
        }

        /* Reset border for the top two items */
        .queue-info-section.border-start-md {
            border-left: 0 !important;
        }

        .queue-icon-circle {
            width: 44px !important;
            height: 44px !important;
            font-size: 1.1rem !important;
        }

        .queue-info-details h6 {
            font-size: 0.8rem !important;
            margin-bottom: 2px !important;
            color: #1a1a1a !important;
        }

        .queue-info-details p {
            font-size: 0.72rem !important;
            line-height: 1.2;
            margin-bottom: 3px !important;
        }

        .queue-large-val, .queue-large-val-gold {
            font-size: 1.25rem !important;
        }

        .status-pelayanan-box {
            padding: 1.25rem !important;
            margin: 8px 0 !important;
            border-radius: 12px !important;
        }

        .status-pelayanan-box .btn {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
            font-size: 0.88rem !important;
            border-radius: 8px !important;
        }

        .status-pelayanan-box h6 {
            font-size: 0.82rem !important;
            margin-bottom: 2px !important;
        }

        .status-pelayanan-box p {
            font-size: 0.72rem !important;
            line-height: 1.35 !important;
        }

        .status-pelayanan-box i {
            font-size: 0.95rem !important;
        }

        /* Navigation Grid Menu Mobile Spacing */
        .menu-grid-card {
            padding: 20px 10px !important;
            border-radius: 12px !important;
        }
        .menu-grid-icon {
            font-size: 1.6rem !important;
            margin-bottom: 8px !important;
        }
        .menu-grid-text {
            font-size: 0.88rem !important;
        }

        /* Services Grid Mobile Spacing (1 column, full horizontal card) */
        .service-custom-card {
            padding: 1rem !important;
            gap: 12px !important;
            border-radius: 12px !important;
        }
        .service-icon-wrapper {
            width: 42px !important;
            height: 42px !important;
            font-size: 1rem !important;
        }
        .service-title-text {
            font-size: 0.95rem !important;
            margin-bottom: 3px !important;
            -webkit-line-clamp: 2 !important;
        }
        .service-meta-text {
            font-size: 0.76rem !important;
            margin-bottom: 4px !important;
        }
        .service-desc {
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            font-size: 0.76rem !important;
            line-height: 1.35 !important;
            height: 2.7em !important;
            margin-bottom: 6px !important;
        }
        .service-price-text {
            font-size: 1.05rem !important;
            margin-top: 4px !important;
        }



        .section-title {
            font-size: 1.15rem;
        }
    }
</style>
<?php /**PATH D:\s6\pa 3\pa_3v3\Kelompok-2-PA-3\resources\views/pelanggan/homepage/style-index.blade.php ENDPATH**/ ?>