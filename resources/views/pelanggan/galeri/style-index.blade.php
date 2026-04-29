<style>
.galeri-hero {
    height: 270px;
    background:
        linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.55)),
        url("{{ asset('assets/images/galeri.png') }}");
    background-size: cover;
    background-position: center;
    border-radius: 0 0 26px 26px;
    overflow: hidden;
}
.galeri-hero-overlay {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: end;
    padding: 28px 24px;
}

.galeri-hero-text h1 {
    color: #fff;
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 10px;
}

.galeri-hero-text p {
    color: #f1f1f1;
    max-width: 560px;
    line-height: 1.6;
    font-size: 16px;
}

.galeri-content {
    background: #fff;
    margin-top: -14px;
    border-radius: 26px 26px 0 0;
    padding: 30px 24px 40px;
}

.galeri-section-header {
    margin-bottom: 24px;
}

.galeri-section-header h2 {
    font-size: 34px;
    color: #111;
    margin: 0 0 10px;
    font-weight: 700;
}

.galeri-line {
    width: 96px;
    height: 4px;
    background: #c9a24f;
    border-radius: 999px;
}

.galeri-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

.galeri-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    border: 1px solid #ece6da;
    transition: 0.25s ease;
}

.galeri-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 22px rgba(0, 0, 0, 0.12);
}

.galeri-card-image img {
    width: 100%;
    height: 190px;
    object-fit: cover;
    display: block;
}

.galeri-card-body {
    padding: 18px;
}

.galeri-card-body h3 {
    margin: 0 0 8px;
    font-size: 21px;
    color: #111;
    font-weight: 700;
}

.galeri-card-body p {
    color: #555;
    font-size: 15px;
    line-height: 1.5;
    margin: 0;
}

.galeri-empty {
    background: #f5efe4;
    border-radius: 18px;
    padding: 28px 22px;
    border: 1px solid #ece6da;
    text-align: center;
}

.galeri-empty h3 {
    font-size: 24px;
    color: #111;
    margin-bottom: 8px;
    font-weight: 700;
}

.galeri-empty p {
    color: #555;
    line-height: 1.6;
    margin: 0;
    font-size: 15px;
}

@media (max-width: 992px) {
    .galeri-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .galeri-card-image img {
        height: 190px;
    }
}

@media (max-width: 768px) {
    .galeri-hero {
        height: 220px;
    }

    .galeri-hero-overlay {
        padding: 24px 22px;
    }

    .galeri-hero-text h1 {
        font-size: 30px;
    }

    .galeri-hero-text p {
        font-size: 15px;
    }

    .galeri-content {
        padding: 28px 24px 36px;
    }

    .galeri-section-header h2 {
        font-size: 28px;
    }

    .galeri-grid {
        grid-template-columns: 1fr;
        gap: 18px;
    }

    .galeri-card-image img {
        height: 220px;
    }
}

@media (max-width: 480px) {
    .galeri-hero {
        height: 210px;
    }

    .galeri-content {
        padding: 26px 18px 34px;
    }

    .galeri-card-image img {
        height: 200px;
    }

    .galeri-card-body {
        padding: 16px;
    }

    .galeri-card-body h3 {
        font-size: 20px;
    }

    .galeri-card-body p {
        font-size: 14px;
    }
}
</style>