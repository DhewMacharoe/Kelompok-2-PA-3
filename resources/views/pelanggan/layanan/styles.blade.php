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
        height: 200px;
    }

    .layanan-hero-text h1 {
        font-size: 28px;
    }

    .layanan-section-header h3 {
        font-size: 24px;
        text-align: center;
    }

    .layanan-content {
        padding: 24px 16px 40px;
    }

    .layanan-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .layanan-card {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 16px 12px;
        gap: 8px;
        border-radius: 16px;
        border: 1px solid #f0ede5;
    }

    .layanan-card .icon-circle {
        width: 46px;
        height: 46px;
        font-size: 20px;
        margin-bottom: 4px;
    }

    .layanan-card-body {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .layanan-card-body h4 {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 6px;
        line-height: 1.3;
    }

    .layanan-desc {
        font-size: 11px;
        color: #666;
        margin-bottom: 10px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .layanan-time {
        font-size: 11px;
        color: #777;
        margin-bottom: 8px;
        background: #f9f8f3;
        padding: 4px 10px;
        border-radius: 99px;
        border: 1px solid #ece6da;
    }

    .layanan-price {
        font-size: 15px;
        font-weight: 800;
        color: #c9a24f;
    }
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.55);
    display: none;
    align-items: center;
    justify-content: center;
    padding: 24px;
    z-index: 9999;
}

.modal-overlay.active {
    display: flex;
}

.modal-card {
    width: min(560px, 100%);
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
    position: relative;
}

.modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    background: transparent;
    border: none;
    font-size: 28px;
    line-height: 1;
    cursor: pointer;
    color: #333;
}

.modal-content {
    padding: 24px;
}

.modal-content h3 {
    margin: 0 0 12px;
    font-size: 24px;
    color: #111;
}

.modal-category {
    display: inline-block;
    margin: 0 10px 10px 0;
    font-size: 13px;
    color: #666;
}

.modal-description {
    color: #444;
    font-size: 15px;
    line-height: 1.7;
    margin: 16px 0 20px;
}

.modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-price {
    color: #c9a24f;
    font-size: 20px;
    font-weight: 800;
}
</style>
