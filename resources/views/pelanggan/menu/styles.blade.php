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

/* Filter Section */
.menu-filter-section {
    margin-bottom: 32px;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.menu-search {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    background: #f9f8f3;
}

.menu-search::placeholder {
    color: #999;
}

.menu-category-filter {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.filter-btn {
    padding: 10px 20px;
    border: 2px solid #e0ddd2;
    background: white;
    color: #555;
    border-radius: 999px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-btn:hover {
    border-color: #c9a24f;
    color: #c9a24f;
}

.filter-btn.active {
    background: #c9a24f;
    border-color: #c9a24f;
    color: white;
}

/* Menu Grid Container */
.menu-grid-container {
    display: flex;
    flex-direction: column;
    gap: 48px;
}

.menu-category-section {
    opacity: 1;
    transition: opacity 0.3s ease;
}

.menu-category-section.hidden {
    display: none;
}

.category-header {
    margin-bottom: 20px;
}

.category-title {
    font-size: 24px;
    color: #111;
    font-weight: 700;
    margin: 0 0 8px;
    letter-spacing: 1px;
}

.category-desc {
    color: #999;
    font-size: 14px;
    margin: 0;
}

.category-items {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.menu-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    cursor: pointer;
    border: 1px solid #f0ede5;
}

.menu-item:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    transform: translateY(-4px);
}

.menu-item-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f5f2ed;
    position: relative;
}

.menu-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-badge-sold {
    position: absolute;
    top: 12px;
    right: 12px;
    background: rgba(183, 28, 28, 0.9);
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
}

.menu-item-info {
    padding: 16px;
}

.menu-item-info h4 {
    margin: 0 0 8px;
    font-size: 16px;
    color: #111;
    font-weight: 700;
}

.item-desc {
    color: #666;
    font-size: 13px;
    line-height: 1.4;
    margin: 0 0 12px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.item-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.item-price {
    color: #c9a24f;
    font-size: 16px;
    font-weight: 700;
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

.modal-image-wrapper {
    width: 100%;
    height: 260px;
    overflow: hidden;
    background: #f5f2ed;
}

.modal-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.modal-content {
    padding: 24px;
}

.modal-content h3 {
    margin: 0 0 12px;
    font-size: 24px;
    color: #111;
}

.modal-category,
.modal-status {
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

.menu-category {
    margin-bottom: 40px;
}

.category-title {
    font-size: 28px;
    color: #111;
    margin-bottom: 20px;
    font-weight: 700;
    border-bottom: 2px solid #c9a24f;
    padding-bottom: 10px;
}

.menu-items {
    display: flex;
    flex-direction: column;
    gap: 18px;
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

    .menu-filter-section {
        margin-bottom: 24px;
    }

    .menu-category-filter {
        gap: 8px;
    }

    .filter-btn {
        padding: 8px 16px;
        font-size: 12px;
    }

    .category-title {
        font-size: 20px;
    }

    .category-items {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }

    .menu-item-image {
        height: 160px;
    }

    .menu-item-info {
        padding: 12px;
    }

    .menu-item-info h4 {
        font-size: 14px;
    }

    .item-price {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .menu-content {
        padding: 20px 16px 30px;
    }

    .menu-section-header h2 {
        font-size: 24px;
    }

    .category-items {
        grid-template-columns: 1fr;
    }

    .menu-filter-section {
        flex-direction: column;
    }

    .menu-category-filter {
        justify-content: flex-start;
        overflow-x: auto;
        padding-bottom: 8px;
    }
}
</style>
