@extends('pelanggan.layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header text-center text-white py-4" style="background-color: #1a1a1a; border-bottom: 3px solid #d4af37;">
                    <h4 class="mb-0 fw-bold" style="color: #d4af37;">Profil Saya</h4>
                </div>
                <div class="card-body p-4 p-md-5">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Email</label>
                            <input type="email" class="form-control form-control-lg bg-light" 
                                value="{{ $user->email }}" readonly disabled>
                            <div class="form-text mt-1">Email Anda terhubung dengan Firebase dan tidak dapat diubah.</div>
                        </div>

                        <div class="mb-4">
                            <label for="username" class="form-label fw-bold text-secondary">Username</label>
                            <input type="text" class="form-control form-control-lg @error('username') is-invalid @enderror" 
                                id="username" name="username" value="{{ old('username', $user->username) }}" 
                                placeholder="Masukkan username baru..." required readonly>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-5" id="action-buttons">
                            <button type="button" id="btn-edit" class="btn btn-lg fw-bold btn-outline-secondary" style="border-radius: 8px;">
                                <i class="fas fa-edit me-2"></i>Edit Username
                            </button>
                            <button type="submit" id="btn-save" class="btn btn-lg fw-bold d-none" style="background-color: #d4af37; color: #1a1a1a; border-radius: 8px;">
                                Simpan Perubahan
                            </button>
                            <button type="button" id="btn-cancel" class="btn btn-lg fw-bold btn-outline-danger d-none" style="border-radius: 8px;">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnEdit = document.getElementById('btn-edit');
        const btnSave = document.getElementById('btn-save');
        const btnCancel = document.getElementById('btn-cancel');
        const usernameInput = document.getElementById('username');
        const originalUsername = usernameInput.value;

        @if($errors->has('username'))
            enableEditMode();
        @endif

        btnEdit.addEventListener('click', function() {
            enableEditMode();
            usernameInput.focus();
        });

        btnCancel.addEventListener('click', function() {
            disableEditMode();
            usernameInput.value = originalUsername;
        });

        function enableEditMode() {
            usernameInput.removeAttribute('readonly');
            btnEdit.classList.add('d-none');
            btnSave.classList.remove('d-none');
            btnCancel.classList.remove('d-none');
        }

        function disableEditMode() {
            usernameInput.setAttribute('readonly', 'true');
            btnEdit.classList.remove('d-none');
            btnSave.classList.add('d-none');
            btnCancel.classList.add('d-none');
            usernameInput.classList.remove('is-invalid');
            const feedback = document.querySelector('.invalid-feedback');
            if (feedback) feedback.style.display = 'none';
        }
    });
</script>
@endpush
