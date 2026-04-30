<style>
.layanan-page {
    max-width: 960px;
    margin: 20px auto;
    background: #fff;
    border-radius: 26px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
}

.layanan-hero {
    height: 270px;
    background:
        linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.55)),
        url("https://images.unsplash.com/photo-1621605815971-fbc98d665033?q=80&w=1200&auto=format&fit=crop");
    background-size: cover;
    background-position: center;
    padding: 28px 24px;
    display: flex;
    align-items: end;
}

.layanan-hero-overlay {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: end;
    padding: 0;
}

.layanan-hero-text h1 {
    color: #fff;
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 10px;
}

.layanan-hero-text p {
    color: #f1f1f1;
    max-width: 520px;
    line-height: 1.6;
    font-size: 16px;
}

.layanan-content {
    background: #fff;
    margin-top: -14px;
    border-radius: 26px 26px 0 0;
    padding: 30px 24px 40px;
}

.layanan-section-header h3 {
    font-size: 34px;
    margin-bottom: 10px;
    color: #111;
}

.layanan-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 18px;
}

.layanan-card {
    display: flex;
    gap: 18px;
    align-items: center;
    background: #fff;
    border-radius: 18px;
    border: 1px solid #ece6da;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    padding: 14px;
}

.layanan-card-image img {
    width: 170px;
    height: 120px;
    object-fit: cover;
    border-radius: 14px;
    display: block;
}

.layanan-card-body {
    flex: 1;
}

.layanan-card-body h4 {
    margin: 0 0 6px;
    font-size: 22px;
    font-weight: 700;
    color: #111;
}

.layanan-desc {
    font-size: 15px;
    color: #555;
    margin-bottom: 14px;
    line-height: 1.5;
}

.layanan-time {
    font-size: 15px;
    color: #666;
    margin-bottom: 6px;
}

.layanan-price {
    font-size: 18px;
    font-weight: 700;
    color: #c9a24f;
    margin: 0;
}

.layanan-note {
    margin-top: 26px;
    background: #f5efe4;
    border-radius: 18px;
    padding: 16px 18px;
}

.layanan-note p {
    margin: 0;
    color: #555;
    font-size: 15px;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .layanan-hero {
        height: 220px;
    }

    .layanan-hero-text h1 {
        font-size: 30px;
    }

    .layanan-section-header h3 {
        font-size: 28px;
    }

    .layanan-grid {
        grid-template-columns: 1fr;
    }

    .layanan-card {
        flex-direction: column;
        align-items: stretch;
    }

    .layanan-card-image img {
        width: 100%;
        height: 220px;
    }
}
</style>
