<style>
    .pelanggan-navbar {
        background-color: #1a1a1a;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
    }

    .pelanggan-navbar .navbar-brand img,
    .navbar-logo {
        height: 32px;
        width: auto;
        display: block;
        max-height: 40px;
    }

    .pelanggan-navbar .navbar-brand {
        min-width: 44px;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .pelanggan-navbar .navbar-toggler {
        padding: 0.5rem;
        line-height: 1;
        min-width: 44px;
        min-height: 44px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .pelanggan-navbar .navbar-toggler i {
        font-size: 1.35rem;
    }

    .nav-link-gold {
        color: white;
        transition: color 0.3s ease;
    }

    .nav-link-gold:hover,
    .nav-link-gold.is-active {
        color: #d4af37;
    }

    .btn-gold-solid {
        background-color: var(--color-primary);
        color: #ffffff;
        border: 1px solid var(--color-primary);
        border-radius: var(--radius-sm);
        min-height: 44px;
        transition: transform var(--transition-standard), box-shadow var(--transition-standard), background-color var(--transition-standard), border-color var(--transition-standard);
    }

    .btn-gold-outline {
        background-color: transparent;
        color: var(--color-primary);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        min-height: 44px;
        transition: transform var(--transition-standard), box-shadow var(--transition-standard), background-color var(--transition-standard), border-color var(--transition-standard);
    }

    .pelanggan-navbar .navbar-nav .btn {
        font-size: 0.875rem;
    }

    .profile-card {
        border-radius: 15px;
        overflow: hidden;
    }

    .profile-card-header-dark {
        background-color: #1a1a1a;
        border-bottom: 3px solid #d4af37;
    }

    .profile-card-title-gold {
        color: #d4af37;
    }

    .profile-action-button {
        border-radius: var(--radius-sm);
        min-height: 44px;
        transition: transform var(--transition-standard), box-shadow var(--transition-standard), background-color var(--transition-standard), color var(--transition-standard), border-color var(--transition-standard);
    }

    .profile-action-button--save {
        background-color: var(--color-success);
        color: #ffffff;
        border-color: var(--color-success);
    }

    .profile-action-button:focus-visible,
    .btn-gold-solid:focus-visible,
    .btn-gold-outline:focus-visible {
        outline: 3px solid rgba(200, 162, 74, 0.35);
        outline-offset: 2px;
    }

    @media (max-width: 991.98px) {
        .pelanggan-navbar .navbar-brand {
            font-size: 1rem !important;
            max-width: calc(100% - 70px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .pelanggan-navbar .navbar-collapse {
            padding-top: 8px;
            padding-bottom: 8px;
        }

        .pelanggan-navbar .nav-link {
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 0.55rem;
            padding-bottom: 0.55rem;
            font-size: 0.875rem;
        }

        .pelanggan-navbar .navbar-nav .btn {
            width: 100%;
            margin-top: 6px;
        }
    }

    @media (max-width: 575.98px) {
        .pelanggan-navbar .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        .pelanggan-navbar .navbar-toggler i {
            font-size: 1.2rem !important;
        }
    }
</style>
