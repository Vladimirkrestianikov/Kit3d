@extends('layouts.app')

@section('title', 'Добавить модель')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="upload-card">
                <div class="upload-header">
                    <h2 class="upload-title">Добавить новую модель</h2>
                    <p class="upload-subtitle">Заполните информацию о вашей 3D модели</p>
                </div>

                <div class="upload-body">
                    <!-- Отладочная информация -->
                    @if ($errors->any())
                    <div class="alert-error">
                        <h5>Ошибки валидации:</h5>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('models.store') }}" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="name" class="form-label">Имя модели *</label>
                                <input type="text" class="form-input @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required
                                       pattern="[A-Za-zА-Яа-яЁё\s]{2,50}" 
                                       title="Только буквы и пробелы (2-50 символов)">
                                @error('name')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="price" class="form-label">Цена ($) *</label>
                                <input type="text" class="form-input @error('price') is-invalid @enderror" 
                                       id="price" name="price" value="{{ old('price') }}" 
                                       required placeholder="0.00"
                                       inputmode="decimal">
                                <div class="form-hint">Только цифры и точка (например: 99.99)</div>
                                @error('price')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="phone" class="form-label">Номер телефона *</label>
                                <input type="tel" class="form-input @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" 
                                       pattern="8[0-9]{10}" 
                                       placeholder="87771234567"
                                       title="Казахстанский номер: 8XXXXXXXXXX (11 цифр)" required>
                                <div class="form-hint">Формат: 8XXXXXXXXXX (11 цифр)</div>
                                @error('phone')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" class="form-input @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" 
                                       pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                       title="Введите корректный email адрес" required>
                                @error('email')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telegram" class="form-label">Telegram контакт *</label>
                            <input type="text" class="form-input @error('telegram') is-invalid @enderror" 
                                   id="telegram" name="telegram" value="{{ old('telegram') }}" 
                                   pattern="@[a-zA-Z0-9_]{5,32}|[a-zA-Z0-9_]{5,32}"
                                   title="Telegram username (с @ или без)" required>
                            <div class="form-hint">Введите @username или просто username</div>
                            @error('telegram')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Категория *</label>
                            <div class="category-grid">
                                <label class="category-option">
                                    <input type="radio" name="category" value="architecture" {{ old('category') == 'architecture' ? 'checked' : '' }} required>
                                    <div class="category-card">
                                        <i class="fas fa-building"></i>
                                        <span>Архитектура</span>
                                    </div>
                                </label>
                                <label class="category-option">
                                    <input type="radio" name="category" value="design" {{ old('category') == 'design' ? 'checked' : '' }}>
                                    <div class="category-card">
                                        <i class="fas fa-palette"></i>
                                        <span>Дизайн</span>
                                    </div>
                                </label>
                                <label class="category-option">
                                    <input type="radio" name="category" value="science" {{ old('category') == 'science' ? 'checked' : '' }}>
                                    <div class="category-card">
                                        <i class="fas fa-flask"></i>
                                        <span>Научные</span>
                                    </div>
                                </label>
                                <label class="category-option">
                                    <input type="radio" name="category" value="entertainment" {{ old('category') == 'entertainment' ? 'checked' : '' }}>
                                    <div class="category-card">
                                        <i class="fas fa-gamepad"></i>
                                        <span>Развлекательные</span>
                                    </div>
                                </label>
                                <label class="category-option">
                                    <input type="radio" name="category" value="other" {{ old('category') == 'other' ? 'checked' : '' }}>
                                    <div class="category-card">
                                        <i class="fas fa-cube"></i>
                                        <span>Другое</span>
                                    </div>
                                </label>
                            </div>
                            @error('category')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Описание модели *</label>
                            <textarea class="form-textarea @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      minlength="10" maxlength="500" required
                                      placeholder="Опишите вашу 3D модель...">{{ old('description') }}</textarea>
                            <div class="form-hint">Минимум 10 символов, максимум 500</div>
                            @error('description')
                                <div class="form-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="image" class="form-label">Изображение превью *</label>
                                <div class="file-upload">
                                    <input type="file" class="file-input @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" required>
                                    <div class="file-upload-area" id="imageUploadArea">
                                        <i class="fas fa-image"></i>
                                        <span class="file-text">Перетащите или выберите изображение</span>
                                        <span class="file-hint">JPEG, PNG, JPG, GIF, WebP • Макс. 2MB</span>
                                    </div>
                                </div>
                                @error('image')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="model_file" class="form-label">3D модель файл *</label>
                                <div class="file-upload">
                                    <input type="file" class="file-input @error('model_file') is-invalid @enderror" 
                                           id="model_file" name="model_file" 
                                           accept=".glb,.gltf,.obj,.stl" required>
                                    <div class="file-upload-area" id="modelUploadArea">
                                        <i class="fas fa-cube"></i>
                                        <span class="file-text">Перетащите или выберите 3D модель</span>
                                        <span class="file-hint">GLB, GLTF, OBJ, • Макс. 100MB</span>
                                    </div>
                                </div>
                                @error('model_file')
                                    <div class="form-error">{{ $message }}</div>
                                @enderror
                                <div id="fileInfo" class="file-info"></div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary btn-upload" id="submitBtn">
                                <i class="fas fa-plus"></i>
                                Добавить модель
                            </button>
                            <a href="{{ route('models.index') }}" class="btn btn-secondary">Отмена</a>
                        </div>
                    </form>
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

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-bottom: 25px;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

.form-group {
    margin-bottom: 25px;
}

.form-label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
    font-size: 1rem;
}

.form-input, .form-textarea {
    width: 100%;
    padding: 15px 20px;
    border: 2px solid #e0e0e0;
    border-radius: 15px;
    font-size: 1rem;
    transition: all 0.3s;
    background: #f8f9fa;
}

.form-input:focus, .form-textarea:focus {
    outline: none;
    border-color: #FF6B35;
    background: white;
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 120px;
}

.form-hint {
    font-size: 0.875rem;
    color: #666;
    margin-top: 5px;
}

.form-error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 5px;
}

.alert-error {
    background: #f8d7da;
    color: #721c24;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 30px;
    border-left: 4px solid #dc3545;
}

.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 15px;
    margin-top: 10px;
}

.category-option {
    cursor: pointer;
}

.category-option input {
    display: none;
}

.category-card {
    background: #f8f9fa;
    border: 2px solid #e0e0e0;
    border-radius: 15px;
    padding: 20px 15px;
    text-align: center;
    transition: all 0.3s;
}

.category-option input:checked + .category-card {
    border-color: #FF6B35;
    background: rgba(255, 107, 53, 0.1);
    color: #FF6B35;
}

.category-card i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}

.category-card span {
    font-weight: 600;
    font-size: 0.9rem;
}

.file-upload {
    position: relative;
}

.file-input {
    position: absolute;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-area {
    background: #f8f9fa;
    border: 2px dashed #e0e0e0;
    border-radius: 15px;
    padding: 40px 20px;
    text-align: center;
    transition: all 0.3s;
    cursor: pointer;
}

.file-upload-area:hover, .file-input:focus + .file-upload-area {
    border-color: #FF6B35;
    background: rgba(255, 107, 53, 0.05);
}

.file-upload-area i {
    font-size: 3rem;
    color: #666;
    margin-bottom: 15px;
    display: block;
}

.file-text {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
    color: #333;
}

.file-hint {
    font-size: 0.875rem;
    color: #666;
}

.file-info {
    background: #e8f5e8;
    border: 1px solid #4CAF50;
    border-radius: 10px;
    padding: 15px;
    margin-top: 10px;
    font-size: 0.875rem;
    color: #2e7d32;
}

.form-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-top: 40px;
    flex-wrap: wrap;
}

.btn-upload {
    padding: 15px 40px;
    font-size: 1.1rem;
    font-weight: 600;
}

.btn-upload i {
    margin-right: 8px;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid + .file-upload-area {
    border-color: #dc3545 !important;
}

.price-error {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 5px;
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modelFileInput = document.getElementById('model_file');
    const imageFileInput = document.getElementById('image');
    const fileInfo = document.getElementById('fileInfo');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('uploadForm');
    const phoneInput = document.getElementById('phone');
    const emailInput = document.getElementById('email');
    const telegramInput = document.getElementById('telegram');
    const imageUploadArea = document.getElementById('imageUploadArea');
    const modelUploadArea = document.getElementById('modelUploadArea');
    const priceInput = document.getElementById('price');

    // ВАЛИДАЦИЯ ЦЕНЫ - ОСНОВНАЯ ФУНКЦИЯ
    function validatePrice(input) {
        let value = input.value;
        
        // Удаляем все символы кроме цифр и точки
        value = value.replace(/[^0-9.]/g, '');
        
        // Удаляем лишние точки (оставляем только первую)
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }
        
        // Ограничиваем до 2 знаков после запятой
        if (parts.length === 2 && parts[1].length > 2) {
            value = parts[0] + '.' + parts[1].substring(0, 2);
        }
        
        // Если первая точка, добавляем 0 перед ней
        if (value.startsWith('.')) {
            value = '0' + value;
        }
        
        // Не позволяем вводить больше 10 знаков до точки
        if (parts[0].length > 10) {
            value = parts[0].substring(0, 10) + (parts[1] ? '.' + parts[1] : '');
        }
        
        input.value = value;
        return value;
    }

    // Обработка ввода цены
    priceInput.addEventListener('input', function(e) {
        validatePrice(this);
    });

    // Обработка вставки цены
    priceInput.addEventListener('paste', function(e) {
        e.preventDefault();
        
        // Получаем текст из буфера обмена
        const pastedText = (e.clipboardData || window.clipboardData).getData('text');
        
        // Проверяем, является ли вставленное значение числом
        if (!isNaN(parseFloat(pastedText)) && isFinite(pastedText)) {
            // Если это число, вставляем его
            this.value = parseFloat(pastedText).toFixed(2);
        } else {
            // Если не число, очищаем поле
            this.value = '';
            showPriceError('Можно вводить только цифры и точку');
        }
    });

    // Проверка цены при отправке формы
    form.addEventListener('submit', function(e) {
        const priceValue = priceInput.value.trim();
        
        if (!priceValue) {
            e.preventDefault();
            showPriceError('Введите цену');
            priceInput.focus();
            return false;
        }
        
        const priceNum = parseFloat(priceValue);
        
        if (isNaN(priceNum)) {
            e.preventDefault();
            showPriceError('Неверный формат цены');
            priceInput.focus();
            return false;
        }
        
        if (priceNum < 0) {
            e.preventDefault();
            showPriceError('Цена не может быть отрицательной');
            priceInput.focus();
            return false;
        }
        
        if (priceNum > 10000) {
            e.preventDefault();
            showPriceError('Цена не может превышать 10,000$');
            priceInput.focus();
            return false;
        }
        
        // Форматируем цену до 2 знаков после запятой
        priceInput.value = priceNum.toFixed(2);
        
        // Остальные проверки...
        const modelFile = modelFileInput.files[0];
        const imageFile = imageFileInput.files[0];
        const category = document.querySelector('input[name="category"]:checked');
        
        // Проверка категории
        if (!category) {
            e.preventDefault();
            alert('Пожалуйста, выберите категорию для модели');
            return false;
        }

        // Проверка номера телефона
        const phoneRegex = /^8[0-9]{10}$/;
        if (!phoneRegex.test(phoneInput.value)) {
            e.preventDefault();
            alert('Введите корректный казахстанский номер телефона (8XXXXXXXXXX)');
            phoneInput.focus();
            return false;
        }

        // Проверка email
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        if (!emailRegex.test(emailInput.value)) {
            e.preventDefault();
            alert('Введите корректный email адрес');
            emailInput.focus();
            return false;
        }

        // Проверка Telegram
        const telegramRegex = /^(@[a-zA-Z0-9_]{5,32}|[a-zA-Z0-9_]{5,32})$/;
        if (!telegramRegex.test(telegramInput.value)) {
            e.preventDefault();
            alert('Введите корректный Telegram username (5-32 символа, только буквы, цифры и _)');
            telegramInput.focus();
            return false;
        }

        // Проверка файлов
        if (modelFile && modelFile.size > 100 * 1024 * 1024) {
            e.preventDefault();
            alert('Файл 3D модели слишком большой! Максимальный размер: 100MB');
            return false;
        }
        
        if (imageFile && imageFile.size > 2 * 1024 * 1024) {
            e.preventDefault();
            alert('Изображение слишком большое! Максимальный размер: 2MB');
            return false;
        }
        
        // Блокируем кнопку отправки
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Загрузка...';
    });

    // Функция показа ошибки цены
    function showPriceError(message) {
        // Создаем элемент ошибки если его нет
        let errorElement = document.querySelector('.price-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.className = 'price-error';
            priceInput.parentNode.appendChild(errorElement);
        }
        
        errorElement.textContent = message;
        errorElement.style.display = 'block';
        
        // Автоматически скрываем ошибку через 5 секунд
        setTimeout(() => {
            errorElement.style.display = 'none';
        }, 5000);
    }

    // Drag and drop functionality
    [imageUploadArea, modelUploadArea].forEach((area, index) => {
        const fileInput = index === 0 ? imageFileInput : modelFileInput;
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            area.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            area.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            area.addEventListener(eventName, unhighlight, false);
        });

        function highlight() {
            area.style.borderColor = '#FF6B35';
            area.style.background = 'rgba(255, 107, 53, 0.1)';
        }

        function unhighlight() {
            area.style.borderColor = '#e0e0e0';
            area.style.background = '#f8f9fa';
        }

        area.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            handleFileSelect(files[0], area);
        }
    });

    function handleFileSelect(file, area) {
        if (file) {
            const fileText = area.querySelector('.file-text');
            fileText.textContent = file.name;
            area.querySelector('.file-hint').textContent = `Размер: ${(file.size / 1024 / 1024).toFixed(2)} MB`;
        }
    }

    // Обработчики изменения файлов
    imageFileInput.addEventListener('change', function() {
        handleFileSelect(this.files[0], imageUploadArea);
    });

    modelFileInput.addEventListener('change', function() {
        const file = this.files[0];
        handleFileSelect(file, modelUploadArea);
        
        if (file) {
            fileInfo.innerHTML = `
                <strong>Выбран файл:</strong> ${file.name}<br>
                <strong>Размер:</strong> ${(file.size / 1024 / 1024).toFixed(2)} MB<br>
                <strong>Тип:</strong> ${file.type || 'не определен'}
            `;
        } else {
            fileInfo.innerHTML = '';
        }
    });

    // Форматирование номера телефона
    phoneInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        if (value.length > 0 && value[0] !== '8') {
            value = '8' + value.replace(/^8/, '');
        }
        
        if (value.length > 11) {
            value = value.substring(0, 11);
        }
        
        e.target.value = value;
    });

    // Валидация Telegram
    telegramInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/[^a-zA-Z0-9_@]/g, '');
        
        if (value.includes('@')) {
            value = '@' + value.replace(/@/g, '');
        }
        
        e.target.value = value;
    });

    // Убираем ошибку цены при фокусе
    priceInput.addEventListener('focus', function() {
        const errorElement = document.querySelector('.price-error');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    });
});
</script>
@endsection