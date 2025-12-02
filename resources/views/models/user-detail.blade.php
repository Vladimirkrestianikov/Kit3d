@extends('layouts.app')

@section('title', $user->name . ' - Детали пользователя')

@section('content')
<div class="container">
    <!-- Заголовок -->
    <div class="models-header">
        <div class="header-left">
            <h1 class="page-title">{{ $user->name }}</h1>
            <div class="breadcrumb-nav">
                <a href="{{ route('admin.dashboard') }}" class="breadcrumb-link">Админ-панель</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('admin.users') }}" class="breadcrumb-link">Пользователи</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">Детали</span>
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('admin.users') }}" class="btn btn-back">
                ← Назад
            </a>
        </div>
    </div>

    <!-- Поиск и фильтры моделей -->
    <div class="filters-section">
        <div class="filters-row">
            <!-- Строка поиска -->
            <div class="search-container">
                <div class="search-input-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" 
                           id="modelSearch" 
                           placeholder="Поиск моделей по названию..."
                           class="search-input"
                           onkeyup="handleSearchInput()">
                    <button class="clear-search-btn" id="clearSearch" onclick="clearSearch()" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <!-- Фильтр по категории в том же стиле -->
            <div class="filter-container">
                <div class="filter-wrapper">
                    <i class="fas fa-tags filter-icon"></i>
                    <select id="categoryFilter" class="filter-select" onchange="applyFilters()">
                        <option value="all">Все категории</option>
                        <option value="architecture">Архитектура</option>
                        <option value="design">Дизайн</option>
                        <option value="science">Наука</option>
                        <option value="entertainment">Развлечения</option>
                        <option value="other">Другое</option>
                    </select>
                </div>
            </div>

            <!-- Сортировка -->
            <div class="filter-container">
                <div class="filter-wrapper">
                    <i class="fas fa-sort-amount-down sort-icon"></i>
                    <select id="sortFilter" class="filter-select" onchange="applyFilters()">
                        <option value="newest">Сначала новые</option>
                        <option value="oldest">Сначала старые</option>
                        <option value="price_desc">Цена по убыванию</option>
                        <option value="price_asc">Цена по возрастанию</option>
                        <option value="name_asc">Название А-Я</option>
                        <option value="name_desc">Название Я-А</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Счетчик результатов -->
        <div class="filters-info">
            <div class="results-counter" id="resultsCounter">
                Найдено: <span>{{ $user->models->count() }}</span> моделей
            </div>
            <button class="btn-reset-all" onclick="resetAllFilters()">
                <i class="fas fa-redo"></i>
                Сбросить все
            </button>
        </div>
    </div>

    <div class="models-layout">
        <!-- Левая панель - Информация о пользователе -->
        <div class="user-sidebar">
            <div class="sidebar-header">
                <h3><i class="fas fa-user-circle"></i> Информация</h3>
            </div>

            <!-- Основная информация -->
            <div class="sidebar-section">
                <div class="user-avatar-large">
                    <i class="fas fa-user"></i>
                </div>
                
                <div class="user-info-list">
                    <div class="info-item">
                        <span class="info-label">ID:</span>
                        <span class="info-value">#{{ $user->id }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Имя:</span>
                        <span class="info-value">{{ $user->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Роль:</span>
                        <span class="info-value role-badge @if($user->is_admin) role-admin @else role-user @endif">
                            @if($user->is_admin)
                                <i class="fas fa-crown"></i> Админ
                            @else
                                <i class="fas fa-user"></i> Пользователь
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Статистика -->
            <div class="sidebar-section">
                <h4 class="section-title-small">Статистика</h4>
                <div class="user-stats-grid">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">{{ $user->models->count() }}</div>
                            <div class="stat-label">Моделей</div>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-info">
                            <div class="stat-number">${{ number_format($user->models->sum('price'), 2) }}</div>
                            <div class="stat-label">Сумма</div>
                        </div>
                    </div>
                </div>
                
                @if($user->models->count() > 0)
                <div class="price-range-info">
                    <div class="price-range-item">
                        <span class="range-label">Мин:</span>
                        <span class="range-value">${{ number_format($user->models->min('price'), 2) }}</span>
                    </div>
                    <div class="price-range-item">
                        <span class="range-label">Макс:</span>
                        <span class="range-value">${{ number_format($user->models->max('price'), 2) }}</span>
                    </div>
                    <div class="price-range-item">
                        <span class="range-label">Средняя:</span>
                        <span class="range-value">${{ number_format($user->models->avg('price'), 2) }}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Даты -->
            <div class="sidebar-section">
                <h4 class="section-title-small">Даты</h4>
                <div class="date-info">
                    <div class="date-item">
                        <i class="far fa-calendar-plus"></i>
                        <div class="date-details">
                            <span class="date-label">Зарегистрирован:</span>
                            <span class="date-value">{{ $user->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                    <div class="date-item">
                        <i class="far fa-calendar-check"></i>
                        <div class="date-details">
                            <span class="date-label">Обновлен:</span>
                            <span class="date-value">{{ $user->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Управление ролью -->
            @if($user->id !== auth()->id())
            <div class="sidebar-section">
                <h4 class="section-title-small">Управление ролью</h4>
                <div class="role-management">
                    @if(!$user->is_admin)
                        <form action="{{ route('admin.make') }}" method="POST" class="role-form">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-role btn-make-admin">
                                <i class="fas fa-plus-circle"></i> Сделать админом
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.remove', $user->id) }}" method="POST" class="role-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-role btn-remove-admin">
                                <i class="fas fa-minus-circle"></i> Убрать админа
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Основной контент -->
        <div class="user-content">
            <!-- Список моделей -->
            <div class="models-section">
                <div class="section-header">
                    <h3 class="section-title">Модели пользователя</h3>
                </div>
                
                @if($user->models->count() > 0)
                    <div id="modelsContainer">
                        <div id="modelsList" class="models-list">
                            @foreach($user->models->sortByDesc('created_at') as $model)
                            <div class="model-list-item" 
                                 data-name="{{ strtolower($model->name) }}"
                                 data-category="{{ $model->category }}"
                                 data-price="{{ $model->price }}"
                                 data-date="{{ $model->created_at->timestamp }}"
                                 data-created="{{ $model->created_at->format('Y-m-d') }}">
                                <div class="model-list-image">
                                    <img src="{{ Storage::url($model->image_path) }}" 
                                         alt="{{ $model->name }}"
                                         class="model-list-preview"
                                         onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">
                                </div>
                                
                                <div class="model-list-info">
                                    <div class="model-list-header">
                                        <h4 class="model-list-title">{{ $model->name }}</h4>
                                        <span class="model-list-price">${{ number_format($model->price, 2) }}</span>
                                    </div>
                                    
                                    <div class="model-list-meta">
                                        <span class="model-list-category category-{{ $model->category }}">
                                            @switch($model->category)
                                                @case('architecture')
                                                    <i class="fas fa-building"></i>
                                                    @break
                                                @case('design')
                                                    <i class="fas fa-palette"></i>
                                                    @break
                                                @case('science')
                                                    <i class="fas fa-flask"></i>
                                                    @break
                                                @case('entertainment')
                                                    <i class="fas fa-gamepad"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-cube"></i>
                                            @endswitch
                                            {{ ucfirst($model->category) }}
                                        </span>
                                        <span class="model-list-date">
                                            <i class="far fa-calendar"></i>
                                            {{ $model->created_at->format('d.m.Y') }}
                                        </span>
                                    </div>
                                    
                                    <p class="model-list-description">{{ Str::limit($model->description, 120) }}</p>
                                    
                                    <div class="model-list-actions">
                                        <a href="{{ route('models.all.show', $model->slug) }}" 
                                           class="btn btn-action btn-view" target="_blank">
                                            <i class="fas fa-eye"></i>
                                            Просмотр
                                        </a>
                                        <a href="{{ route('models.edit', $model->slug) }}" 
                                           class="btn btn-action btn-edit">
                                            <i class="fas fa-edit"></i>
                                            Редактировать
                                        </a>
                                        <form action="{{ route('models.destroy', $model->slug) }}" method="POST" class="action-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-action btn-delete"
                                                    onclick="return confirm('Удалить модель \"{{ $model->name }}\"?')">
                                                <i class="fas fa-trash"></i>
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Сообщение "ничего не найдено" -->
                    <div id="noResultsMessage" class="no-results" style="display: none;">
                        <div class="no-results-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h4>Модели не найдены</h4>
                        <p>Попробуйте изменить параметры поиска или фильтры</p>
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <h3 class="empty-title">Нет моделей</h3>
                        <p class="empty-description">
                            У пользователя пока нет 3D моделей
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Основные стили */
.models-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    gap: 30px;
}

.header-left {
    flex: 1;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
    background: linear-gradient(135deg, #FF6B35 0%, #FFA726 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.breadcrumb-nav {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #666;
}

.breadcrumb-link {
    color: #FF6B35;
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb-link:hover {
    color: #e55a2b;
    text-decoration: underline;
}

.breadcrumb-separator {
    color: #999;
}

.breadcrumb-current {
    color: #333;
    font-weight: 500;
}

.btn-back {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 15px 25px;
    font-weight: 600;
    white-space: nowrap;
    border-radius: 12px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #333;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-back:hover {
    background: #e9ecef;
    color: #333;
}

/* Секция фильтров и поиска */
.filters-section {
    background: white;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    margin-bottom: 30px;
    border: 1px solid #f0f0f0;
}

.filters-row {
    display: flex;
    gap: 20px;
    align-items: center;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

/* Строка поиска */
.search-container {
    flex: 1;
    min-width: 300px;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 15px;
    color: #999;
    font-size: 1rem;
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 14px 45px 14px 45px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s;
    background: white;
    outline: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.search-input:focus {
    border-color: #FF6B35;
    box-shadow: 0 5px 20px rgba(255, 107, 53, 0.15);
    background: #fffaf7;
}

.clear-search-btn {
    position: absolute;
    right: 15px;
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    padding: 5px;
    font-size: 0.9rem;
    transition: color 0.3s;
    z-index: 2;
}

.clear-search-btn:hover {
    color: #FF6B35;
}

/* Контейнеры для фильтров */
.filter-container {
    min-width: 220px;
}

.filter-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.filter-icon, .sort-icon {
    position: absolute;
    left: 15px;
    color: #999;
    font-size: 1rem;
    z-index: 2;
}

.filter-select {
    width: 100%;
    padding: 14px 45px 14px 45px;
    border: 2px solid #e0e0e0;
    border-radius: 12px;
    font-size: 1rem;
    color: #333;
    cursor: pointer;
    transition: all 0.3s;
    background: white;
    outline: none;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23999' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 16px;
    padding-right: 40px;
}

.filter-select:hover, .filter-select:focus {
    border-color: #FF6B35;
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.1);
}

/* Инфо и кнопка сброса */
.filters-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.results-counter {
    font-size: 0.95rem;
    color: #666;
}

.results-counter span {
    font-weight: 700;
    color: #FF6B35;
}

.btn-reset-all {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #666;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    gap: 8px;
}

.btn-reset-all:hover {
    background: #e9ecef;
    color: #333;
}

/* Layout */
.models-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 30px;
    align-items: start;
    min-height: calc(100vh - 200px);
}

/* Левая панель */
.user-sidebar {
    background: white;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
    height: fit-content;
    max-height: calc(100vh - 120px);
    overflow-y: auto;
}

.user-sidebar::-webkit-scrollbar {
    width: 6px;
}

.user-sidebar::-webkit-scrollbar-track {
    background: #f0f0f0;
    border-radius: 3px;
}

.user-sidebar::-webkit-scrollbar-thumb {
    background: #FF6B35;
    border-radius: 3px;
}

.user-sidebar::-webkit-scrollbar-thumb:hover {
    background: #e55a2b;
}

.sidebar-header {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.sidebar-header h3 {
    margin: 0;
    color: #333;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar-section {
    margin-bottom: 25px;
}

.section-title-small {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

/* Аватар пользователя */
.user-avatar-large {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #FF6B35 0%, #FFA726 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2.5rem;
    color: white;
}

.user-info-list {
    margin-bottom: 20px;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #666;
    font-size: 0.9rem;
}

.info-value {
    color: #333;
    font-weight: 500;
    text-align: right;
    max-width: 60%;
    word-break: break-word;
}

.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
}

.role-admin {
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
    border: 1px solid rgba(255, 107, 53, 0.3);
}

.role-user {
    background: rgba(72, 187, 120, 0.1);
    color: #48bb78;
    border: 1px solid rgba(72, 187, 120, 0.3);
}

.user-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 20px;
}

.stat-item {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.stat-icon {
    width: 35px;
    height: 35px;
    background: rgba(255, 107, 53, 0.1);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FF6B35;
    font-size: 1rem;
    flex-shrink: 0;
}

.stat-info {
    flex: 1;
    min-width: 0;
}

.stat-number {
    font-size: 1.2rem;
    font-weight: 700;
    color: #333;
    line-height: 1;
    margin-bottom: 2px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.stat-label {
    font-size: 0.75rem;
    color: #666;
}

.price-range-info {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px;
}

.price-range-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 0;
    font-size: 0.9rem;
}

.range-label {
    color: #666;
}

.range-value {
    font-weight: 600;
    color: #333;
}

.date-info {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 15px;
}

.date-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 8px 0;
    border-bottom: 1px solid #e9ecef;
}

.date-item:last-child {
    border-bottom: none;
}

.date-details {
    flex: 1;
    min-width: 0;
}

.date-label {
    font-size: 0.8rem;
    color: #666;
    display: block;
    margin-bottom: 2px;
}

.date-value {
    font-weight: 500;
    color: #333;
    font-size: 0.9rem;
    word-break: break-word;
}

.role-management {
    margin-top: 10px;
}

.role-form {
    margin: 0;
}

.btn-role {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    font-size: 0.9rem;
}

.btn-make-admin {
    background: rgba(72, 187, 120, 0.1);
    color: #48bb78;
    border: 1px solid rgba(72, 187, 120, 0.3);
}

.btn-make-admin:hover {
    background: #48bb78;
    color: white;
}

.btn-remove-admin {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.btn-remove-admin:hover {
    background: #ef4444;
    color: white;
}

/* Основной контент */
.user-content {
    min-height: 600px;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 20px;
}

/* Список моделей */
.models-section {
    margin-top: 30px;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
    flex-wrap: wrap;
    gap: 15px;
}

.models-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.model-list-item {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border: 1px solid #f0f0f0;
    display: flex;
    gap: 20px;
    transition: all 0.3s ease;
}

.model-list-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}

.model-list-image {
    width: 150px;
    height: 150px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}

.model-list-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.model-list-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.model-list-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 10px;
    gap: 10px;
}

.model-list-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin: 0;
    flex: 1;
    word-break: break-word;
}

.model-list-price {
    background: #FF6B35;
    color: white;
    padding: 4px 12px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9rem;
    flex-shrink: 0;
}

.model-list-meta {
    display: flex;
    gap: 15px;
    margin-bottom: 10px;
    flex-wrap: wrap;
}

.model-list-category {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    background: #f8f9fa;
    color: #666;
    flex-shrink: 0;
}

.model-list-date {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: #888;
    font-size: 0.8rem;
}

.model-list-description {
    color: #666;
    line-height: 1.5;
    font-size: 0.9rem;
    margin-bottom: 15px;
    flex: 1;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.model-list-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-action {
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.btn-view {
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
}

.btn-view:hover {
    background: #FF6B35;
    color: white;
}

.btn-edit {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.btn-edit:hover {
    background: #f59e0b;
    color: white;
}

.btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.btn-delete:hover {
    background: #ef4444;
    color: white;
}

.action-form {
    margin: 0;
}

/* Сообщение "ничего не найдено" */
.no-results {
    text-align: center;
    padding: 60px 20px;
    background: #f8f9fa;
    border-radius: 15px;
    margin-top: 20px;
    border: 2px dashed #dee2e6;
}

.no-results-icon {
    font-size: 3rem;
    color: #FF6B35;
    margin-bottom: 20px;
    opacity: 0.7;
}

.no-results h4 {
    font-size: 1.3rem;
    color: #333;
    margin-bottom: 10px;
}

.no-results p {
    color: #666;
    font-size: 0.95rem;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    max-width: 500px;
    margin: 50px auto;
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
}

.empty-icon {
    font-size: 4rem;
    color: #FF6B35;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-title {
    font-size: 1.5rem;
    color: #333;
    margin-bottom: 10px;
}

.empty-description {
    color: #666;
    margin-bottom: 30px;
}

/* Адаптивность */
@media (max-width: 768px) {
    .models-header {
        flex-direction: column;
        align-items: stretch;
        gap: 20px;
    }
    
    .header-left, .header-right {
        width: 100%;
    }
    
    .page-title {
        font-size: 2rem;
        text-align: center;
    }
    
    .filters-row {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-container,
    .filter-container {
        min-width: 100%;
        width: 100%;
    }
    
    .models-layout {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .user-sidebar {
        position: static;
        max-height: none;
        order: 2;
    }
    
    .user-content {
        order: 1;
    }
    
    .model-list-item {
        flex-direction: column;
    }
    
    .model-list-image {
        width: 100%;
        height: 200px;
    }
    
    .filters-info {
        flex-direction: column;
        gap: 15px;
        align-items: stretch;
    }
    
    .btn-reset-all {
        width: 100%;
        justify-content: center;
    }
    
    .results-counter {
        text-align: center;
    }
}

@media (max-width: 1200px) and (min-width: 769px) {
    .models-layout {
        grid-template-columns: 300px 1fr;
    }
    
    .user-sidebar {
        width: 300px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация переменных
    window.allModels = Array.from(document.querySelectorAll('.model-list-item'));
    window.currentModels = [...window.allModels];
    
    // Отслеживание ввода в поиске
    const searchInput = document.getElementById('modelSearch');
    const clearSearchBtn = document.getElementById('clearSearch');
    
    searchInput.addEventListener('input', function() {
        clearSearchBtn.style.display = this.value ? 'block' : 'none';
        handleSearchInput();
    });
});

// Функция для обработки поиска с дебаунсом
let searchTimeout;
function handleSearchInput() {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        applyFilters();
    }, 300);
}

// Основная функция фильтрации
function applyFilters() {
    const searchTerm = document.getElementById('modelSearch').value.toLowerCase().trim();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const sortFilter = document.getElementById('sortFilter').value;
    
    // Фильтрация
    let filteredModels = window.allModels.filter(item => {
        const modelName = item.getAttribute('data-name') || 
                         item.querySelector('.model-list-title').textContent.toLowerCase();
        const modelCategory = item.getAttribute('data-category');
        
        let matchesSearch = true;
        let matchesCategory = true;
        
        // Проверка поиска
        if (searchTerm && !modelName.includes(searchTerm)) {
            matchesSearch = false;
        }
        
        // Проверка категории
        if (categoryFilter !== 'all' && modelCategory !== categoryFilter) {
            matchesCategory = false;
        }
        
        return matchesSearch && matchesCategory;
    });
    
    // Сортировка
    filteredModels.sort((a, b) => {
        const aName = a.querySelector('.model-list-title').textContent.toLowerCase();
        const bName = b.querySelector('.model-list-title').textContent.toLowerCase();
        const aPrice = parseFloat(a.getAttribute('data-price')) || 
                      parseFloat(a.querySelector('.model-list-price').textContent.replace(/[^0-9.-]+/g, ""));
        const bPrice = parseFloat(b.getAttribute('data-price')) || 
                      parseFloat(b.querySelector('.model-list-price').textContent.replace(/[^0-9.-]+/g, ""));
        const aDate = parseInt(a.getAttribute('data-date')) || 
                     new Date(a.getAttribute('data-created')).getTime();
        const bDate = parseInt(b.getAttribute('data-date')) || 
                     new Date(b.getAttribute('data-created')).getTime();
        
        switch (sortFilter) {
            case 'newest':
                return bDate - aDate;
            case 'oldest':
                return aDate - bDate;
            case 'price_desc':
                return bPrice - aPrice;
            case 'price_asc':
                return aPrice - bPrice;
            case 'name_asc':
                return aName.localeCompare(bName);
            case 'name_desc':
                return bName.localeCompare(aName);
            default:
                return 0;
        }
    });
    
    // Обновление отображения
    updateModelsDisplay(filteredModels);
    
    // Обновление счетчика
    updateResultsCounter(filteredModels.length);
}

// Обновление отображения моделей
function updateModelsDisplay(models) {
    const modelsList = document.getElementById('modelsList');
    const noResultsMessage = document.getElementById('noResultsMessage');
    
    // Очищаем список
    modelsList.innerHTML = '';
    
    if (models.length === 0) {
        // Показываем сообщение "ничего не найдено"
        modelsList.style.display = 'none';
        if (noResultsMessage) {
            noResultsMessage.style.display = 'block';
        }
    } else {
        // Добавляем отсортированные модели
        models.forEach(item => {
            modelsList.appendChild(item);
        });
        
        modelsList.style.display = 'flex';
        modelsList.style.flexDirection = 'column';
        if (noResultsMessage) {
            noResultsMessage.style.display = 'none';
        }
    }
}

// Обновление счетчика результатов
function updateResultsCounter(count) {
    const counter = document.getElementById('resultsCounter');
    const total = window.allModels.length;
    
    if (counter) {
        if (count === total) {
            counter.innerHTML = `Найдено: <span>${count}</span> моделей`;
        } else {
            counter.innerHTML = `Найдено: <span>${count}</span> из ${total} моделей`;
        }
    }
}

// Очистка поиска
function clearSearch() {
    document.getElementById('modelSearch').value = '';
    document.getElementById('clearSearch').style.display = 'none';
    applyFilters();
}

// Сброс всех фильтров
function resetAllFilters() {
    document.getElementById('modelSearch').value = '';
    document.getElementById('categoryFilter').value = 'all';
    document.getElementById('sortFilter').value = 'newest';
    document.getElementById('clearSearch').style.display = 'none';
    
    applyFilters();
}

// Инициализация при загрузке
window.onload = function() {
    applyFilters();
};
</script>
@endsection