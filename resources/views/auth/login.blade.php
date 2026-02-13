<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIPERSURAT DPRD Prov. Sumsel</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-green: #1B5E20;
            --secondary-green: #2E7D32;
            --accent-gold: #C9A227;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #1B5E20 0%, #0d330f 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Circles */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            z-index: 0;
        }
        .circle-1 { width: 400px; height: 400px; top: -100px; left: -100px; }
        .circle-2 { width: 300px; height: 300px; bottom: -50px; right: -50px; }

        .login-card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
            z-index: 1;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .login-left {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-left::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .login-right {
            background-color: white;
            padding: 50px;
        }

        .logo-img {
            max-width: 120px;
            margin-bottom: 20px;
            border-radius: 50%;
            background: white;
            padding: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-gold);
            box-shadow: 0 0 0 0.25rem rgba(201, 162, 39, 0.15);
            background-color: white;
        }

        .input-group-text {
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            background-color: #f8f9fa;
            color: #6c757d;
            cursor: pointer;
        }

        .btn-login {
            background: linear-gradient(to right, var(--primary-green), var(--secondary-green));
            color: white;
            padding: 14px;
            border-radius: 10px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(27, 94, 32, 0.2);
        }

        .btn-login:hover {
            background: linear-gradient(to right, var(--secondary-green), var(--primary-green));
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(27, 94, 32, 0.3);
            color: white;
        }

        h2 {
            font-family: 'Playfair Display', serif;
            color: var(--primary-green);
            font-weight: bold;
            font-size: 2rem;
        }
        
        .form-label {
            font-size: 0.8rem;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="circle circle-1"></div>
    <div class="circle circle-2"></div>

    <div class="container px-4">
        <div class="card login-card mx-auto">
            <div class="row g-0">
                <div class="col-md-5 login-left d-none d-md-flex">
                    <div class="d-flex flex-column justify-content-center align-items-center flex-grow-1 w-100">
                        <img src="{{ asset('img/logo.jpg') }}" alt="Logo DPRD" class="logo-img">
                        <h4 class="fw-bold mt-3 mb-1 font-monospace">SIPERSURAT</h4>
                        <p class="small opacity-90 mb-0">Sistem Informasi Persuratan</p>
                        <p class="small opacity-75">DPRD Provinsi Sumatera Selatan</p>
                    </div>
                    <div class="text-warning small opacity-75">
                        &copy; 2026 Sekretariat DPRD Sumsel
                    </div>
                </div>
                <div class="col-md-7 login-right">
                    <div class="text-center mb-4 d-md-none">
                        <img src="{{ asset('img/logo.jpg') }}" alt="Logo DPRD" class="logo-img" style="width: 80px;">
                    </div>
                    <div class="text-center mb-5">
                        <h2 class="mb-2">Selamat Datang</h2>
                        <p class="text-muted small">Silakan masuk untuk mengakses dashboard</p>
                    </div>
                    
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="username" class="form-label text-muted fw-bold text-uppercase">Username</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control border-start-0 ps-0" id="username" name="username" placeholder="Masukkan username Anda" required>
                            </div>
                        </div>
                        <div class="mb-5">
                            <label for="password" class="form-label text-muted fw-bold text-uppercase">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-lock"></i></span>
                                <input type="password" class="form-control border-start-0 border-end-0 ps-0" id="password" name="password" placeholder="Masukkan password Anda" required>
                                <span class="input-group-text bg-white border-start-0" id="togglePassword" style="cursor: pointer;">
                                    <i class="bi bi-eye-slash" id="eyeIcon"></i>
                                </span>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-login btn-lg">
                                MASUK APLIKASI <i class="bi bi-arrow-right-short ms-1"></i>
                            </button>
                        </div>
                    </form>
                    
                 
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function (e) {
            // toggle the type attribute
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            
            // toggle the icon
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>
</body>
</html>
