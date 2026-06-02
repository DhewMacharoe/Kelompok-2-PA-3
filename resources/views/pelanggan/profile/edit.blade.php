@extends('pelanggan.layouts.app')

    @section('title', 'Ubah Profil')

@push('styles')
    @include('pelanggan.shared.style-common')
    <style>
        @media (max-width: 767.98px) {
            .profile-card .form-field__help,
            .profile-card .form-text,
            .profile-card .invalid-feedback {
                font-size: 14px !important;
            }
            .profile-card .alert-dismissible .btn-close {
                min-width: 44px;
                min-height: 44px;
                padding: 1.25rem !important;
            }
        }
    </style>
@endpush

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0 profile-card">
                <div class="card-header text-center text-white py-4 profile-card-header-dark">
                    <h4 class="mb-0 fw-bold profile-card-title-gold">Profil Saya</h4>
                </div>
                <div class="card-body p-3 p-sm-4 p-md-5">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-form.field
                                label="Email"
                                name="email"
                                type="email"
                                :value="$user->email"
                                readonly
                                disabled
                                wrapperClass="mb-0"
                                labelClass="form-label fw-bold text-secondary"
                                controlClass="form-control-lg bg-light"
                                help="Email Anda terhubung dengan Firebase dan tidak dapat diubah."
                            />
                        </div>

                        <x-form.field
                            label="Username"
                            name="username"
                            type="text"
                            id="username"
                            :value="$user->username"
                            placeholder="Masukkan username baru..."
                            help="Klik Ubah Username untuk mengaktifkan field ini."
                            wrapperClass="mb-4"
                            labelClass="form-label fw-bold text-secondary"
                            controlClass="form-control-lg"
                            readonly
                            required
                        />

                        <div class="d-grid gap-2 mt-5" id="action-buttons" data-open-edit-mode="{{ $errors->has('username') ? '1' : '0' }}">
                            <button type="button" id="btn-edit" class="btn btn-lg fw-bold btn-outline-secondary profile-action-button">
                                <i class="fas fa-edit me-2"></i>Ubah Username
                            </button>
                            <button type="submit" id="btn-save" class="btn btn-lg fw-bold d-none btn-success profile-action-button profile-action-button--save">
                                Simpan Perubahan
                            </button>
                            <button type="button" id="btn-cancel" class="btn btn-lg fw-bold btn-outline-danger d-none profile-action-button">
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
        const actionButtons = document.getElementById('action-buttons');
        const shouldOpenEditMode = actionButtons && actionButtons.dataset.openEditMode === '1';

        if (shouldOpenEditMode) {
            enableEditMode();
        }

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
