<nav class="sidebar shadow py-4">
    <div class="px-4 mb-4">
        <h4 class="fw-bold m-0 text-white">Antrean<span style="color: var(--primary-blue)">App</span></h4>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('antrean*') ? 'active' : '' }}" href="#">
                <i class="bi bi-people"></i> Antrean
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-images"></i> Galeri
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="bi bi-gear"></i> Layanan
            </a>
        </li>
    </ul>
</nav>
