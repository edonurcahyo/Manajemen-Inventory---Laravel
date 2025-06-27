<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CV. Agung Inventory</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0f2027, #2c5364);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 450px;
        }

        .login-header {
            background: linear-gradient(135deg, #0f2027, #2c5364);
            color: white;
            padding: 2rem;
            text-align: center;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }

        .form-control:focus {
            border-color: #2c5364;
            box-shadow: 0 0 0 0.2rem rgba(44, 83, 100, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #0f2027, #2c5364);
            border: none;
            padding: 10px;
            font-weight: bold;
            color: white;
        }

        .btn-login:hover {
            background: #1c3d5a;
        }

        a {
            color: #2c5364;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h3><i class="fas fa-box me-2"></i>CV. Agung Inventory</h3>
            <p class="mb-0">Masuk ke akun Anda</p>
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label"><i class="fas fa-user me-1"></i>Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required autofocus>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fas fa-lock me-1"></i>Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt me-1"></i>Masuk
                    </button>
                </div>
            </form>

            <div class="text-center mt-3">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
            </div>
        </div>
    </div>
</body>
</html>
