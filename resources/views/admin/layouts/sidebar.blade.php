<nav class="sidebar shadow py-4">
    <div class="px-4 mb-4">
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
            <a class="nav-link" href="/admin/galeri">
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
    </ul>
</nav>
