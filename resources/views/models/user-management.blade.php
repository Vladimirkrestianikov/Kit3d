@extends('layouts.app')

@section('title', 'Управление пользователями')

@section('content')
<div class="container">
    <!-- Заголовок -->
    <div class="models-header">
        <div class="header-left">
            <h1 class="page-title">Пользователи</h1>
            <div class="search-container">
                <div class="search-box">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="Поиск по имени или email..." 
                           value="{{ request('search') }}"
                           onkeypress="handleKeyPress(event)">
                    <button class="btn-search" onclick="performSearch()">
                        Поиск
                    </button>
                </div>
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-admin1">
                ← Назад
            </a>
        </div>
    </div>

    <div class="models-layout">
        <!-- Боковая панель фильтров -->
        <div class="filters-sidebar">
            <div class="filters-header">
                <h3><i class="fas fa-filter"></i> Фильтры</h3>
            </div>

            <!-- Сортировка -->
            <div class="filter-group">
                <h4 class="filter-title">Сортировка</h4>
                <div class="sort-options">
                    <label class="sort-option">
                        <input type="radio" name="sort" value="newest" 
                               {{ request('sort', 'newest') == 'newest' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        Новые
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="oldest"
                               {{ request('sort') == 'oldest' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        Старые
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="name_asc"
                               {{ request('sort') == 'name_asc' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        Имя А-Я
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="name_desc"
                               {{ request('sort') == 'name_desc' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        Имя Я-А
                    </label>
                </div>
            </div>

            <!-- Роли -->
            <div class="filter-group">
                <h4 class="filter-title">Роль</h4>
                <div class="category-filters">
                    @php
                        $selectedRoles = request('roles', []);
                        if (is_string($selectedRoles)) {
                            $selectedRoles = explode(',', $selectedRoles);
                        }
                    @endphp
                    <label class="category-filter">
                        <input type="checkbox" name="roles[]" value="admin"
                               {{ in_array('admin', $selectedRoles) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <div class="category-icon architecture">
                            <i class="fas fa-crown"></i>
                        </div>
                        <span class="category-name">Админы</span>
                    </label>
                    <label class="category-filter">
                        <input type="checkbox" name="roles[]" value="user"
                               {{ in_array('user', $selectedRoles) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <div class="category-icon design">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="category-name">Пользователи</span>
                    </label>
                </div>
            </div>

            <!-- Моделей -->
            <div class="filter-group">
                <h4 class="filter-title">Моделей</h4>
                <div class="price-range">
                    <div class="price-inputs">
                        <div class="price-input">
                            <label>От</label>
                            <input type="number" name="min_models" 
                                   value="{{ request('min_models') }}" 
                                   placeholder="0" min="0">
                        </div>
                        <div class="price-input">
                            <label>До</label>
                            <input type="number" name="max_models" 
                                   value="{{ request('max_models') }}" 
                                   placeholder="100" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Кнопки фильтров -->
            <div class="filter-actions">
                <button type="button" class="btn btn-secondary btn-reset" onclick="resetFilters()">
                    Сбросить
                </button>
            </div>
        </div>

        <!-- Основной контент -->
        <div class="models-content">
            <!-- Статистика -->
            <div class="models-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $totalUsers }}</div>
                        <div class="stat-label">Всего</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-crown"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $adminCount }}</div>
                        <div class="stat-label">Админов</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $todayUsers }}</div>
                        <div class="stat-label">Новых</div>
                    </div>
                </div>
            </div>

            <!-- Результаты поиска -->
            @if(request()->hasAny(['search', 'sort', 'roles', 'min_models', 'max_models']))
            <div class="search-results-info">
                <div class="results-count">
                    Найдено: <strong>{{ $users->total() }}</strong>
                </div>
                <button class="btn btn-sm btn-outline-secondary" onclick="resetFilters()">
                    Сбросить
                </button>
            </div>
            @endif

            <!-- Сетка пользователей -->
            @if($users->count() > 0)
                <div class="models-grid">
                    @foreach($users as $user)
                    <div class="model-card">
                        <div class="model-image">
                            <div class="user-avatar">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="model-overlay">
                                <div class="model-price">
                                    {{ $user->models_count }} моделей
                                </div>
                                <div class="model-actions-overlay">
                                    @if(!$user->is_admin && $user->id !== auth()->id())
                                        <form action="{{ route('admin.make') }}" method="POST" class="action-form">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                            <button type="submit" class="btn-overlay" title="Сделать админом">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        </form>
                                    @elseif($user->is_admin && $user->id !== auth()->id())
                                        <form action="{{ route('admin.remove', $user->id) }}" method="POST" class="action-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-overlay" title="Убрать админа">
                                                <i class="fas fa-minus-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="model-content">
                            <div class="model-header">
                                <h3 class="model-title">
                                    <a href="{{ route('admin.user.detail', $user->id) }}" class="user-link">
                                        {{ $user->name }}
                                    </a>
                                </h3>
                                <div class="model-category">
                                    @if($user->is_admin)
                                        <span class="category-badge category-architecture">
                                            <i class="fas fa-crown"></i>
                                        </span>
                                    @else
                                        <span class="category-badge category-design">
                                            <i class="fas fa-user"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <p class="model-description">{{ $user->email }}</p>
                            
                            <div class="model-meta">
                                <div class="meta-item">
                                    <i class="far fa-calendar"></i>
                                    {{ $user->created_at->format('d.m.Y') }}
                                </div>
                                <div class="meta-item">
                                    <i class="fas fa-cube"></i>
                                    {{ $user->models_count }}
                                </div>
                            </div>
                            
                            <div class="model-footer">
                                <a href="{{ route('admin.user.detail', $user->id) }}" class="btn btn-view">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Пагинация -->
                @if($users->hasPages())
                <div class="pagination-container">
                    <div class="pagination-info">
                        Показано {{ $users->firstItem() }} - {{ $users->lastItem() }} из {{ $users->total() }}
                    </div>
                    <div class="pagination-links">
                        {{ $users->links() }}
                    </div>
                </div>
                @endif
            @else
                <!-- Состояние пустой коллекции -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="empty-title">
                        @if(request()->hasAny(['search', 'roles', 'min_models', 'max_models']))
                            Пользователи не найдены
                        @else
                            Нет пользователей
                        @endif
                    </h3>
                    <p class="empty-description">
                        @if(request()->hasAny(['search', 'roles', 'min_models', 'max_models']))
                            Попробуйте изменить параметры поиска
                        @else
                            В системе пока нет пользователей
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'roles', 'min_models', 'max_models']))
                    <button class="btn btn-primary btn-empty" onclick="resetFilters()">
                        Сбросить фильтры
                    </button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Форма для фильтрации -->
<form id="filterForm" method="GET" action="{{ route('admin.users') }}" style="display: none;">
    <input type="text" name="search" id="formSearch" value="{{ request('search') }}">
    <input type="text" name="sort" id="formSort" value="{{ request('sort', 'newest') }}">
    <input type="text" name="roles" id="formRoles" value="{{ is_array(request('roles')) ? implode(',', request('roles')) : request('roles') }}">
    <input type="number" name="min_models" id="formMinModels" value="{{ request('min_models') }}">
    <input type="number" name="max_models" id="formMaxModels" value="{{ request('max_models') }}">
</form>

<style>
/* ОРАНЖЕВЫЙ СТИЛЬ как в моделях */

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
    margin-bottom: 20px;
    background: linear-gradient(135deg, #FF6B35 0%, #4CAF50 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.search-container {
    max-width: 500px;
}

.search-box {
    display: flex;
    background: white;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    border: 2px solid #e0e0e0;
    transition: all 0.3s;
}

.search-box:focus-within {
    border-color: #FF6B35;
    box-shadow: 0 5px 25px rgba(255, 107, 53, 0.2);
}

.search-box input {
    flex: 1;
    border: none;
    padding: 15px 20px;
    font-size: 1rem;
    outline: none;
    background: transparent;
}

.btn-search {
    background: #FF6B35;
    color: white;
    border: none;
    padding: 15px 25px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 600;
    font-size: 1rem;
    white-space: nowrap;
}

.btn-search:hover {
    background: #e55a2b;
}

.btn-admin1 {
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

.btn-admin1:hover {
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

/* Боковая панель фильтров */
.filters-sidebar {
    background: white;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
    position: sticky;
    top: 20px;
    max-height: calc(100vh - 100px);
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #FF6B35 #f0f0f0;
}

.filters-sidebar::-webkit-scrollbar {
    width: 6px;
}

.filters-sidebar::-webkit-scrollbar-track {
    background: #f0f0f0;
    border-radius: 3px;
}

.filters-sidebar::-webkit-scrollbar-thumb {
    background: #FF6B35;
    border-radius: 3px;
}

.filters-sidebar::-webkit-scrollbar-thumb:hover {
    background: #e55a2b;
}

.filters-header {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
    position: sticky;
    top: 0;
    background: white;
    z-index: 10;
}

.filters-header h3 {
    margin: 0;
    color: #333;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.models-content {
    min-height: 600px;
}

/* Стили для фильтров */
.filter-group {
    margin-bottom: 25px;
}

.filter-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
}

.sort-options {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.sort-option {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 10px;
    border-radius: 10px;
    transition: all 0.3s;
}

.sort-option:hover {
    background: rgba(255, 107, 53, 0.1);
}

.sort-option input {
    display: none;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid #ddd;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
}

.sort-option input:checked + .checkmark {
    border-color: #FF6B35;
    background: #FF6B35;
}

.sort-option input:checked + .checkmark::after {
    content: '';
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
}

/* Категории */
.category-filters {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.category-filter {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    padding: 12px;
    border-radius: 12px;
    transition: all 0.3s;
}

.category-filter:hover {
    background: rgba(255, 107, 53, 0.1);
    transform: translateX(5px);
}

.category-filter input {
    display: none;
}

.category-filter input:checked + .checkmark {
    background: #FF6B35;
    border-color: #FF6B35;
}

.category-filter input:checked + .checkmark::after {
    content: '✓';
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.category-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.category-icon.architecture { background: #FF6B35; }
.category-icon.design { background: #4CAF50; }

.category-name {
    font-weight: 500;
    color: #333;
}

/* Моделей */
.price-range {
    margin-top: 10px;
}

.price-inputs {
    display: flex;
    gap: 10px;
}

.price-input {
    flex: 1;
}

.price-input label {
    display: block;
    font-size: 0.8rem;
    color: #666;
    margin-bottom: 5px;
}

.price-input input {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: border-color 0.3s;
}

.price-input input:focus {
    outline: none;
    border-color: #FF6B35;
}

/* Кнопка сброса */
.filter-actions {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 2px solid #f0f0f0;
}

.btn-reset {
    width: 100%;
    padding: 12px;
    border-radius: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    color: #333;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-reset:hover {
    background: #e9ecef;
}

/* Сетка пользователей - 3 в ряд */
.models-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
}

/* Статистика - ОРАНЖЕВЫЙ ГРАДИЕНТ */
.models-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: linear-gradient(135deg, #FF6B35 0%, #4CAF50 100%);
    color: white;
    padding: 25px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 10px 30px rgba(255, 107, 53, 0.3);
}

.stat-icon {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    backdrop-filter: blur(10px);
}

.stat-info {
    flex: 1;
}

.stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    line-height: 1;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.9);
}

/* Карточки пользователей */
.model-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.08);
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    position: relative;
}

.model-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.model-image {
    position: relative;
    width: 100%;
    height: 180px;
    overflow: hidden;
    background: linear-gradient(135deg, #FF6B35 0%, #4CAF50 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-avatar {
    font-size: 4rem;
    color: white;
    opacity: 0.8;
}

.model-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(0,0,0,0.7));
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.model-card:hover .model-overlay {
    opacity: 1;
}

.model-price {
    background: rgba(255, 107, 53, 0.95);
    color: white;
    padding: 6px 12px;
    border-radius: 15px;
    font-weight: 600;
    font-size: 0.9rem;
    backdrop-filter: blur(10px);
}

.model-actions-overlay {
    display: flex;
    gap: 8px;
}

.action-form {
    margin: 0;
}

.btn-overlay {
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #333;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    backdrop-filter: blur(10px);
    padding: 0;
}

.btn-overlay:hover {
    background: #FF6B35;
    color: white;
    transform: scale(1.1);
}

.model-content {
    padding: 20px;
}

.model-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
    gap: 10px;
}

.model-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin: 0;
    line-height: 1.3;
    flex: 1;
}

.user-link {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s;
}

.user-link:hover {
    color: #FF6B35;
}

.model-description {
    color: #666;
    line-height: 1.5;
    margin-bottom: 15px;
    font-size: 0.9rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.model-meta {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #f0f0f0;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    color: #888;
    font-size: 0.8rem;
}

.model-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.btn-view {
    background: #FF6B35;
    color: white;
    padding: 8px 20px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
}

.btn-view:hover {
    background: #e55a2b;
    transform: translateY(-2px);
    color: white;
}

/* Категории бейджи */
.category-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.7rem;
    font-weight: 600;
    white-space: nowrap;
}

.category-architecture {
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
    border: 1px solid rgba(255, 107, 53, 0.3);
}

.category-design {
    background: rgba(76, 175, 80, 0.1);
    color: #4CAF50;
    border: 1px solid rgba(76, 175, 80, 0.3);
}

.search-results-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 15px 20px;
    background: #fef6e8;
    border-radius: 12px;
    border-left: 4px solid #FF6B35;
}

.pagination-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 40px;
    padding-top: 25px;
    border-top: 1px solid #e0e0e0;
}

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

.btn-empty {
    padding: 12px 30px;
    border-radius: 12px;
    font-weight: 600;
    background: #FF6B35;
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-empty:hover {
    background: #e55a2b;
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
    
    .search-container {
        max-width: 100%;
    }
    
    .search-box {
        flex-direction: column;
        border-radius: 12px;
    }
    
    .search-box input {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
    }
    
    .btn-search {
        padding: 12px;
        border-radius: 0 0 10px 10px;
    }
    
    .btn-admin1 {
        justify-content: center;
        width: 100%;
    }
    
    .models-layout {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .filters-sidebar {
        position: static;
        max-height: none;
        order: 2;
    }
    
    .models-content {
        order: 1;
    }
    
    .models-grid {
        grid-template-columns: 1fr !important;
        gap: 20px;
    }
    
    .models-stats {
        grid-template-columns: 1fr;
    }
    
    .pagination-container {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .search-results-info {
        flex-direction: column;
        gap: 10px;
        text-align: center;
    }
}

@media (max-width: 1200px) and (min-width: 769px) {
    .models-layout {
        grid-template-columns: 280px 1fr;
    }
    
    .models-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 1200px) {
    .models-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');

    // Поиск с задержкой
    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('formSearch').value = this.value;
            filterForm.submit();
        }, 800);
    });

    // Автоматическое применение при изменении фильтров
    const filterInputs = document.querySelectorAll(
        'input[name="sort"], input[name="roles[]"], input[name="min_models"], input[name="max_models"]'
    );

    filterInputs.forEach(input => {
        input.addEventListener('change', () => {
            applyFilters();
        });
    });
});

function applyFilters() {
    const sort = document.querySelector('input[name="sort"]:checked');
    const roles = Array.from(document.querySelectorAll('input[name="roles[]"]:checked'))
        .map(cb => cb.value);
    const minModels = document.querySelector('input[name="min_models"]').value;
    const maxModels = document.querySelector('input[name="max_models"]').value;

    document.getElementById('formSort').value = sort ? sort.value : 'newest';
    document.getElementById('formRoles').value = roles.join(',');
    document.getElementById('formMinModels').value = minModels;
    document.getElementById('formMaxModels').value = maxModels;

    document.getElementById('filterForm').submit();
}

function resetFilters() {
    window.location.href = "{{ route('admin.users') }}";
}

function handleKeyPress(event) {
    if (event.key === 'Enter') {
        performSearch();
    }
}

function performSearch() {
    document.getElementById('formSearch').value = document.getElementById('searchInput').value;
    document.getElementById('filterForm').submit();
}
</script>

@endsection