<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KIT3D Models')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome для иконок -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Основные стили */
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
            position: relative;
        }

        .logo h2 {
            font-weight: 700;
            font-size: 28px;
        }

        .kit {
            color: #FF6B35; /* оранжевый */
        }

        .three-d {
            color: #4CAF50; /* зеленый */
        }

        /* Гамбургер меню для мобильных */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            background: none;
            border: none;
            padding: 5px;
            z-index: 1001;
        }

        .hamburger span {
            display: block;
            width: 25px;
            height: 3px;
            background-color: #333;
            margin: 4px 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 6px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -8px);
        }

        /* Основное меню */
        .nav-menu {
            display: flex;
            align-items: center;
            list-style: none;
            margin-bottom: 0;
        }

        .nav-menu li {
            margin-left: 30px;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
            display: inline-block;
            padding: 5px 0;
        }

        .nav-menu a:hover, .nav-menu a.active {
            color: #FF6B35;
        }

        .nav-menu a.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #FF6B35;
        }

        /* Мобильное меню */
        .mobile-menu {
            position: fixed;
            top: 0;
            right: -100%;
            width: 300px;
            height: 100vh;
            background-color: white;
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            padding: 80px 30px 30px;
            transition: right 0.4s ease;
            z-index: 999;
            overflow-y: auto;
        }

        .mobile-menu.active {
            right: 0;
        }

        .mobile-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-menu li {
            margin-bottom: 20px;
            opacity: 0;
            transform: translateX(20px);
            transition: all 0.3s ease;
        }

        .mobile-menu.active li {
            opacity: 1;
            transform: translateX(0);
        }

        .mobile-menu li:nth-child(1) { transition-delay: 0.1s; }
        .mobile-menu li:nth-child(2) { transition-delay: 0.15s; }
        .mobile-menu li:nth-child(3) { transition-delay: 0.2s; }
        .mobile-menu li:nth-child(4) { transition-delay: 0.25s; }
        .mobile-menu li:nth-child(5) { transition-delay: 0.3s; }

        .mobile-menu a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            font-weight: 500;
            display: block;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            transition: color 0.3s;
        }

        .mobile-menu a:hover, .mobile-menu a.active {
            color: #FF6B35;
        }

        .mobile-actions {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .mobile-actions .btn {
            width: 100%;
            text-align: center;
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

        /* Оверлей для мобильного меню */
        .menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 998;
        }

        .menu-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Кнопки */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
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
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(255, 107, 53, 0.3);
        }

        .btn-secondary {
            background-color: #4CAF50;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #3d8b40;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(76, 175, 80, 0.3);
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

        /* Стиль для кнопки админки */
        .btn-admin {
            background-color:  #4CAF50;
            color: white;
            margin-right: 10px;
        }

        .btn-admin:hover {
            background-color: #FF6B35;;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(156, 39, 176, 0.3);
        }

        .btn-admin1 {
            background-color: #FF6B35 ;
            color: white;
            margin-right: 10px;
        }

        .btn-admin1:hover {
            background-color:  #4CAF50;;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(156, 39, 176, 0.3);
        }

        /* Основной контент */
        main {
            margin-top: 100px;
            padding: 20px 0;
        }

        /* Адаптивность */
        @media (max-width: 992px) {
            .nav-menu {
                display: none;
            }
            
            .hamburger {
                display: flex;
                order: 2;
            }
            
            .nav-actions {
                order: 3;
            }
            
            .logo {
                order: 1;
            }
            
            .search-box {
                display: none;
            }
            
            .mobile-search {
                display: block;
                margin-bottom: 20px;
            }
            
            .mobile-search input {
                width: 100%;
                padding: 12px 15px;
                border: 1px solid #e0e0e0;
                border-radius: 30px;
                font-size: 16px;
            }
            
            main {
                margin-top: 100px;
            }
        }

        @media (max-width: 768px) {
            .nav-actions .btn-admin,
            .nav-actions .btn-outline,
            .nav-actions .btn-primary {
                display: none;
            }
            
            .mobile-actions .btn-admin,
            .mobile-actions .btn-outline,
            .mobile-actions .btn-primary {
                display: block;
            }
            
            .mobile-menu {
                width: 100%;
                max-width: 300px;
            }
        }

        @media (max-width: 576px) {
            .logo h2 {
                font-size: 24px;
            }
            
            .mobile-menu {
                padding: 70px 20px 20px;
            }
            
            .mobile-menu a {
                font-size: 16px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <h2><a href="{{ url('/') }}" style="text-decoration: none;"><span class="kit">KIT</span><span class="three-d">3D</span></a></h2>
                </div>
                
                <!-- Кнопка гамбургера для мобильных -->
                <button class="hamburger" id="hamburger" aria-label="Меню">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                
                <!-- Основное меню для десктопа -->
                <ul class="nav-menu">
                    <li><a href="{{ url('/allmodels') }}" class="{{ request()->is('allmodels') || request()->is('/') ? 'active' : '' }}">AllModels</a></li>
                    <li><a href="{{ url('/models') }}" class="{{ request()->is('models') ? 'active' : '' }}">My Models</a></li>
                    <!-- <li><a href="{{ url('/create3d') }}" class="{{ request()->is('create3d') ? 'active' : '' }}">Create3d</a></li> -->
                    <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About Us</a></li>
                    <li><a href="{{ url('/convertor') }}" class="{{ request()->is('convertor') ? 'active' : '' }}">Convertor</a></li>

                </ul>
                
                <div class="nav-actions">
                    @auth
                        <!-- Кнопка админки - показывается только админам -->
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-admin">
                                <i class="fas fa-cog"></i> Admin panel
                            </a>
                        @endif

                        <div class="dropdown">
                            <button class="profile-icon dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Профиль пользователя">
                                <i class="fas fa-user" aria-hidden="true"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li>
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item" style="display: block; padding: 0.5rem 1rem; color: #333; text-decoration: none; transition: background-color 0.3s ease; border: none; background: none; width: 100%; text-align: left; cursor: pointer;">
                                        <span>Профиль {{ Auth::user()->name }}</span>
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                      <form method="POST" action="{{ route('logout') }}">
                                         @csrf
                                        <button type="submit" class="dropdown-item">Выйти</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline ms-2">Войти</a>
                        <a href="{{ route('register') }}" class="btn btn-primary ms-2">Регистрация</a>
                    @endauth
                </div>
            </nav>
        </div>
        
        <!-- Мобильное меню -->
        <div class="mobile-menu" id="mobileMenu">
            <!-- Поиск в мобильном меню -->
            <div class="mobile-search">
               
            </div>
            
            <!-- Навигация -->
            <ul>
                <li><a href="{{ url('/allmodels') }}" class="{{ request()->is('allmodels') || request()->is('/') ? 'active' : '' }}">AllModels</a></li>
                <li><a href="{{ url('/models') }}" class="{{ request()->is('models') ? 'active' : '' }}">My Models</a></li>
                <!-- <li><a href="{{ url('/create3d') }}" class="{{ request()->is('create3d') ? 'active' : '' }}">Create3d</a></li> -->
                <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About Us</a></li>
            </ul>
            
            <!-- Кнопки авторизации для мобильных -->
            <div class="mobile-actions">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-admin">
                            <i class="fas fa-cog"></i> Админка
                        </a>
                    @endif
                    
                    <!-- <a href="{{ route('profile.edit') }}" class="btn btn-outline">
                        <i class="fas fa-user"></i> Профиль
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-sign-out-alt"></i> Выйти
                        </button>
                    </form> -->
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Войти</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Регистрация</a>
                @endauth
            </div>
        </div>
        
        <!-- Оверлей для мобильного меню -->
        <div class="menu-overlay" id="menuOverlay"></div>
    </header>

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

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Мобильное меню
        document.addEventListener('DOMContentLoaded', function() {
            const hamburger = document.getElementById('hamburger');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuOverlay = document.getElementById('menuOverlay');
            
            // Открытие/закрытие мобильного меню
            hamburger.addEventListener('click', function() {
                this.classList.toggle('active');
                mobileMenu.classList.toggle('active');
                menuOverlay.classList.toggle('active');
                document.body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : '';
            });
            
            // Закрытие меню по клику на оверлей
            menuOverlay.addEventListener('click', function() {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
                this.classList.remove('active');
                document.body.style.overflow = '';
            });
            
            // Закрытие меню по клику на ссылку (опционально)
            const mobileLinks = document.querySelectorAll('.mobile-menu a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    hamburger.classList.remove('active');
                    mobileMenu.classList.remove('active');
                    menuOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                });
            });
            
            // Адаптация размера основного контента
            function updateMainMargin() {
                const headerHeight = document.querySelector('header').offsetHeight;
                document.querySelector('main').style.marginTop = headerHeight + 'px';
            }
            
            // Обновляем при загрузке и изменении размера окна
            window.addEventListener('load', updateMainMargin);
            window.addEventListener('resize', updateMainMargin);
        });
    </script>
    
    <!-- Model Viewer для 3D моделей -->
    <script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
    
    @stack('scripts')
</body>
</html>