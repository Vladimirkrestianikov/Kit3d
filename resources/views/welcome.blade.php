<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Kit3d</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!-- Styles -->
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Instrument Sans', sans-serif;
                background: linear-gradient(135deg, #ff6b35 0%, #00b4a0 50%, #ff6b35 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
            }

            .kit3d-container {
                background: rgba(255, 255, 255, 0.95);
                border-radius: 20px;
                padding: 40px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
                text-align: center;
                max-width: 400px;
                width: 100%;
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .logo {
                font-size: 3rem;
                font-weight: 700;
                background: linear-gradient(135deg, #ff6b35, #00b4a0);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 10px;
            }

            .tagline {
                color: #666;
                margin-bottom: 30px;
                font-size: 1.1rem;
            }

            .btn-group {
                display: flex;
                flex-direction: column;
                gap: 15px;
                margin-bottom: 30px;
            }

            .btn {
                padding: 15px 30px;
                border: none;
                border-radius: 12px;
                font-size: 1rem;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
                text-decoration: none;
                display: block;
            }

            .btn-login {
                background: #ff6b35;
                color: white;
            }

            .btn-login:hover {
                background: #e55a2b;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3);
            }

            .btn-register {
                background: #00b4a0;
                color: white;
            }

            .btn-register:hover {
                background: #009c8a;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(0, 180, 160, 0.3);
            }

            .btn-dashboard {
                background: #6c5ce7;
                color: white;
            }

            .btn-dashboard:hover {
                background: #5b4cd1;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(108, 92, 231, 0.3);
            }

            .btn-logout {
                background: #e17055;
                color: white;
                margin-top: 15px;
            }

            .btn-logout:hover {
                background: #d63031;
                transform: translateY(-2px);
                box-shadow: 0 10px 20px rgba(231, 112, 85, 0.3);
            }

            .user-info {
                background: rgba(0, 180, 160, 0.1);
                padding: 15px;
                border-radius: 10px;
                margin-bottom: 20px;
                border: 1px solid rgba(0, 180, 160, 0.2);
            }

            .welcome-text {
                color: #333;
                font-size: 1.2rem;
                margin-bottom: 10px;
            }

            .user-email {
                color: #666;
                font-size: 0.9rem;
            }

            .features {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
                margin-top: 20px;
            }

            .feature {
                padding: 15px;
                background: rgba(255, 107, 53, 0.1);
                border-radius: 10px;
                border: 1px solid rgba(255, 107, 53, 0.2);
            }

            .feature:nth-child(even) {
                background: rgba(0, 180, 160, 0.1);
                border: 1px solid rgba(0, 180, 160, 0.2);
            }

            .feature-icon {
                font-size: 1.5rem;
                margin-bottom: 8px;
            }

            .feature-text {
                font-size: 0.9rem;
                color: #333;
                font-weight: 500;
            }

            @media (max-width: 480px) {
                .kit3d-container {
                    padding: 30px 20px;
                }
                
                .logo {
                    font-size: 2.5rem;
                }
                
                .btn {
                    padding: 12px 25px;
                }
            }
        </style>
    </head>
    <body>
        @auth
            <!-- Страница для авторизованных пользователей -->
            <div class="kit3d-container">
                <div class="logo">Kit3d</div>
                <p class="tagline">Добро пожаловать в Магазин <br>3d Моделей </p>
                
                <div class="user-info">
                    <div class="welcome-text">Привет, {{ Auth::user()->name }}!</div>
                    
                </div>

                <div class="btn-group">
                    <a href="{{ route('models.all') }}" class="btn btn-dashboard">Перейти в магазин</a>
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-logout" style="width: 100%;">Выйти </button>
                    </form>
                </div>

                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">🎨</div>
                        <div class="feature-text">Развлечения</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">⚡</div>
                        <div class="feature-text">Реклама и дизайн</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🔧</div>
                        <div class="feature-text">Образование</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🚀</div>
                        <div class="feature-text">Промышленность и инженерия</div>
                    </div>
                </div>
            </div>
        @else
            <!-- Стандартная страница для неавторизованных пользователей -->
            <div class="kit3d-container">
                <div class="logo">Kit3d</div>
                <p class="tagline">Крупная платформа для продажи 3d моделей</p>
                
                <div class="btn-group">
                    <a href="{{ route('login') }}" class="btn btn-login">Войти</a>
                    <a href="{{ route('register') }}" class="btn btn-register">Зарегистрироваться</a>
                </div>

                <div class="features">
                    <div class="feature">
                        <div class="feature-icon">🎨</div>
                        <div class="feature-text">Развлечения</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">⚡</div>
                        <div class="feature-text">Реклама и дизайн</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🔧</div>
                        <div class="feature-text">Образование</div>
                    </div>
                    <div class="feature">
                        <div class="feature-icon">🚀</div>
                        <div class="feature-text">Промышленность и инженерия</div>
                    </div>
                </div>
            </div>
        @endauth
    </body>
</html>