<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Aplikasi Makan Bergizi Gratis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4f65d6, #7a8cff);
            height: 100vh;
            margin: 0;
        }

        .login-container {
            height: 100vh;
        }

        .login-card {
            border-radius: 20px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .login-left {
            background: linear-gradient(135deg, #4f65d6, #6f86ff);
            color: white;
            border-radius: 20px 0 0 20px;
            padding: 40px;
        }

        .login-left h2 {
            font-weight: 600;
        }

        .login-left p {
            opacity: 0.9;
        }

        .login-right {
            padding: 40px;
        }

        .form-control {
            border-radius: 10px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4f65d6;
        }

        .btn-primary {
            background: #4f65d6;
            border: none;
            border-radius: 10px;
            padding: 10px;
        }

        .btn-primary:hover {
            background: #3c52c7;
        }

        .input-group-text {
            border-radius: 10px 0 0 10px;
        }

        /* LOGO */
        .brand-logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
            padding: 0;
            background: transparent;   /* hilangkan putih */
            border-radius: 0;         /* hilangkan lingkaran */
            box-shadow: none;         /* hilangkan bayangan */
        }

        @media (max-width: 768px) {
            .login-left {
                display: none;
            }
        }
    </style>
</head>

<body>

<div class="container login-container d-flex align-items-center justify-content-center">
    <div class="row shadow-lg login-card w-100" style="max-width: 900px;">

        <!-- LEFT (BRANDING) -->
        <div class="col-md-6 login-left d-flex flex-column justify-content-center">
            <div class="text-center">

                <!-- LOGO -->
                <img src="assets/profile/logo_smancigo.png" class="brand-logo mb-3" alt="Logo SMANCIGO">

                <h4 class="mt-2">Aplikasi MBG SMANCIGO</h4>
                <p>Makan Bergizi Gratis untuk Siswa Indonesia 🇮🇩</p>

                <hr class="bg-white">

                <small>
                    Sistem ini digunakan untuk mengelola pemesanan dan distribusi makanan bergizi di sekolah.
                </small>
            </div>
        </div>

        <!-- RIGHT (FORM) -->
        <div class="col-md-6 login-right">

            <h4 class="mb-3 fw-semibold">Login Sistem</h4>
            <p class="text-muted">Silakan masuk untuk melanjutkan</p>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger">
                    <?= $_GET['error']; ?>
                </div>
            <?php endif; ?>

            <form action="index.php?url=auth/login" method="POST">

                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input name="username" class="form-control" placeholder="Masukkan NIS / Username" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input name="password" type="password" class="form-control" placeholder="Masukkan Password" required>
                    </div>
                </div>

                <button class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>

            </form>

        </div>

    </div>
</div>

</body>
</html>