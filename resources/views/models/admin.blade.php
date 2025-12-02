@extends('layouts.app')

@section('title', 'Админ-панель')

@section('content')
<div class="container">
    <!-- Заголовок и поиск -->
    <div class="models-header">
        <div class="header-left">
            <h1 class="page-title">Админ-панель</h1>
            <div class="search-container">
                <div class="search-box">
                    <input type="text" 
                           id="searchInput" 
                           placeholder="Поиск по названию модели..." 
                           value="{{ request('search') }}"
                           onkeypress="handleKeyPress(event)">
                    <button class="btn-search" onclick="performSearch()">
                        Поиск
                    </button>
                </div>
            </div>
        </div>
        <div class="header-right">
            <a href="{{ route('admin.addadmin') }}" class="btn btn-admin1">
                                <i class="fas fa-cog"></i> Управление админами
             </a>

             <a href="{{ route('admin.users') }}" class="btn btn-admin1">
                                <i class="fas fa-cog"></i>Все Пользователи
             </a>

        </div>
    </div>

    <div class="models-layout">
        <!-- Боковая панель фильтров -->
        <div class="filters-sidebar">
            <div class="filters-header">
                <h3><i class="fas fa-filter"></i> Фильтры и сортировка</h3>
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
                        Сначала новые
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="oldest"
                               {{ request('sort') == 'oldest' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        Сначала старые
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="price_asc"
                               {{ request('sort') == 'price_asc' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        Цена по возрастанию
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="price_desc"
                               {{ request('sort') == 'price_desc' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        Цена по убыванию
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="name_asc"
                               {{ request('sort') == 'name_asc' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        По названию (А-Я)
                    </label>
                    <label class="sort-option">
                        <input type="radio" name="sort" value="name_desc"
                               {{ request('sort') == 'name_desc' ? 'checked' : '' }}
                               onchange="applyFilters()">
                        <span class="checkmark"></span>
                        По названию (Я-А)
                    </label>
                </div>
            </div>

            <!-- Категории -->
            <div class="filter-group">
                <h4 class="filter-title">Категории</h4>
                <div class="category-filters">
                    @php
                        $selectedCategories = request('categories', []);
                        if (is_string($selectedCategories)) {
                            $selectedCategories = explode(',', $selectedCategories);
                        }
                    @endphp
                    <label class="category-filter">
                        <input type="checkbox" name="categories[]" value="architecture"
                               {{ in_array('architecture', $selectedCategories) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <div class="category-icon architecture">
                            <i class="fas fa-building"></i>
                        </div>
                        <span class="category-name">Архитектура</span>
                    </label>
                    <label class="category-filter">
                        <input type="checkbox" name="categories[]" value="design"
                               {{ in_array('design', $selectedCategories) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <div class="category-icon design">
                            <i class="fas fa-palette"></i>
                        </div>
                        <span class="category-name">Дизайн</span>
                    </label>
                    <label class="category-filter">
                        <input type="checkbox" name="categories[]" value="science"
                               {{ in_array('science', $selectedCategories) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <div class="category-icon science">
                            <i class="fas fa-flask"></i>
                        </div>
                        <span class="category-name">Научные</span>
                    </label>
                    <label class="category-filter">
                        <input type="checkbox" name="categories[]" value="entertainment"
                               {{ in_array('entertainment', $selectedCategories) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <div class="category-icon entertainment">
                            <i class="fas fa-gamepad"></i>
                        </div>
                        <span class="category-name">Развлекательные</span>
                    </label>
                    <label class="category-filter">
                        <input type="checkbox" name="categories[]" value="other"
                               {{ in_array('other', $selectedCategories) ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                        <div class="category-icon other">
                            <i class="fas fa-cube"></i>
                        </div>
                        <span class="category-name">Другое</span>
                    </label>
                </div>
            </div>

            <!-- Цена -->
            <div class="filter-group">
                <h4 class="filter-title">Цена ($)</h4>
                <div class="price-range">
                    <div class="price-inputs">
                        <div class="price-input">
                            <label>От</label>
                            <input type="number" name="min_price" 
                                   value="{{ request('min_price') }}" 
                                   placeholder="0" min="0">
                        </div>
                        <div class="price-input">
                            <label>До</label>
                            <input type="number" name="max_price" 
                                   value="{{ request('max_price') }}" 
                                   placeholder="10000" min="0">
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
            @if($models->count() > 0)
            <div class="models-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-cube"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">{{ $totalModels }}</div>
                        <div class="stat-label">Всего моделей</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-info">
                        <div class="stat-number">${{ number_format($totalPrice, 2) }}</div>
                        <div class="stat-label">Общая стоимость</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                      <div class="stat-number">{{ $usersCount }}</div>
                        <div class="stat-label">Пользователей</div>
                    </div>
                </div>
            </div>

            <!-- Результаты поиска -->
            @if(request()->hasAny(['search', 'sort', 'categories', 'min_price', 'max_price']))
            <div class="search-results-info">
                <div class="results-count">
                    Найдено моделей: <strong>{{ $models->total() }}</strong>
                </div>
                <button class="btn btn-sm btn-outline-secondary" onclick="resetFilters()">
                    Сбросить фильтры
                </button>
            </div>
            @endif

            <!-- Сетка моделей -->
            <div class="models-grid">
                @foreach($models as $model)
                <div class="model-card" id="model-{{ $model->id }}">
                    <div class="model-image">
                        <img src="{{ Storage::url($model->image_path) }}" 
                             alt="{{ $model->name }}"
                             class="model-preview">
                        <div class="model-overlay">
                            <div class="model-price">${{ number_format($model->price, 2) }}</div>
                            <div class="model-author-overlay">
                                <div class="author-info">
                                    <i class="fas fa-user"></i>
                                    {{ $model->user->name }}
                                </div>
                            </div>
                            <!-- Кнопки действий в оверлее -->
                            <div class="model-actions-overlay">
                                <button class="btn-overlay btn-view" 
                                        onclick="window.location='{{ route('models.all.show', $model) }}'"
                                        title="Посмотреть">
                                    <i class="fas fa-eye"></i>
                                </button>
                               
                            </div>
                        </div>
                    </div>
                    
                    <div class="model-content">
                        <div class="model-header">
                            <h3 class="model-title">{{ $model->name }}</h3>
                            <div class="model-category">
                                <span class="category-badge category-{{ $model->category }}">
                                    @switch($model->category)
                                        @case('architecture')
                                             <i class="fas fa-building"></i> <!--Архитектура -->
                                            @break
                                        @case('design')
                                            <i class="fas fa-palette"></i><!-- Дизайн-->
                                            @break
                                        @case('science')
                                            <i class="fas fa-flask"></i><!-- Наука-->
                                            @break
                                        @case('entertainment')
                                            <i class="fas fa-gamepad"></i><!-- Развлечения-->
                                            @break
                                        @default
                                            <i class="fas fa-cube"></i><!-- Другое-->
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        
                        <p class="model-description">{{ Str::limit($model->description, 100) }}</p>
                        
                        <div class="model-meta">
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                {{ $model->user->name }}
                            </div>
                            <div class="meta-item">
                                <i class="far fa-calendar"></i>
                                {{ $model->created_at->format('d.m.Y') }}
                            </div>
                        </div>
                        
                        <div class="model-footer">
                            <button onclick="window.location='{{ route('models.all.show', $model) }}'" 
                                    class="btn btn-view">
                                Посмотреть
                            </button>
                          <form method="POST" action="{{ route('models.destroy', $model) }}" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-overlay btn-delete" 
            onclick="return confirm('Вы уверены, что хотите удалить эту модель?')"
            title="Удалить модель">
        <i class="fas fa-trash"></i>
    </button>
</form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Пагинация -->
            @if($models->hasPages())
            <div class="pagination-container">
                <div class="pagination-info">
                    Показано {{ $models->firstItem() }} - {{ $models->lastItem() }} из {{ $models->total() }} моделей
                </div>
                <div class="pagination-links">
                    {{ $models->links() }}
                </div>
            </div>
            @endif

            @else
            <!-- Состояние пустой коллекции -->
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-cube"></i>
                </div>
                <h3 class="empty-title">
                    @if(request()->hasAny(['search', 'categories', 'min_price', 'max_price']))
                        Модели не найдены
                    @else
                        Пока нет моделей
                    @endif
                </h3>
                <p class="empty-description">
                    @if(request()->hasAny(['search', 'categories', 'min_price', 'max_price']))
                        Попробуйте изменить параметры поиска или сбросить фильтры
                    @else
                        В системе еще нет 3D моделей
                    @endif
                </p>
                @if(request()->hasAny(['search', 'categories', 'min_price', 'max_price']))
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
<!-- Форма для фильтрации -->
<form id="filterForm" method="GET" action="{{ route('admin.dashboard') }}" style="display: none;">
    <input type="text" name="search" id="formSearch" value="{{ request('search') }}">
    <input type="text" name="sort" id="formSort" value="{{ request('sort', 'newest') }}">
    <input type="text" name="categories" id="formCategories" value="{{ is_array(request('categories')) ? implode(',', request('categories')) : request('categories') }}">
    <input type="number" name="min_price" id="formMinPrice" value="{{ request('min_price') }}">
    <input type="number" name="max_price" id="formMaxPrice" value="{{ request('max_price') }}">
</form>


<style>


/* Стили из предыдущей страницы (остаются те же) */
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

.btn-add-model {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 15px 25px;
    font-weight: 600;
    white-space: nowrap;
    border-radius: 12px;
}

/* Layout */
.models-layout {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 30px;
    align-items: start;
    min-height: calc(100vh - 200px);
}

/* Боковая панель фильтров - ФИКСИРОВАННАЯ */
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

/* Основной контент - прокручивается отдельно */
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
.category-icon.science { background: #2196F3; }
.category-icon.entertainment { background: #9C27B0; }
.category-icon.other { background: #607D8B; }

.category-name {
    font-weight: 500;
    color: #333;
}

/* Цена */
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
}

/* Сетка моделей - 3 в ряд */
.models-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
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
    
    .btn-add-model {
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

/* Остальные стили (карточки, статистика и т.д. остаются без изменений) */
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

/* Улучшенные карточки моделей */
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
    height: 220px;
    overflow: hidden;
}

.model-preview {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.model-card:hover .model-preview {
    transform: scale(1.05);
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
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 1rem;
    backdrop-filter: blur(10px);
}

.model-actions-overlay {
    display: flex;
    gap: 8px;
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
    text-decoration: none;
    transition: all 0.3s;
    backdrop-filter: blur(10px);
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

.category-science {
    background: rgba(33, 150, 243, 0.1);
    color: #2196F3;
    border: 1px solid rgba(33, 150, 243, 0.3);
}

.category-entertainment {
    background: rgba(156, 39, 176, 0.1);
    color: #9C27B0;
    border: 1px solid rgba(156, 39, 176, 0.3);
}

.category-other {
    background: rgba(158, 158, 158, 0.1);
    color: #9E9E9E;
    border: 1px solid rgba(158, 158, 158, 0.3);
}

.search-results-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 15px 20px;
    background: #e8f5e8;
    border-radius: 12px;
    border-left: 4px solid #4CAF50;
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
    margin: 0 auto;
}
/* Скопируй все CSS стили из того файла сюда */

/* Добавляем стили для админ-панели */
.admin-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px 0;
    margin-bottom: 30px;
    border-radius: 15px;
}

.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.admin-stat-card {
    background: white;
    padding: 25px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    text-align: center;
    border-left: 4px solid #667eea;
}

.admin-stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #667eea;
    margin-bottom: 10px;
}

.admin-stat-label {
    color: #666;
    font-size: 1rem;
}

/* Остальные стили такие же как в all.blade.php */
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
    border-color: #667eea;
    box-shadow: 0 5px 25px rgba(102, 126, 234, 0.2);
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
    background: #5a6fd8;
}

/* ... и так далее - ВСТАВЬ ВСЕ ОСТАЛЬНЫЕ СТИЛИ ИЗ ПРЕДЫДУЩЕГО ФАЙЛА ... */

</style>

<script>
    let modelToDelete = null;

document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');

    // 🔎 Поиск с задержкой (800 мс)
    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            document.getElementById('formSearch').value = this.value;
            filterForm.submit();
        }, 800);
    });

    // Автоматическое применение при изменении чекбоксов, радио, цены
    const filterInputs = document.querySelectorAll(
        'input[name="sort"], input[name="categories[]"], input[name="min_price"], input[name="max_price"]'
    );

    filterInputs.forEach(input => {
        input.addEventListener('change', () => {
            applyFilters();
        });
    });
});

// 🔥 Основная функция автофильтрации
// 🔥 Основная функция автофильтрации
function applyFilters() {
    const sort = document.querySelector('input[name="sort"]:checked');
    const categories = Array.from(document.querySelectorAll('input[name="categories[]"]:checked'))
        .map(cb => cb.value);
    const minPrice = document.querySelector('input[name="min_price"]').value;
    const maxPrice = document.querySelector('input[name="max_price"]').value;

    document.getElementById('formSort').value = sort ? sort.value : 'newest';
    document.getElementById('formCategories').value = categories.join(',');
    document.getElementById('formMinPrice').value = minPrice;
    document.getElementById('formMaxPrice').value = maxPrice;

    document.getElementById('filterForm').submit();
}

// Инициализация значений фильтров при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Устанавливаем начальные значения для полей цены
    const urlParams = new URLSearchParams(window.location.search);
    document.querySelector('input[name="min_price"]').value = urlParams.get('min_price') || '';
    document.querySelector('input[name="max_price"]').value = urlParams.get('max_price') || '';
    
    // Устанавливаем поисковый запрос
    document.getElementById('searchInput').value = urlParams.get('search') || '';
});





// 🔄 Сброс фильтров
function resetFilters() {
    window.location.href = "{{ route('admin.dashboard') }}";
}

// 🗑️ Функции для удаления моделей





// Подтверждение удаления

// Обработка нажатия Enter в поле поиска
function handleKeyPress(event) {
    if (event.key === 'Enter') {
        performSearch();
    }
}

function performSearch() {
    document.getElementById('formSearch').value = document.getElementById('searchInput').value;
    document.getElementById('filterForm').submit();
}

// Закрытие модального окна при клике вне его
window.addEventListener('click', function(event) {
    const modal = document.getElementById('deleteModal');
    if (event.target === modal) {
        closeModal();
    }
});
</script>

@endsection