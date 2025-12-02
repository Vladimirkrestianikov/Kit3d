<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация - KIT3D</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome для иконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ff6b35 0%, #00b4a0 50%, #ff6b35 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 100%;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo h2 {
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .kit {
            color: #FF6B35;
        }

        .three-d {
            color: #4CAF50;
        }

        .tagline {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s;
            width: 100%;
        }

        .form-control:focus {
            border-color: #FF6B35;
            box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
        }

        .btn {
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #FF6B35;
            color: white;
        }

        .btn-primary:hover {
            background-color: #e55a2b;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 107, 53, 0.3);
        }

        .btn-secondary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #3d8b40;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
        }

        .btn-outline {
            border: 2px solid #FF6B35;
            color: #FF6B35;
            background: transparent;
        }

        .btn-outline:hover {
            background-color: #FF6B35;
            color: white;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 15px 20px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .text-danger {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }

        .login-link a {
            color: #FF6B35;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .login-link a:hover {
            text-decoration: underline;
            color: #e55a2b;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }

        .features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 25px;
            margin-bottom: 25px;
        }

       

        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
            }
            
            .logo h2 {
                font-size: 2rem;
            }
            
            .features {
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="logo">
            <h2><span class="kit">KIT</span><span class="three-d">3D</span></h2>
        </div>
        
        <p class="tagline">Создайте аккаунт и начните творить</p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Имя</label>
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Введите ваше имя">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Введите ваш email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Пароль</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Создайте надежный пароль">
                <div class="password-strength">
                    <i class="fas fa-info-circle me-1"></i>Минимум 8 символов
                </div>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Повторите ваш пароль">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Features -->
          

            <!-- Register Button -->
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-user-plus me-2"></i>Создать аккаунт
            </button>
        </form>

        <!-- Login Link -->
        <div class="login-link">
            Уже есть аккаунт? <a href="{{ route('login') }}">Войдите здесь</a>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-3">
            <a href="{{ url('/') }}" style="color: #666; text-decoration: none; font-size: 14px;">
                <i class="fas fa-arrow-left me-2"></i>Вернуться на главную
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Простая проверка сложности пароля
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthText = document.querySelector('.password-strength');
            
            if (password.length === 0) {
                strengthText.innerHTML = '<i class="fas fa-info-circle me-1"></i>Минимум 8 символов';
                strengthText.style.color = '#666';
            } else if (password.length < 8) {
                strengthText.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Слишком короткий пароль';
                strengthText.style.color = '#dc3545';
            } else if (password.length < 12) {
                strengthText.innerHTML = '<i class="fas fa-check me-1"></i>Нормальный пароль';
                strengthText.style.color = '#ffc107';
            } else {
                strengthText.innerHTML = '<i class="fas fa-shield-alt me-1"></i>Надежный пароль!';
                strengthText.style.color = '#28a745';
            }
        });
    </script>
</body>
</html>