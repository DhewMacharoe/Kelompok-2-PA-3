<header class="main-header d-flex justify-content-between align-items-center">

    <div class="d-flex align-items-center gap-3">
        <button class="btn d-md-none" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
            <i class="bi bi-list fs-4"></i>
        </button>
        <h5 class="mb-0 fw-bold">@yield('title', 'Dashboard')</h5>
    </div>
    <div class="ms-auto d-flex align-items-center gap-3">
        <span class="fw-semibold">Admin Mode</span>
        <img src="https://ui-avatars.com/api/?name=Admin&background=0578FB&color=fff" class="rounded-circle" width="35" alt="Profile">
        <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
    </div>

</header>
