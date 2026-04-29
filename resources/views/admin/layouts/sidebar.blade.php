<nav class="sidebar shadow py-4">
    <div class="px-4 mb-4">
        <div class="d-flex justify-content-end d-md-none mb-2">
            <button type="button" class="btn btn-sm btn-outline-light" id="mobileSidebarClose" aria-label="Tutup menu">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <h4 class="fw-bold m-0 text-white"><span style="color: var(--primary-blue)"></span></h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="/admin/dashboard">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/antrian*') ? 'active' : '' }}" href="/admin/antrian">
                <i class="bi bi-people"></i> Antrean
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/galeri*') ? 'active' : '' }}" href="{{ route('admin.galeri.index') }}">
                <i class="bi bi-images"></i> Galeri
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/admin/layanan">
                <i class="bi bi-gear"></i> Layanan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/menu*') ? 'active' : '' }}" href="/admin/menu">
                <i class="bi bi-cup"></i> Menu Cafe
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/rekap*') ? 'active' : '' }}" href="{{ route('admin.rekap') }}">
                <i class="bi bi-receipt"></i> Rekap Pemasukan
            </a>
        </li>
    </ul>
</nav>
