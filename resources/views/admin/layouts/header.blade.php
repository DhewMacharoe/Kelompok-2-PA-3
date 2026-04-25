<header class="main-header d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-3">
        <button class="btn d-md-none p-1" id="mobileSidebarToggle" type="button" aria-label="Buka menu">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h5 class="mb-0 fw-bold text-truncate">@yield('title', 'Dashboard')</h5>
    </div>
    <div class="ms-auto d-flex align-items-center gap-3">
        <img src="https://ui-avatars.com/api/?name=Admin&background=0578FB&color=fff" class="rounded-circle" width="35" alt="Profile">
        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit"
                style="padding: 6px 10px; background: #dc3545; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 12px; line-height: 1;">
                Logout
            </button>
        </form>
    </div>

</header>
