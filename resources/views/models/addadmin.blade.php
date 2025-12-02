@extends('layouts.app')

@section('title', 'Управление администраторами')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="upload-card">
                <div class="upload-header">
                    <h2 class="upload-title">Управление администраторами</h2>
                    <p class="upload-subtitle">Добавьте или удалите права администратора</p>
                </div>

                <div class="upload-body">
                    <!-- Сообщения -->
                    @if(session('success'))
                    <div class="alert-success">
                        <i class="fas fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                    @endif

                    <!-- Форма добавления админа -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user-plus"></i>
                            Добавить нового администратора
                        </h3>
                        
                        <form action="{{ route('admin.make') }}" method="POST" class="admin-form">
                            @csrf
                            
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="user_id" class="form-label">Выберите пользователя *</label>
                                    <select name="user_id" id="user_id" class="form-select" required>
                                        <option value="">-- Выберите пользователя --</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }} ({{ $user->email }})
                                                @if($user->is_admin) - уже администратор @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-hint">Только обычные пользователи могут стать администраторами</div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-admin-action">
                                        <i class="fas fa-user-shield"></i>
                                        Назначить администратором
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Список текущих админов -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-users-cog"></i>
                            Текущие администраторы
                        </h3>
                        
                        @php
                            $admins = \App\Models\User::where('is_admin', true)->get();
                            $currentUser = auth()->user();
                            $currentAdmin = $admins->firstWhere('id', $currentUser->id);
                            $otherAdmins = $admins->where('id', '!=', $currentUser->id);
                        @endphp
                        
                        @if($admins->count() > 0)
                            <div class="admins-list">
                                <!-- Текущий пользователь (всегда первый) -->
                                @if($currentAdmin)
                                    <div class="admin-card current-user">
                                        <div class="admin-info">
                                            <div class="admin-avatar">
                                                <i class="fas fa-user-circle"></i>
                                            </div>
                                            <div class="admin-details">
                                                <h4 class="admin-name">
                                                    {{ $currentAdmin->name }}
                                                    <span class="badge-you">Вы (Текущий администратор)</span>
                                                </h4>
                                                <p class="admin-email">{{ $currentAdmin->email }}</p>
                                                <div class="admin-meta">
                                                    <span class="meta-item">
                                                        <i class="far fa-calendar"></i>
                                                        Зарегистрирован: {{ $currentAdmin->created_at->format('d.m.Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="admin-actions">
                                            <span class="cannot-remove">Нельзя убрать свои права</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Остальные администраторы -->
                                @foreach($otherAdmins as $admin)
                                    <div class="admin-card">
                                        <div class="admin-info">
                                            <div class="admin-avatar">
                                                <i class="fas fa-user-circle"></i>
                                            </div>
                                            <div class="admin-details">
                                                <h4 class="admin-name">{{ $admin->name }}</h4>
                                                <p class="admin-email">{{ $admin->email }}</p>
                                                <div class="admin-meta">
                                                    <span class="meta-item">
                                                        <i class="far fa-calendar"></i>
                                                        Зарегистрирован: {{ $admin->created_at->format('d.m.Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="admin-actions">
                                            <form action="{{ route('admin.remove', $admin->id) }}" method="POST" 
                                                  class="remove-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-remove" 
                                                        onclick="return confirm('Вы уверены, что хотите убрать права администратора у {{ $admin->name }}?')">
                                                    <i class="fas fa-user-minus"></i>
                                                    Убрать права
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <i class="fas fa-users-slash"></i>
                                <h4>Нет администраторов в системе</h4>
                                <p>Добавьте первого администратора с помощью формы выше</p>
                            </div>
                        @endif
                    </div>

                    <!-- Кнопка возврата -->
                    <div class="form-actions">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Назад в админ-панель
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.upload-card {
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 30px 0;
}

.upload-header {
    background: linear-gradient(135deg, #FF6B35 0%, #4CAF50 100%);
    color: white;
    padding: 40px;
    text-align: center;
}

.upload-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 10px;
}

.upload-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.upload-body {
    padding: 40px;
}

.form-section {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 2px solid #f0f0f0;
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 0;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 25px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.section-title i {
    color: #FF6B35;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 25px;
    align-items: end;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 0;
}

.form-label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
    font-size: 1rem;
}

.form-select {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 15px;
    font-size: 1rem;
    transition: all 0.3s;
    background: #f8f9fa;
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    background-position: right 15px center;
    background-repeat: no-repeat;
    background-size: 16px 12px;
}

.form-select:focus {
    outline: none;
    border-color: #FF6B35;
    background: white;
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
}

.form-hint {
    font-size: 0.875rem;
    color: #666;
    margin-top: 5px;
}

.alert-success {
    background: #e8f5e8;
    color: #2e7d32;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 30px;
    border-left: 4px solid #4CAF50;
    display: flex;
    align-items: center;
    gap: 10px;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 30px;
    border-left: 4px solid #dc3545;
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-primary {
    background: #FF6B35;
    color: white;
    border: none;
    padding: 15px 25px;
    border-radius: 15px;
    font-weight: 600;
    transition: all 0.3s;
    cursor: pointer;
}

.btn-primary:hover {
    background: #e55a2b;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3);
}

.btn-admin-action {
    padding: 15px 25px;
    font-weight: 600;
    white-space: nowrap;
}

.admins-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.admin-card {
    background: #f8f9fa;
    border: 2px solid #e0e0e0;
    border-radius: 15px;
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s;
}

.admin-card:hover {
    border-color: #FF6B35;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.admin-card.current-user {
    background: rgba(255, 107, 53, 0.05);
    border-color: #FF6B35;
    order: -1; /* Всегда первый */
}

.admin-info {
    display: flex;
    align-items: center;
    gap: 20px;
    flex: 1;
}

.admin-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FF6B35 0%, #4CAF50 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.admin-details {
    flex: 1;
}

.admin-name {
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.badge-you {
    background: #FF6B35;
    color: white;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 500;
}

.admin-email {
    color: #666;
    margin-bottom: 10px;
    font-size: 0.95rem;
}

.admin-meta {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8rem;
    color: #888;
}

.admin-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.btn-danger {
    background: #dc3545;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.3s;
    cursor: pointer;
}

.btn-danger:hover {
    background: #c82333;
    transform: translateY(-2px);
}

.btn-remove {
    white-space: nowrap;
}

.cannot-remove {
    color: #666;
    font-style: italic;
    font-size: 0.9rem;
}

.remove-form {
    margin: 0;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #666;
}

.empty-state i {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 20px;
    display: block;
}

.empty-state h4 {
    font-size: 1.3rem;
    margin-bottom: 10px;
    color: #333;
}

.empty-state p {
    font-size: 1rem;
}

.form-actions {
    display: flex;
    justify-content: center;
    margin-top: 40px;
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 12px 30px;
    border-radius: 15px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s;
}

.btn-secondary:hover {
    background: #5a6268;
    color: white;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .admin-card {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
    
    .admin-info {
        flex-direction: column;
        text-align: center;
    }
    
    .admin-meta {
        justify-content: center;
    }
    
    .admin-actions {
        width: 100%;
        justify-content: center;
    }
    
    .admin-name {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('user_id');
    
    // Обновляем список пользователей при загрузке
    updateUserList();
    
    function updateUserList() {
        const options = userSelect.options;
        for (let i = 0; i < options.length; i++) {
            const option = options[i];
            if (option.value && option.text.includes('уже администратор')) {
                option.disabled = true;
                option.style.color = '#999';
            }
        }
    }
    
    // Подтверждение удаления
    const removeForms = document.querySelectorAll('.remove-form');
    removeForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Вы уверены, что хотите убрать права администратора у этого пользователя?')) {
                e.preventDefault();
            }
        });
    });
});
</script>
@endsection