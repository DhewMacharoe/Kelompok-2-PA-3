<style>
.menu-hero {
    height: 270px;
    background:
        linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.55)),
        url("https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1400&auto=format&fit=crop");
    background-size: cover;
    background-position: center;
    border-radius: 0 0 26px 26px;
    overflow: hidden;
}

.menu-hero-overlay {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: end;
    padding: 28px 24px;
}

.menu-hero-text h1 {
    color: #fff;
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 10px;
}

.menu-hero-text p {
    color: #f1f1f1;
    max-width: 520px;
    line-height: 1.6;
    font-size: 16px;
}

.menu-content {
    background: #fff;
    margin-top: -14px;
    border-radius: 26px 26px 0 0;
    padding: 30px 24px 40px;
}

.menu-section-header {
    margin-bottom: 24px;
}

.menu-section-header h2 {
    font-size: 34px;
    color: #111;
    margin: 0 0 10px;
}

.menu-line {
    width: 96px;
    height: 4px;
    background: #c9a24f;
    border-radius: 999px;
}

.menu-list {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.menu-card {
    display: flex;
    gap: 18px;
    align-items: center;
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    border: 1px solid #ece6da;
    padding: 14px;
}

.menu-card-image img {
    width: 170px;
    height: 120px;
    object-fit: cover;
    border-radius: 14px;
    display: block;
}

.menu-card-body {
    flex: 1;
}

.menu-card-body h3 {
    margin: 0 0 8px;
    font-size: 22px;
    color: #111;
    font-weight: 700;
}

.menu-desc {
    color: #555;
    font-size: 15px;
    line-height: 1.5;
    margin-bottom: 14px;
}

.menu-meta {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

.menu-price {
    color: #a8843b;
    font-size: 18px;
    font-weight: 700;
}

.menu-note {
    margin-top: 26px;
    background: #f5efe4;
    border-radius: 18px;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.menu-note-icon {
    font-size: 28px;
    color: #b08a43;
    flex-shrink: 0;
}

.menu-note p {
    margin: 0;
    color: #555;
    line-height: 1.6;
    font-size: 15px;
}

@media (max-width: 768px) {
    .menu-hero {
        height: 220px;
    }

    .menu-hero-text h1 {
        font-size: 30px;
    }

    .menu-section-header h2 {
        font-size: 28px;
    }

    .menu-card {
        flex-direction: column;
        align-items: stretch;
    }

    .menu-card-image img {
        width: 100%;
        height: 220px;
    }

    .menu-meta {
        justify-content: flex-start;
    }
}
</style>
