@extends('pelanggan.layouts.app')

@section('title', 'Menu Kafe')

@push('styles')
    @include('pelanggan.menu.styles')
@endpush

@section('content')
    <section class="menu-hero">
        <div class="menu-hero-overlay">
            <div class="menu-hero-text">
                <h1>Menu Café</h1>
                <p>Nikmati berbagai pilihan minuman kopi yang tersedia di barbershop kami.</p>
            </div>
        </div>
    </section>

    <section class="menu-content">
        <!-- Filter dan Search -->
        <div class="menu-filter-section">
            <input type="text" id="searchMenu" class="menu-search" placeholder="Cari menu...">
            <div class="menu-category-filter">
                <button class="filter-btn active" data-filter="semua">Semua</button>
                <button class="filter-btn" data-filter="Makanan">Makanan</button>
                <button class="filter-btn" data-filter="Minuman">Minuman</button>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="menu-grid-container">
            @php
                $groupedMenus = collect($menus)->groupBy('kategori');
            @endphp
            @foreach($groupedMenus as $kategori => $menuItems)
                <div class="menu-category-section" data-category="{{ $kategori }}">
                    <div class="category-header">
                        <h3 class="category-title">{{ strtoupper($kategori) }}</h3>
                        <p class="category-desc">Pilihan {{ strtolower($kategori) }} terbaik kami</p>
                    </div>
                    <div class="category-items">
                        @forelse ($menuItems as $menu)
                            <div class="menu-item" data-name="{{ strtolower($menu->nama) }}" data-description="{{ e($menu->deskripsi) }}" data-price="{{ number_format($menu->harga, 0, ',', '.') }}" data-category="{{ $menu->kategori }}" data-status="{{ $menu->is_available ? 'Aktif' : 'Nonaktif' }}" data-image="{{ $fotoMenu = !empty($menu->foto) ? (\Illuminate\Support\Str::startsWith($menu->foto, ['http://', 'https://']) ? $menu->foto : asset('images/' . $menu->foto)) : 'https://via.placeholder.com/400x300?text=No+Image' }}">
                                <div class="menu-item-image">
                                    <img src="{{ $fotoMenu }}" alt="{{ $menu->nama }}">
                                    @if (!$menu->is_available)
                                        <div class="item-badge-sold">Habis</div>
                                    @endif
                                </div>
                                <div class="menu-item-info">
                                    <h4>{{ $menu->nama }}</h4>
                                    <p class="item-desc">{{ $menu->deskripsi ?? '-' }}</p>
                                    <div class="item-footer">
                                        <span class="item-price">Rp{{ number_format($menu->harga, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Tidak ada menu dalam kategori ini.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

    </section>

    <div class="modal-overlay" id="menuDetailModal">
        <div class="modal-card">
            <button class="modal-close" id="modalCloseBtn">×</button>
            <div class="modal-image-wrapper">
                <img src="" alt="Menu Image" id="modalMenuImage">
            </div>
            <div class="modal-content">
                <h3 id="modalMenuName"></h3>
                <p class="modal-category" id="modalMenuCategory"></p>
                <p class="d-none" class="modal-status" id="modalMenuStatus"></p>
                <p class="modal-description" id="modalMenuDescription"></p>
                <div class="modal-footer">
                    <span class="modal-price" id="modalMenuPrice"></span>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const searchInput = document.getElementById('searchMenu');
        const categorySections = document.querySelectorAll('.menu-category-section');

        // Filter by category
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const selectedFilter = this.dataset.filter;
                
                // Update active button
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Show/hide categories
                categorySections.forEach(section => {
                    const category = section.dataset.category;
                    if (selectedFilter === 'semua' || category === selectedFilter) {
                        section.classList.remove('hidden');
                    } else {
                        section.classList.add('hidden');
                    }
                });
            });
        });

        // Check URL for category filter
        const urlParams = new URLSearchParams(window.location.search);
        const filterParam = urlParams.get('kategori');
        if (filterParam) {
            const activeBtn = document.querySelector(`.filter-btn[data-filter="${filterParam}"]`);
            if (activeBtn) {
                activeBtn.click();
            }
        }

        // Search functionality
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const menuItems = document.querySelectorAll('.menu-item');

            menuItems.forEach(item => {
                const itemName = item.dataset.name || '';
                if (itemName.includes(searchTerm)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });

        // Modal detail popup
        const modalOverlay = document.getElementById('menuDetailModal');
        const modalCloseBtn = document.getElementById('modalCloseBtn');
        const modalMenuImage = document.getElementById('modalMenuImage');
        const modalMenuName = document.getElementById('modalMenuName');
        const modalMenuCategory = document.getElementById('modalMenuCategory');
        const modalMenuStatus = document.getElementById('modalMenuStatus');
        const modalMenuDescription = document.getElementById('modalMenuDescription');
        const modalMenuPrice = document.getElementById('modalMenuPrice');

        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', function() {
                modalMenuImage.src = this.dataset.image;
                modalMenuName.textContent = this.querySelector('h4').textContent;
                modalMenuCategory.textContent = 'Kategori: ' + this.dataset.category;
                modalMenuStatus.textContent = 'Status: ' + this.dataset.status;
                modalMenuDescription.textContent = this.dataset.description || '-';
                modalMenuPrice.textContent = 'Rp ' + this.dataset.price;
                modalOverlay.classList.add('active');
            });
        });

        modalCloseBtn.addEventListener('click', function() {
            modalOverlay.classList.remove('active');
        });

        modalOverlay.addEventListener('click', function(event) {
            if (event.target === modalOverlay) {
                modalOverlay.classList.remove('active');
            }
        });
    });
</script>
@endpush
@endsection
