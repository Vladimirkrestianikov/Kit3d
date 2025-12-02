<!-- Удаление аккаунта -->
<div class="form-card">
    <h3><i class="fas fa-trash-alt me-2"></i>Удаление аккаунта</h3>
    
    <div class="alert alert-warning">
        <i class="fas fa-exclamation-circle me-2"></i>
        После удаления аккаунта все ваши данные будут безвозвратно удалены.
    </div>

    <!-- Шаг 1: Кнопка начала процесса -->
    <button type="button" class="btn btn-danger" onclick="showPasswordStep()">
        <i class="fas fa-trash me-2"></i>Удалить аккаунт
    </button>

    <!-- Шаг 2: Поле для пароля (изначально скрыто) -->
    <div id="passwordStep" class="mt-4" style="display: none;">
        <div class="border-top pt-3">
            <p class="text-danger fw-bold mb-3">Для подтверждения введите ваш пароль:</p>
            
            <form method="POST" action="{{ route('profile.destroy') }}" id="deleteForm">
                @csrf
                @method('DELETE')
                
                <div class="mb-3">
                    <label for="deletePassword" class="form-label">Пароль:</label>
                    <input type="password" class="form-control" id="deletePassword" name="password" required 
                           placeholder="Введите ваш текущий пароль">
                    @error('password', 'userDeletion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-secondary" onclick="hidePasswordStep()">
                        <i class="fas fa-times me-2"></i>Отмена
                    </button>
                    <button type="button" class="btn btn-danger" onclick="finalConfirm()">
                        <i class="fas fa-trash me-2"></i>Подтвердить удаление
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showPasswordStep() {
    document.getElementById('passwordStep').style.display = 'block';
}

function hidePasswordStep() {
    document.getElementById('passwordStep').style.display = 'none';
    document.getElementById('deletePassword').value = '';
}

function finalConfirm() {
    const password = document.getElementById('deletePassword').value;
    
    if (!password) {
        alert('Пожалуйста, введите ваш пароль');
        return;
    }
    
    // Красивое подтверждение с подсветкой
    if (confirm('🚨 ВНИМАНИЕ! ВЫ УВЕРЕНЫ?\n\nЭто приведет к:\n• Безвозвратному удалению всех данных\n• Удалению всех ваших 3D моделей\n• Потере доступа к аккаунту\n\nДействие НЕЛЬЗЯ отменить!')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>