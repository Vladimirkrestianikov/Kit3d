<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль - KIT3D</title>
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
            background-color: #ffffff;
            color: #333333;
            line-height: 1.6;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Навигация */
        header {
            background-color: #ffffff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo h2 {
            font-weight: 700;
            font-size: 28px;
        }

        .kit {
            color: #FF6B35;
        }

        .three-d {
            color: #4CAF50;
        }

        .nav-links {
            display: flex;
            list-style: none;
            margin-bottom: 0;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .nav-links a:hover, .nav-links a.active {
            color: #FF6B35;
        }

        .nav-links a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #FF6B35;
        }

        .nav-actions {
            display: flex;
            align-items: center;
        }

        .search-box {
            position: relative;
            margin-right: 20px;
        }

        .search-box input {
            padding: 10px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 30px;
            width: 200px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s;
        }

        .search-box input:focus {
            border-color: #FF6B35;
            width: 250px;
        }

        .search-box i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #777;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
        }

        .profile-icon:hover {
            background-color: #FF6B35;
            color: white;
        }

        /* Основной контент */
        main {
            margin-top: 100px;
            padding: 40px 0;
        }

        /* Стили для профиля */
        .profile-section {
            background: #f8f9fa;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            border: 1px solid #e9ecef;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-header h1 {
            color: #333;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .profile-header p {
            color: #666;
            font-size: 1.1rem;
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .form-card h3 {
            color: #FF6B35;
            margin-bottom: 25px;
            font-weight: 600;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s;
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

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(220, 53, 69, 0.3);
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

        /* Стили для процесса удаления */
        .step-card {
            border: 2px solid #e9ecef;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .step-header {
            background: linear-gradient(135deg, #fff5f5, #fed7d7);
            padding: 15px 20px;
            font-weight: 600;
            border-bottom: 1px solid #fed7d7;
            color: #dc3545;
        }

        .step-body {
            padding: 20px;
            background: #f8f9fa;
        }

        .deletion-warning {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .btn-outline-danger {
            border: 2px solid #dc3545;
            color: #dc3545;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        /* Адаптивность */
        @media (max-width: 992px) {
            .navbar {
                flex-direction: column;
                padding: 15px 0;
            }
            
            .nav-links {
                margin: 15px 0;
            }
            
            .nav-links li {
                margin-left: 15px;
                margin-right: 15px;
            }
            
            .nav-actions {
                width: 100%;
                justify-content: center;
            }
            
            .search-box {
                flex-grow: 1;
                max-width: 300px;
            }
            
            main {
                margin-top: 150px;
            }

            .profile-section {
                padding: 30px 20px;
            }
        }

        @media (max-width: 576px) {
            .nav-links {
                flex-direction: column;
                align-items: center;
            }
            
            .nav-links li {
                margin: 5px 0;
            }
            
            .nav-actions {
                flex-direction: column;
            }
            
            .search-box {
                margin-right: 0;
                margin-bottom: 10px;
                width: 100%;
                max-width: none;
            }
            
            .search-box input {
                width: 100%;
            }
            
            .search-box input:focus {
                width: 100%;
            }

            .form-card {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
   @extends('layouts.app')

    <main class="py-4">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="profile-section">
                <div class="profile-header">
                    <h1>Настройки профиля</h1>
                    <p>Управляйте информацией вашего аккаунта</p>
                </div>

                <!-- Обновление информации профиля -->
                <div class="form-card">
                    <h3><i class="fas fa-user-edit me-2"></i>Информация профиля</h3>
                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </form>
                </div>

                <!-- Смена пароля -->
                <div class="form-card">
                    <h3><i class="fas fa-lock me-2"></i>Смена пароля</h3>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="current_password" class="form-label">Текущий пароль</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Новый пароль</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Подтвердите новый пароль</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Обновить пароль</button>
                    </form>
                </div>

                <!-- Удаление аккаунта -->
                <div class="form-card">
                    <h3><i class="fas fa-trash-alt me-2"></i>Удаление аккаунта</h3>
                    
                    <div class="deletion-warning">
                        <div class="d-flex">
                            <i class="fas fa-exclamation-triangle fa-2x text-warning me-3"></i>
                            <div>
                                <h5 class="alert-heading mb-2">Внимание!</h5>
                                <p class="mb-0">Это действие невозможно отменить. Все ваши данные, включая 3D модели, будут удалены навсегда.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Основная кнопка -->
                    <button type="button" class="btn btn-outline-danger w-100 py-3" onclick="initiateDeletion()">
                        <i class="fas fa-skull-crossbones me-2"></i>
                        <strong>Начать процесс удаления аккаунта</strong>
                    </button>

                    <!-- Процесс удаления (скрыт) -->
                    <div id="deletionProcess" class="mt-4" style="display: none;">
                        <div class="deletion-steps">
                            <!-- Шаг 1: Предупреждение -->
                            <div class="step-card mb-3">
                                <div class="step-header">
                                    <i class="fas fa-radiation me-2"></i>
                                    <span>Шаг 1: Подтвердите понимание последствий</span>
                                </div>
                                <div class="step-body">
                                    <ul class="list-unstyled">
                                        <li><i class="fas fa-times text-danger me-2"></i>Все ваши 3D модели будут удалены</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>История операций будет очищена</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Персональные данные будут удалены</li>
                                        <li><i class="fas fa-times text-danger me-2"></i>Восстановление будет невозможно</li>
                                    </ul>
                                    <button type="button" class="btn btn-warning w-100" onclick="showPasswordStep()">
                                        Я понимаю последствия, продолжить
                                    </button>
                                </div>
                            </div>

                            <!-- Шаг 2: Ввод пароля -->
                            <div id="passwordStep" class="step-card" style="display: none;">
                                <div class="step-header">
                                    <i class="fas fa-lock me-2"></i>
                                    <span>Шаг 2: Подтверждение паролем</span>
                                </div>
                                <div class="step-body">
                                    <form method="POST" action="{{ route('profile.destroy') }}" id="deleteForm">
                                        @csrf
                                        @method('DELETE')
                                        
                                        <div class="mb-3">
                                            <label for="deletePassword" class="form-label fw-bold">Введите ваш пароль:</label>
                                            <input type="password" class="form-control form-control-lg" id="deletePassword" 
                                                   name="password" required placeholder="••••••••">
                                            @error('password', 'userDeletion')
                                                <div class="text-danger mt-2">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-danger btn-lg" onclick="finalDeletion()">
                                                <i class="fas fa-skull me-2"></i>УДАЛИТЬ АККАУНТ НАВСЕГДА
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="cancelDeletion()">
                                                Отменить процесс
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function initiateDeletion() {
        document.getElementById('deletionProcess').style.display = 'block';
    }

    function showPasswordStep() {
        document.getElementById('passwordStep').style.display = 'block';
    }

    function cancelDeletion() {
        document.getElementById('deletionProcess').style.display = 'none';
        document.getElementById('passwordStep').style.display = 'none';
        document.getElementById('deletePassword').value = '';
    }

    function finalDeletion() {
        const password = document.getElementById('deletePassword').value;
        
        if (!password) {
            alert('❌ Пожалуйста, введите ваш пароль для подтверждения');
            return;
        }
        
        const confirmation = confirm(
            '🔥 ПОСЛЕДНИЙ ШАНС! 🔥\n\n' +
            'Вы уверены на 100% что хотите удалить аккаунт?\n\n' +
            '✅ Нажмите OK для удаления\n' +
            '❌ Нажмите Отмена для отмены'
        );
        
        if (confirmation) {
            document.getElementById('deleteForm').submit();
        }
    }
    </script>
</body>
</html>