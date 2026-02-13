@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold" style="color: var(--primary-green)">Profil Pengguna</h2>
        <p class="text-muted">Kelola informasi profil akun Anda</p>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card card-custom">
            <div class="card-header card-header-custom py-3">
                <h5 class="card-title mb-0"><i class="bi bi-person-gear me-2"></i> Edit Profil</h5>
            </div>
            <div class="card-body p-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3 text-center">
                        <div class="avatar-circle mb-3 mx-auto bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center rounded-circle" style="width: 100px; height: 100px; font-size: 3rem;">
                            <i class="bi bi-person"></i>
                        </div>
                        <h5 class="fw-bold">{{ session('user_name') }}</h5>
                        <span class="badge bg-gold text-white" style="background-color: var(--accent-gold);">{{ session('user_role') }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" name="name" value="{{ session('user_name') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Role / Jabatan</label>
                        <input type="text" class="form-control bg-light" value="{{ session('user_role') }}" readonly>
                        <div class="form-text">Role tidak dapat diubah.</div>
                    </div>

                    <hr class="my-4">
                    
                    <h6 class="fw-bold mb-3 text-secondary">Ganti Password (Opsional)</h6>

                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password" id="newPassword" placeholder="Kosongkan jika tidak ingin mengganti">
                            <span class="input-group-text bg-white" onclick="togglePasswordVisibility('newPassword', 'iconNewPassword')" style="cursor: pointer;">
                                <i class="bi bi-eye-slash" id="iconNewPassword"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" name="password_confirmation" id="confirmPassword" placeholder="Ulangi password baru">
                            <span class="input-group-text bg-white" onclick="togglePasswordVisibility('confirmPassword', 'iconConfirmPassword')" style="cursor: pointer;">
                                <i class="bi bi-eye-slash" id="iconConfirmPassword"></i>
                            </span>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-gold fw-bold">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
@endsection
