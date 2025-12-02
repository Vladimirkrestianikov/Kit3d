<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Восстановление пароля - KIT3D</title>
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

        .password-container {
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

        .info-text {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1rem;
            line-height: 1.6;
            background: rgba(255, 107, 53, 0.1);
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #FF6B35;
        }

        .form-group {
            margin-bottom: 25px;
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
            border-left: 4px solid #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .text-danger {
            color: #dc3545;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .links {
            text-align: center;
            margin-top: 25px;
        }

        .links a {
            color: #FF6B35;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            display: inline-block;
            margin: 0 10px;
        }

        .links a:hover {
            text-decoration: underline;
            color: #e55a2b;
        }

        .icon-large {
            font-size: 3rem;
            color: #FF6B35;
            text-align: center;
            margin-bottom: 20px;
        }

        .steps {
            background: rgba(0, 180, 160, 0.1);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #00b4a0;
        }

        .steps h6 {
            color: #00b4a0;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .steps ol {
            margin: 0;
            padding-left: 20px;
            color: #666;
        }

        .steps li {
            margin-bottom: 5px;
        }

        @media (max-width: 480px) {
            .password-container {
                padding: 30px 20px;
            }
            
            .logo h2 {
                font-size: 2rem;
            }
            
            .links a {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="password-container">
        <div class="logo">
            <h2><span class="kit">KIT</span><span class="three-d">3D</span></h2>
        </div>

        <div class="icon-large">
            <i class="fas fa-key"></i>
        </div>
        
        <div class="info-text">
            Забыли пароль? Не проблема! Просто укажите ваш email и мы вышлем вам ссылку для сброса пароля.
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Steps -->
        <div class="steps">
            <h6><i class="fas fa-list-ol me-2"></i>Как это работает:</h6>
            <ol>
                <li>Введите ваш email</li>
                <li>Нажмите "Отправить ссылку"</li>
                <li>Проверьте почту и перейдите по ссылке</li>
                <li>Создайте новый пароль</li>
            </ol>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="Введите ваш email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i>Отправить ссылку для сброса
            </button>
        </form>

        <!-- Links -->
        <div class="links">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-1"></i>Вернуться к входу
            </a>
            <a href="{{ route('register') }}">
                <i class="fas fa-user-plus me-1"></i>Создать аккаунт
            </a>
            <a href="{{ url('/') }}">
                <i class="fas fa-home me-1"></i>На главную
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Простая анимация появления
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.password-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>