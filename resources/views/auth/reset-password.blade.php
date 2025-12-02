<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сброс пароля - KIT3D</title>
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

        .reset-container {
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
            background: rgba(0, 180, 160, 0.1);
            padding: 15px;
            border-radius: 10px;
            border-left: 4px solid #00b4a0;
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

        .form-control[readonly] {
            background-color: #f8f9fa;
            border-color: #ced4da;
            color: #6c757d;
            cursor: not-allowed;
        }

        .email-display {
            background: rgba(255, 107, 53, 0.1);
            border: 2px solid #FF6B35;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            color: #333;
            font-weight: 500;
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

        .btn-success {
            background-color: #4CAF50;
            color: white;
        }

        .btn-success:hover {
            background-color: #3d8b40;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(76, 175, 80, 0.3);
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

        .text-success {
            color: #28a745;
            font-size: 14px;
            margin-top: 5px;
            display: block;
        }

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            color: #666;
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
            color: #4CAF50;
            text-align: center;
            margin-bottom: 20px;
        }

        .password-requirements {
            background: rgba(255, 107, 53, 0.1);
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #FF6B35;
        }

        .password-requirements h6 {
            color: #FF6B35;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
            color: #666;
            font-size: 0.9rem;
        }

        .password-requirements li {
            margin-bottom: 5px;
        }

        @media (max-width: 480px) {
            .reset-container {
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
    <div class="reset-container">
        <div class="logo">
            <h2><span class="kit">KIT</span><span class="three-d">3D</span></h2>
        </div>

        <div class="icon-large">
            <i class="fas fa-lock"></i>
        </div>
        
        <div class="info-text">
            <strong>Создайте новый пароль</strong><br>
            Введите новый пароль для вашего аккаунта
        </div>

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

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address (Readonly) -->
            <div class="form-group">
                <label class="form-label">Ваш email</label>
                <div class="email-display">
                    <i class="fas fa-envelope me-2"></i>{{ $request->email }}
                </div>
                <input type="hidden" name="email" value="{{ $request->email }}">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password Requirements -->
            <div class="password-requirements">
                <h6><i class="fas fa-shield-alt me-2"></i>Требования к паролю:</h6>
                <ul>
                    <li>Минимум 8 символов</li>
                    <li>Рекомендуется использовать буквы и цифры</li>
                    <li>Можно использовать специальные символы</li>
                </ul>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Новый пароль</label>
                <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" placeholder="Введите новый пароль">
                <div class="password-strength">
                    <i class="fas fa-info-circle me-1"></i>Индикатор сложности пароля
                </div>
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Повторите новый пароль">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i>Сохранить новый пароль
            </button>
        </form>

        <!-- Links -->
        <div class="links">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-1"></i>Вернуться к входу
            </a>
            <a href="{{ url('/') }}">
                <i class="fas fa-home me-1"></i>На главную
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Индикатор сложности пароля
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthText = document.querySelector('.password-strength');
            
            if (password.length === 0) {
                strengthText.innerHTML = '<i class="fas fa-info-circle me-1"></i>Введите пароль';
                strengthText.style.color = '#666';
            } else if (password.length < 6) {
                strengthText.innerHTML = '<i class="fas fa-exclamation-triangle me-1"></i>Слишком короткий пароль';
                strengthText.style.color = '#dc3545';
            } else if (password.length < 8) {
                strengthText.innerHTML = '<i class="fas fa-check me-1"></i>Слабый пароль';
                strengthText.style.color = '#ffc107';
            } else if (password.length < 12) {
                strengthText.innerHTML = '<i class="fas fa-shield me-1"></i>Хороший пароль';
                strengthText.style.color = '#17a2b8';
            } else {
                strengthText.innerHTML = '<i class="fas fa-shield-alt me-1"></i>Отличный пароль!';
                strengthText.style.color = '#28a745';
            }
        });

        // Проверка совпадения паролей
        document.getElementById('password_confirmation').addEventListener('input', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = e.target.value;
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    e.target.style.borderColor = '#28a745';
                    e.target.style.boxShadow = '0 0 0 0.2rem rgba(40, 167, 69, 0.25)';
                } else {
                    e.target.style.borderColor = '#dc3545';
                    e.target.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
                }
            }
        });

        // Анимация появления
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.reset-container');
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