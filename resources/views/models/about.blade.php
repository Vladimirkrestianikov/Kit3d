@extends('layouts.app')



<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KIT3D - О нас</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>
        /* === Основные стили === */
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

    /* Контент с отступами */
    padding: 0 70px;
    min-height: 100vh;
}

/* Центрируем всю страницу для 3D модели */
.color-fonts-section {
    display: grid;
    place-items: center;
    width: 100%;
    height: 85vh;
    background: #fff;
    perspective: 1000px;
    text-align: center;
    cursor: pointer; /* показывает интерактивность */
}

/* === Навигация === */
header {
    background-color: #ffffff;
    box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    position: fixed;
    width: 100%;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
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

.nav-links a:hover,
.nav-links a.active {
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
}

.profile-icon:hover {
    background-color: #FF6B35;
    color: white;
}

/* === Кнопки === */
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

/* === Секции === */
section {
    padding: 100px 40px;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-header h2 {
    font-size: 36px;
    font-weight: 700;
    margin-bottom: 15px;
    color: #333;
}

.section-header p {
    font-size: 18px;
    color: #777;
    max-width: 600px;
    margin: 0 auto;
}

/* === Анимации === */
@keyframes float {
    0% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
    100% { transform: translateY(0) rotate(0deg); }
}

/* === 3D анимация шрифта (СТАРЫЙ эффект) === */
@import url("https://fonts.googleapis.com/css2?family=Nabla:EDPT,EHLT@30..200,24&display=swap");

.color-fonts-section h1 {
    font-size: 8vw;
    font-family: 'Nabla', sans-serif;
    margin: 0;
    color: #FFB380;
    background: linear-gradient(45deg, #FFB380, #FFC099);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow:
        2px 2px 0 #e55a2b,
        4px 4px 0 #cc5428,
        6px 6px 0 #b14421,
        8px 8px 0 #99371a,
        10px 10px 0 #7f2e14;
    transform: rotateX(10deg) rotateY(-5deg);
    transition: text-shadow 0.3s, transform 0.3s, filter 0.3s;
}

/* Hover эффект сияния */
.color-fonts-section:hover h1 {
    text-shadow:
        0 0 10px #FFB380,
        0 0 20px #FFB380,
        0 0 30px #FFB380,
        0 0 40px #FF6B35,
        0 0 50px #FF6B35,
        0 0 60px #FF6B35,
        0 0 70px #FF6B35;
    transform: rotateX(10deg) rotateY(-5deg) scale(1.05);
    filter: brightness(1.2);
}

.color-fonts-section span {
    display: inline-block;
    position: relative;
    animation: depth 1s ease-in-out alternate infinite;
    font-variation-settings: "EDPT" 30;
    color: #FFB380;
    text-shadow:
        2px 2px 0 #e55a2b,
        4px 4px 0 #cc5428,
        6px 6px 0 #b14421,
        8px 8px 0 #99371a,
        10px 10px 0 #7f2e14;
}

.color-fonts-section span:nth-child(1) { animation-delay: 0.1s; }
.color-fonts-section span:nth-child(2) { animation-delay: 0.2s; }
.color-fonts-section span:nth-child(3) { animation-delay: 0.3s; }
.color-fonts-section span:nth-child(4) { animation-delay: 0.4s; }
.color-fonts-section span:nth-child(5) { animation-delay: 0.5s; }
.color-fonts-section span:nth-child(6) { animation-delay: 0.6s; }
.color-fonts-section span:nth-child(7) { animation-delay: 0.7s; }
.color-fonts-section span:nth-child(8) { animation-delay: 0.8s; }
.color-fonts-section span:nth-child(9) { animation-delay: 0.9s; }
.color-fonts-section span:nth-child(10){ animation-delay: 1s; }
.color-fonts-section span:nth-child(11){ animation-delay: 1.1s; }
.color-fonts-section span:nth-child(12){ animation-delay: 1.2s; }

@keyframes depth {
    0% {
        transform: translateX(0) translateY(0) rotateX(0deg) rotateY(0deg);
        font-variation-settings: "EDPT" 30;
    }
    100% {
        transform: translateX(0.2em) translateY(0.2em) rotateX(2deg) rotateY(-2deg);
        font-variation-settings: "EDPT" 200;
    }
}

/* === НОВЫЙ реалистичный 3D эффект (добавлен отдельно) === */

.realistic-3d {
    font-size: 8vw;
    font-family: 'Montserrat', sans-serif;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 8px;

    background: linear-gradient(145deg, #ff925c 0%, #ff6b35 40%, #d64a20 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;

    filter: drop-shadow(6px 6px 0 #b63e1b)
            drop-shadow(12px 12px 0 #8d2f14)
            drop-shadow(18px 18px 0 #631f0d);

    transform: rotateX(18deg) rotateY(-12deg);
    transition: 0.4s ease;
}

.realistic-3d:hover {
    transform: rotateX(10deg) rotateY(-5deg) scale(1.06);
    filter:
        drop-shadow(0 0 15px #ffb18c)
        drop-shadow(0 0 30px #ff6b35)
        drop-shadow(12px 12px 0 #a43a18);
}

.realistic-3d span {
    display: inline-block;
    transition: 0.25s ease;
}

.realistic-3d:hover span {
    transform: translateZ(12px) translateY(-3px);
}

.realistic-3d span:nth-child(odd) {
    transform: translateZ(3px);
}

.realistic-3d span:nth-child(even) {
    transform: translateZ(1px);
}

/* === Адаптивность === */
@media (max-width: 992px) {
    .navbar {
        flex-direction: column;
        gap: 20px;
        padding: 20px;
    }

    .nav-links {
        gap: 15px;
    }

    .nav-links li {
        margin-left: 0;
    }

    .search-box input {
        width: 150px;
    }
}

@media (max-width: 768px) {
    .section-header h2 {
        font-size: 28px;
    }

    .btn {
        padding: 10px 20px;
        font-size: 14px;
    }

    body {
        padding: 0 20px;
    }

    section {
        padding: 80px 20px;
    }
}

        /* === Стили для страницы о нас === */
.about-section {
    padding: 120px 0 60px;
}

/* Герой секция */
.about-hero {
    text-align: center;
    margin-bottom: 80px;
}

.about-content h1 {
    font-size: 48px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #333;
}

.subtitle {
    font-size: 20px;
    color: #FF6B35;
    margin-bottom: 30px;
    font-weight: 600;
}

.about-description {
    max-width: 800px;
    margin: 0 auto;
}

.about-description p {
    font-size: 16px;
    line-height: 1.8;
    color: #555;
    margin-bottom: 20px;
}

/* Миссия */
.mission-section {
    background: #f9f9f9;
    padding: 60px;
    border-radius: 20px;
    margin-bottom: 80px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 50px;
}

.mission-content {
    flex: 1;
}

.mission-content h2 {
    font-size: 32px;
    margin-bottom: 20px;
    color: #333;
}

.mission-content p {
    font-size: 18px;
    line-height: 1.6;
    color: #555;
}

.mission-stats {
    display: flex;
    gap: 40px;
}

.mission-stat {
    text-align: center;
}

.stat-number {
    font-size: 42px;
    font-weight: 700;
    color: #FF6B35;
    margin-bottom: 10px;
}

.stat-label {
    font-size: 16px;
    color: #777;
    font-weight: 600;
}

/* Преимущества */
.features-section {
    margin-bottom: 80px;
}

.features-section h2 {
    text-align: center;
    font-size: 36px;
    margin-bottom: 50px;
    color: #333;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}

.feature-card {
    background: white;
    padding: 40px 30px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    text-align: center;
    transition: transform 0.3s;
}

.feature-card:hover {
    transform: translateY(-10px);
}

.feature-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: #FF6B35;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    color: white;
    font-size: 32px;
}

.feature-card:nth-child(2) .feature-icon {
    background: #4CAF50;
}

.feature-card:nth-child(3) .feature-icon {
    background: #4CAF50;
}

.feature-card:nth-child(4) .feature-icon {
    background: #FF6B35;
}

.feature-card h3 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #333;
}

.feature-card p {
    color: #777;
    line-height: 1.6;
}

/* Наши ценности - ИСПРАВЛЕННАЯ СЕКЦИЯ С ВСЕМИ АНИМАЦИЯМИ */
.values-section {
    margin-bottom: 80px;
    text-align: center;
}

.values-section h2 {
    font-size: 36px;
    margin-bottom: 50px;
    color: #333;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    justify-items: center;
}

/* Стили для карточек с эффектом - ВСЕ АНИМАЦИИ СОХРАНЕНЫ */
.value-card {
    width: 100%;
    max-width: 280px;
    height: 280px; /* Фиксированная высота для всех карточек */
    background-color: white;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 107, 53, 0.1);
    font-size: 16px;
    transition: all 0.4s ease;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    cursor: pointer;
    overflow: hidden;
    padding: 30px 20px;
    margin-bottom: 30px; /* Отступ снизу для компенсации подъема */
}

.value-card .icon {
    margin: 0 auto;
    width: 80px;
    height: 80px;
    background: linear-gradient(90deg, #FF9D7E 0%, #FF6B35 40%, #ffffff 60%);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    color: white;
    transition: all 0.8s ease;
    background-position: 0px;
    background-size: 200px;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.3);
}

.material-icons.md-36 { 
    font-size: 36px;
    transition: all 0.4s ease;
    color: white;
}

.value-card .title {
    width: 100%;
    margin: 0;
    text-align: center;
    margin-top: 25px;
    color: #333;
    font-weight: 600;
    font-size: 18px;
    letter-spacing: 1px;
    transition: all 0.3s ease;
}

.value-card .text {
    width: 85%;
    margin: 0 auto;
    font-size: 14px;
    text-align: center;
    margin-top: 15px;
    color: #666;
    font-weight: 400;
    line-height: 1.5;
    opacity: 0;
    max-height: 0;
    transition: all 0.4s ease;
}

/* ВСЕ ЭФФЕКТЫ ПРИ НАВЕДЕНИИ СОХРАНЕНЫ */
.value-card:hover {
    height: 280px; /* Высота не меняется */
    transform: translateY(-8px); /* Только подъем */
    box-shadow: 0 15px 35px rgba(255, 107, 53, 0.15);
    border-color: rgba(255, 107, 53, 0.3);
}

.value-card:hover .text {
    opacity: 1;
    max-height: 60px;
    margin-top: 20px;
}

.value-card:hover .icon {
    background-position: -120px;
    transition: all 0.6s ease;
}

.value-card:hover .icon i {
    color: #FF6B35;
    transition: all 0.4s ease;
}

.value-card:hover .title {
    color: #FF6B35;
    transform: translateY(-5px);
}

/* НОВАЯ СЕКЦИЯ - КАК СВЯЗАТЬСЯ С ПРОДАВЦОМ - ПРОСТОЙ ДИЗАЙН */
.seller-contact-section {
    background: #f9f9f9;
    padding: 60px;
    border-radius: 20px;
    margin: 80px 0;
}

.seller-contact-content {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.seller-contact-info {
    width: 100%;
}

.seller-contact-info h2 {
    font-size: 32px;
    margin-bottom: 20px;
    color: #333;
    text-align: center;
}

.seller-contact-info > p {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 30px;
    text-align: center;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

/* ИСПРАВЛЕННЫЕ СТИЛИ ДЛЯ СПОСОБОВ СВЯЗИ - БОЛЬШИЕ И РОВНЫЕ КРУГИ */
.contact-methods {
    display: flex;
    justify-content: center;
    gap: 80px;
    margin: 50px 0;
    flex-wrap: wrap;
}

.contact-method {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 20px;
    position: relative;
}

.contact-icon {
    width: 110px; /* Увеличил размер кругов еще больше */
    height: 110px; /* Увеличил размер кругов еще больше */
    border-radius: 50%; /* Гарантирует идеально круглую форму */
    background: #FF6B35;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 35px; /* Увеличил размер иконок еще больше */
    box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
    transition: all 0.3s ease;
    overflow: hidden; /* Гарантирует, что содержимое не выйдет за границы круга */
}

/* Убедимся, что иконки центрированы и не деформируются */
.contact-icon i {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 100%;
}

.contact-icon:hover {
    transform: scale(1.05);
    box-shadow: 0 12px 30px rgba(255, 107, 53, 0.4);
}

.contact-name {
    font-size: 20px; /* Увеличил размер текста еще больше */
    font-weight: 600;
    color: #333;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.contact-link {
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
}

.important-notice {
    background: #fff8f6;
    border: 2px solid #FF6B35;
    border-radius: 15px;
    padding: 25px;
    margin: 30px 0;
    max-width: 800px;
    margin-left: auto;
    margin-right: auto;
}

.important-notice h3 {
    color: #FF6B35;
    font-size: 18px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.important-notice h3 i {
    font-size: 20px;
}

.important-notice p {
    color: #555;
    line-height: 1.6;
    font-size: 14px;
    text-align: center;
}

/* Адаптивность */
@media (max-width: 992px) {
    .mission-section {
        flex-direction: column;
        text-align: center;
    }
    
    .mission-stats {
        justify-content: center;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .values-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .contact-content {
        flex-direction: column;
    }
    
    .contact-methods {
        gap: 50px;
    }
    
    .contact-icon {
        width: 150px;
        height: 150px;
        font-size: 50px;
    }
}

@media (max-width: 768px) {
    .about-content h1 {
        font-size: 36px;
    }
    
    .mission-stats {
        flex-direction: column;
        gap: 20px;
    }
    
    .contact-section {
        padding: 40px 20px;
    }
    
    .seller-contact-section {
        padding: 40px 20px;
    }
    
    .mission-section {
        padding: 40px 20px;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .about-section {
        padding: 100px 0 40px;
    }
    
    .contact-methods {
        gap: 40px;
    }
    
    .contact-icon {
        width: 130px;
        height: 130px;
        font-size: 45px;
    }
}

@media (max-width: 480px) {
    .about-content h1 {
        font-size: 28px;
    }
    
    .subtitle {
        font-size: 18px;
    }
    
    .mission-content h2,
    .features-section h2,
    .values-section h2,
    .contact-info h2,
    .seller-contact-info h2 {
        font-size: 24px;
    }
    
    .feature-card,
    .value-item {
        padding: 30px 20px;
    }
    
    .mission-stat .stat-number {
        font-size: 32px;
    }
    
    .contact-methods {
        flex-direction: column;
        align-items: center;
        gap: 40px;
    }
    
    .contact-icon {
        width: 120px;
        height: 120px;
        font-size: 40px;
    }
}

/* === Ховер на текст KIT / 3D === */
.about-title {
    transition: color 0.3s ease;
}

.kit-span,
.three-d-span {
    transition: color 0.3s ease;
}

.about-title:hover .kit-span {
    color: #FF6B35; /* оранжевый */
}

.about-title:hover .three-d-span {
    color: #4CAF50; /* зеленый */
}
    </style>
</head>
<body>

    <!-- 3D Анимация текста сверху -->
    <section class="color-fonts-section">
        <h1>
            <span>K</span><span>I</span><span>T</span><span>3</span><span>D</span>
            <span>M</span><span>O</span><span>D</span><span>E</span><span>L</span><span>S</span>
        </h1>
    </section>

    <!-- О нас -->
    <main class="about-section">
        <div class="container">
            <div class="about-hero">
                <div class="about-content">
                    <h1 class="about-title">
                        <span class="kit-span">O KIT</span><span class="three-d-span">3D</span>
                    </h1>
                    <p class="subtitle">Пространство для 3D контента.</p>
                    <div class="about-description">
                        <p>KIT3D — платформа для размещения, обмена и демонстрации 3D-моделей, созданная на базе Колледжа Информационных Технологий. Сервис предоставляет возможность публиковать работы, приобретать готовые модели и использовать их в учебных, художественных и рабочих проектах.</p>
                        <p>Платформа формирует пространство для авторов 3D-контента, где каждый может представить свои разработки, развивать навыки и получать практический опыт в сфере цифрового моделирования.</p>
                    </div>
                </div>
            </div>

            <!-- Наша миссия -->
            <section class="mission-section" aria-labelledby="mission-heading">
                <div class="mission-content">
                    <h2 id="mission-heading">Наша миссия</h2>
                    <p>Платформа создана для публикации работ, развития профессиональных навыков и получения практического опыта в области цифрового моделирования.</p>
                </div>
                <div class="mission-stats">
                    <div class="mission-stat">
                        <div class="stat-number">2025</div>
                        <div class="stat-label">Год основания</div>
                    </div>
                    <div class="mission-stat">
                        <div class="stat-number">100%</div>
                        <div class="stat-label">Бесплатно для всех</div>
                    </div>
                    <div class="mission-stat">
                        <div class="stat-number">24/7</div>
                        <div class="stat-label">Работа платформы</div>
                    </div>
                </div>
            </section>

            <!-- Преимущества -->
            <section class="features-section" aria-labelledby="features-heading">
                <h2 id="features-heading">Почему выбирают KIT3D?</h2>
                <div class="features-grid">
                    <article class="feature-card">
                        <div class="feature-icon"><i class="fas fa-graduation-cap" aria-hidden="true"></i></div>
                        <h3>Образовательная платформа</h3>
                        <p>Платформа обеспечивает возможности для изучения 3D-моделирования и выполнения практических задач.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><i class="fas fa-hand-holding-usd" aria-hidden="true"></i></div>
                        <h3>Коммерческая модель</h3>
                        <p>Модели можно выставлять на продажу, получая реальную оценку и коммерческий опыт.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><i class="fas fa-users" aria-hidden="true"></i></div>
                        <h3>Сообщество</h3>
                        <p>Платформа объединяет специалистов и команды, предоставляя пространство для обмена опытом.</p>
                    </article>
                    <article class="feature-card">
                        <div class="feature-icon"><i class="fas fa-rocket" aria-hidden="true"></i></div>
                        <h3>Поддержка</h3>
                        <p>Доступна техническая помощь и инструменты для продвижения моделей на платформе.</p>
                    </article>
                </div>
            </section>

            <!-- Ценности с эффектом карточек - ВСЕ АНИМАЦИИ СОХРАНЕНЫ -->
            <section class="values-section" aria-labelledby="values-heading">
                <h2 id="values-heading">Наши ценности</h2>
                <div class="values-grid">
                    <div class="value-card">
                        <div class="icon"><i class="material-icons md-36">favorite</i></div>
                        <p class="title">Творчество</p>
                        <p class="text">Поддержка новых идей и экспериментов в области 3D-моделирования.</p>
                    </div>
                    <div class="value-card">
                        <div class="icon"><i class="material-icons md-36">verified</i></div>
                        <p class="title">Качество</p>
                        <p class="text">Высокий стандарт моделей и аккуратное исполнение каждой работы.</p>
                    </div>
                    <div class="value-card">
                        <div class="icon"><i class="material-icons md-36">groups</i></div>
                        <p class="title">Сообщество</p>
                        <p class="text">Прозрачное и профессиональное взаимодействие внутри платформы.</p>
                    </div>
                </div>
            </section>

            <!-- Связь с продавцом - ПРОСТОЙ ДИЗАЙН С БОЛЬШИМИ КРУГАМИ -->
<section class="seller-contact-section" aria-labelledby="seller-contact-heading">
    <div class="seller-contact-content">
        <div class="seller-contact-info">
            <h2 id="seller-contact-heading">Как связаться с продавцом</h2>
            
            <p>Выберите удобный способ связи:</p>

            <div class="contact-methods">
                <!-- Gmail -->
                <a href="https://mail.google.com/mail/?view=cm&to=standoff2moh@gmail.com" 
                   class="contact-method" target="_blank" style="outline:none; text-decoration:none; color:inherit;">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="contact-name">Gmail</div>
                </a>
                
                <!-- Telegram -->
                <a href="https://t.me/Vovachka_78" 
                   class="contact-method" target="_blank" style="outline:none; text-decoration:none; color:inherit;">
                    <div class="contact-icon">
                        <i class="fab fa-telegram"></i>
                    </div>
                    <div class="contact-name">Telegram</div>
                </a>
                
                <!-- Phone -->
                <a href="tel:87058065707" 
                   class="contact-method" style="outline:none; text-decoration:none; color:inherit;">
                    <div class="contact-icon">
                       <i class="fas fa-phone"></i>
                    </div>
                    <div class="contact-name">Phone</div>
                </a>
            </div>

            <div class="important-notice">
                <h3><i class="fas fa-exclamation-circle"></i> Важная информация</h3>
                <p>На платформе KIT3D каждый автор моделей предоставляет свои контакты для связи. Перед тем как написать продавцу, ознакомьтесь с описанием 3D модели.</p>
            </div>
        </div>
    </div>
</section>


        </div>
    </main>
</body>
</html>
