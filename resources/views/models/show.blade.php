@extends('layouts.app')

@section('title', $model->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- Хлебные крошки -->
            <nav class="breadcrumb-nav">
                <a href="{{ route('models.index') }}" class="breadcrumb-link">Мои модели</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">{{ $model->name }}</span>
            </nav>

            <!-- Кнопки управления для владельца модели -->
            @if(Auth::id() === $model->user_id)
            <div class="model-actions">
                <a href="{{ route('models.edit', $model) }}" class="btn-action btn-edit">
                    <i class="fas fa-edit"></i>
                    Редактировать
                </a>
                <button type="button" class="btn-action btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash"></i>
                    Удалить
                </button>
            </div>
            @endif

            <div class="model-detail-grid">
                <!-- Левая колонка - информация о модели -->
                <div class="model-info-section">
                    <div class="upload-card">
                        <div class="upload-header">
                            <h2 class="upload-title">{{ $model->name }}</h2>
                            <p class="upload-subtitle">Детальная информация о 3D модели</p>
                        </div>

                        <div class="upload-body">
                            <div class="model-preview-container">
                                <img src="{{ Storage::url($model->image_path) }}" 
                                     alt="{{ $model->name }}"
                                     class="model-preview-image">
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Имя модели</label>
                                    <div class="form-display">{{ $model->name }}</div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Цена ($)</label>
                                    <div class="form-display price">${{ number_format($model->price, 2) }}</div>
                                </div>
                            </div>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">Номер телефона</label>
                                    <div class="form-display">
                                        <a href="tel:{{ $model->phone }}" class="contact-link">
                                            {{ $model->phone }}
                                        </a>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <div class="form-display">
                                        <a href="mailto:{{ $model->email }}" class="contact-link">
                                            {{ $model->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Telegram контакт</label>
                                <div class="form-display">
                                    <a href="https://t.me/{{ ltrim($model->telegram, '@') }}" 
                                       target="_blank" class="contact-link">
                                        {{ $model->telegram }}
                                    </a>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Категория</label>
                                <div class="category-display">
                                    <div class="category-badge category-{{ $model->category }}">
                                        @switch($model->category)
                                            @case('architecture')
                                                <i class="fas fa-building"></i> Архитектура
                                                @break
                                            @case('design')
                                                <i class="fas fa-palette"></i> Дизайн
                                                @break
                                            @case('science')
                                                <i class="fas fa-flask"></i> Научные
                                                @break
                                            @case('entertainment')
                                                <i class="fas fa-gamepad"></i> Развлекательные
                                                @break
                                            @default
                                                <i class="fas fa-cube"></i> Другое
                                        @endswitch
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Описание модели</label>
                                <div class="form-display description">
                                    {{ $model->description }}
                                </div>
                            </div>

                            <div class="model-meta-info">
                                <div class="meta-grid">
                                    <div class="meta-item">
                                        <i class="fas fa-user"></i>
                                        <div>
                                            <strong>Автор</strong>
                                            <span>{{ $model->user->name }}</span>
                                        </div>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-plus"></i>
                                        <div>
                                            <strong>Добавлено</strong>
                                            <span>{{ $model->created_at->format('d.m.Y H:i') }}</span>
                                        </div>
                                    </div>
                                    @if($model->updated_at != $model->created_at)
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-check"></i>
                                        <div>
                                            <strong>Обновлено</strong>
                                            <span>{{ $model->updated_at->format('d.m.Y H:i') }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Правая колонка - 3D просмотр -->
                <div class="model-viewer-section">
                    <div class="upload-card">
                        <div class="upload-header">
                            <h2 class="upload-title">
                                <i class="fas fa-cube"></i>
                                3D Просмотр
                            </h2>
                            <p class="upload-subtitle">Интерактивный просмотр модели</p>
                        </div>

                        <div class="upload-body">
                            <div class="viewer-wrapper">
                                <div class="viewer-container" id="viewerContainer">
                                    <div id="modelViewer" class="model-viewer-universal">
                                        <div class="viewer-loading" id="viewerLoading">
                                            <div class="loading-spinner"></div>
                                            <p>Загрузка 3D модели...</p>
                                        </div>
                                        <div class="viewer-error" id="viewerError" style="display: none;">
                                            <i class="fas fa-exclamation-triangle"></i>
                                            <p>Не удалось загрузить модель для просмотра</p>
                                            <p class="error-detail" id="errorDetail"></p>
                                        </div>
                                        <canvas id="modelCanvas" style="width: 100%; height: 100%; display: none;"></canvas>
                                    </div>
                                </div>
                                
                                <!-- Информация о файле -->
                                <div class="file-info-panel">
                                    <div class="file-info-item">
                                        <strong>Формат:</strong>
                                        <span class="file-format">{{ strtoupper(pathinfo($model->model_path, PATHINFO_EXTENSION)) }}</span>
                                    </div>
                                    <div class="file-info-item">
                                        <strong>Размер:</strong>
                                        <span class="file-size">
                                            @php
                                                $filePath = storage_path('app/public/' . $model->model_path);
                                                $fileSize = file_exists($filePath) ? filesize($filePath) : 0;
                                            @endphp
                                            {{ number_format($fileSize / 1024 / 1024, 2) }} MB
                                        </span>
                                    </div>
                                    <div class="file-info-item">
                                        <strong>Статус:</strong>
                                        <span class="file-status" id="fileStatus">Проверка...</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="viewer-actions">
                                <a href="{{ Storage::url($model->model_path) }}" 
                                   class="btn btn-primary btn-download" 
                                   download="{{ $model->name }}{{ '.'.pathinfo($model->model_path, PATHINFO_EXTENSION) }}">
                                    <i class="fas fa-download"></i>
                                    Скачать модель
                                </a>
                                <a href="{{ route('models.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    Назад к списку
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно подтверждения удаления -->
@if(Auth::id() === $model->user_id)
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Подтверждение удаления</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Вы уверены, что хотите удалить модель <strong>"{{ $model->name }}"</strong>?</p>
                <p class="text-danger">Это действие нельзя отменить! Будут удалены все файлы модели.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <form action="{{ route('models.destroy', $model) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Да, удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Подключаем Three.js и загрузчики для GLB, GLTF, OBJ и STL -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/OBJLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/MTLLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/STLLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>

<style>
/* Стили остаются такими же, как в вашем коде */
.breadcrumb-nav { display: flex; align-items: center; gap: 10px; margin-bottom: 30px; padding: 15px 0; border-bottom: 1px solid #e0e0e0; flex-wrap: wrap; }
.breadcrumb-link { color: #FF6B35; text-decoration: none; font-weight: 500; transition: color 0.3s; }
.breadcrumb-link:hover { color: #e55a2b; }
.breadcrumb-separator { color: #666; }
.breadcrumb-current { color: #333; font-weight: 600; }
.model-actions { display: flex; gap: 15px; justify-content: flex-end; margin-bottom: 30px; flex-wrap: wrap; }
.btn-action { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: 600; transition: all 0.3s; border: 2px solid; font-size: 0.95rem; cursor: pointer; }
.btn-edit { background: #f8f9fa; color: #FF6B35; border-color: #FF6B35; }
.btn-edit:hover { background: #FF6B35; color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3); }
.btn-delete { background: #f8f9fa; color: #dc3545; border-color: #dc3545; }
.btn-delete:hover { background: #dc3545; color: white; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3); }
.model-detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; align-items: start; }
@media (max-width: 992px) { .model-detail-grid { grid-template-columns: 1fr; gap: 20px; } }
.upload-card { background: #ffffff; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1); overflow: hidden; margin-bottom: 0; }
.upload-header { background: linear-gradient(135deg, #FF6B35 0%, #4CAF50 100%); color: white; padding: 25px 30px; text-align: center; }
.upload-title { font-size: 1.8rem; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; justify-content: center; gap: 10px; }
.upload-subtitle { font-size: 1rem; opacity: 0.9; }
.upload-body { padding: 25px; }
.model-preview-container { width: 100%; margin-bottom: 20px; border-radius: 15px; overflow: hidden; border: 2px solid #e0e0e0; }
.model-preview-image { width: 100%; height: 250px; object-fit: cover; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
@media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } }
.form-group { margin-bottom: 15px; }
.form-label { display: block; font-weight: 600; margin-bottom: 6px; color: #333; font-size: 0.95rem; }
.form-display { background: #f8f9fa; border: 2px solid #e0e0e0; border-radius: 12px; padding: 12px 16px; font-size: 0.95rem; color: #333; min-height: 48px; display: flex; align-items: center; word-break: break-word; }
.form-display.price { font-size: 1.1rem; font-weight: 700; color: #FF6B35; }
.form-display.description { line-height: 1.6; white-space: pre-wrap; min-height: 80px; align-items: flex-start; }
.contact-link { color: #FF6B35; text-decoration: none; font-weight: 500; transition: color 0.3s; word-break: break-all; }
.contact-link:hover { color: #e55a2b; text-decoration: underline; }
.category-display { margin-top: 8px; }
.category-badge { display: inline-flex; align-items: center; gap: 8px; padding: 10px 16px; border-radius: 20px; font-weight: 600; font-size: 0.9rem; }
.category-architecture { background: rgba(255, 107, 53, 0.1); color: #FF6B35; border: 2px solid #FF6B35; }
.category-design { background: rgba(76, 175, 80, 0.1); color: #4CAF50; border: 2px solid #4CAF50; }
.category-science { background: rgba(33, 150, 243, 0.1); color: #2196F3; border: 2px solid #2196F3; }
.category-entertainment { background: rgba(156, 39, 176, 0.1); color: #9C27B0; border: 2px solid #9C27B0; }
.category-other { background: rgba(158, 158, 158, 0.1); color: #9E9E9E; border: 2px solid #9E9E9E; }
.model-meta-info { margin-top: 20px; padding-top: 20px; border-top: 2px solid #e0e0e0; }
.meta-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; }
.meta-item { display: flex; align-items: center; gap: 12px; padding: 12px; background: #f8f9fa; border-radius: 10px; transition: all 0.3s; }
.meta-item:hover { background: #e9ecef; transform: translateY(-1px); }
.meta-item i { font-size: 1.2rem; color: #FF6B35; width: 24px; text-align: center; }
.meta-item div { display: flex; flex-direction: column; gap: 4px; }
.meta-item strong { font-size: 0.8rem; color: #666; }
.meta-item span { font-weight: 600; color: #333; font-size: 0.9rem; }
.viewer-wrapper { width: 100%; margin-bottom: 20px; }
.viewer-container { width: 100%; height: 400px; background: #f8f9fa; border-radius: 15px; overflow: hidden; border: 2px solid #e0e0e0; position: relative; }
.model-viewer-universal { width: 100%; height: 100%; position: relative; display: flex; align-items: center; justify-content: center; }
.viewer-loading { text-align: center; color: #666; }
.loading-spinner { width: 40px; height: 40px; border: 4px solid #f3f3f3; border-top: 4px solid #FF6B35; border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 15px; }
@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
.viewer-error { text-align: center; color: #dc3545; padding: 20px; }
.viewer-error i { font-size: 3rem; margin-bottom: 15px; display: block; }
.error-detail { font-size: 0.9rem; color: #666; margin-top: 10px; }
.file-info-panel { display: flex; gap: 20px; margin-top: 15px; padding: 15px; background: #f8f9fa; border-radius: 10px; border: 1px solid #e0e0e0; flex-wrap: wrap; }
.file-info-item { display: flex; align-items: center; gap: 8px; font-size: 0.9rem; }
.file-info-item strong { color: #333; }
.file-format { background: #FF6B35; color: white; padding: 4px 8px; border-radius: 6px; font-weight: 600; font-size: 0.8rem; }
.file-size { color: #666; font-weight: 500; }
.file-status { font-weight: 600; }
.viewer-actions { display: flex; flex-direction: column; gap: 12px; }
.btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 14px 25px; border-radius: 30px; text-decoration: none; font-weight: 600; transition: all 0.3s; border: none; cursor: pointer; font-size: 0.95rem; text-align: center; width: 100%; }
.btn-primary { background-color: #FF6B35; color: white; }
.btn-primary:hover { background-color: #e55a2b; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(255, 107, 53, 0.3); }
.btn-secondary { background-color: #6c757d; color: white; }
.btn-secondary:hover { background-color: #5a6268; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3); }
.btn-download { padding: 14px 25px; }
.modal-content { border-radius: 15px; border: none; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2); }
.modal-header { background: linear-gradient(135deg, #FF6B35 0%, #4CAF50 100%); color: white; border-bottom: none; border-radius: 15px 15px 0 0; padding: 20px 25px; }
.modal-title { font-weight: 600; margin: 0; }
.modal-body { padding: 25px; }
.modal-footer { border-top: 1px solid #e0e0e0; padding: 20px 25px; border-radius: 0 0 15px 15px; }
.modal-footer .btn { width: auto; min-width: 120px; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modelPath = "{{ Storage::url($model->model_path) }}";
    const fileExtension = "{{ pathinfo($model->model_path, PATHINFO_EXTENSION) }}".toLowerCase();
    const viewerContainer = document.getElementById('viewerContainer');
    const modelCanvas = document.getElementById('modelCanvas');
    const viewerLoading = document.getElementById('viewerLoading');
    const viewerError = document.getElementById('viewerError');
    const errorDetail = document.getElementById('errorDetail');
    const fileStatus = document.getElementById('fileStatus');

    let scene, camera, renderer, controls, model;

    // Проверяем доступность файла
    async function checkFileAvailability() {
        try {
            fileStatus.textContent = 'Проверка файла...';
            const response = await fetch(modelPath, { method: 'HEAD' });
            
            if (!response.ok) {
                throw new Error(`Файл недоступен: ${response.status} ${response.statusText}`);
            }
            
            const contentLength = response.headers.get('content-length');
            if (!contentLength || parseInt(contentLength) === 0) {
                throw new Error('Файл пустой или поврежден');
            }
            
            fileStatus.textContent = 'Файл доступен';
            fileStatus.style.color = '#28a745';
            return true;
            
        } catch (error) {
            fileStatus.textContent = 'Файл недоступен';
            fileStatus.style.color = '#dc3545';
            showError(`Ошибка доступа к файлу: ${error.message}`);
            return false;
        }
    }

    // Проверяем поддержку форматов (GLB, GLTF, OBJ, STL)
    function checkFormatSupport() {
        const supportedFormats = ['glb', 'gltf', 'obj', 'stl'];
        
        if (!supportedFormats.includes(fileExtension)) {
            showError(`Формат .${fileExtension} не поддерживается. Поддерживаемые форматы: ${supportedFormats.join(', ')}`);
            return false;
        }
        
        return true;
    }

    // Инициализация Three.js сцены
    function initThreeJS() {
        try {
            // Создаем сцену
            scene = new THREE.Scene();
            scene.background = new THREE.Color(0xf8f9fa);
            
            // Создаем камеру
            const aspect = viewerContainer.clientWidth / viewerContainer.clientHeight;
            camera = new THREE.PerspectiveCamera(45, aspect, 0.1, 1000);
            camera.position.set(0, 0, 5);
            
            // Создаем рендерер
            renderer = new THREE.WebGLRenderer({ 
                canvas: modelCanvas,
                antialias: true,
                alpha: true
            });
            renderer.setSize(viewerContainer.clientWidth, viewerContainer.clientHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            
            // Освещение
            const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
            scene.add(ambientLight);
            
            const directionalLight = new THREE.DirectionalLight(0xffffff, 0.8);
            directionalLight.position.set(5, 5, 5);
            scene.add(directionalLight);
            
            const directionalLight2 = new THREE.DirectionalLight(0xffffff, 0.4);
            directionalLight2.position.set(-5, -5, -5);
            scene.add(directionalLight2);
            
            // Контролы
            controls = new THREE.OrbitControls(camera, renderer.domElement);
            controls.enableDamping = true;
            controls.dampingFactor = 0.05;
            controls.screenSpacePanning = false;
            controls.minDistance = 0.5;
            controls.maxDistance = 20;
            
            // Показываем canvas
            modelCanvas.style.display = 'block';
            return true;
            
        } catch (error) {
            console.error('Ошибка инициализации Three.js:', error);
            showError(`Ошибка инициализации 3D просмотрщика: ${error.message}`);
            return false;
        }
    }

    // Центрирование модели
    function centerModel() {
        if (!model) return;

        try {
            const box = new THREE.Box3().setFromObject(model);
            const center = box.getCenter(new THREE.Vector3());
            const size = box.getSize(new THREE.Vector3());

            // Центрируем модель
            model.position.x = -center.x;
            model.position.y = -center.y;
            model.position.z = -center.z;

            // Вычисляем оптимальное расстояние камеры
            const maxDim = Math.max(size.x, size.y, size.z);
            const fov = camera.fov * (Math.PI / 180);
            
            let cameraDistance = maxDim > 0 ? Math.abs(maxDim / (2 * Math.tan(fov / 2))) * 1.5 : 5;
            cameraDistance = Math.max(2, Math.min(cameraDistance, 15));
            
            camera.position.set(0, 0, cameraDistance);
            camera.near = 0.1;
            camera.far = Math.max(100, cameraDistance * 5);
            camera.updateProjectionMatrix();

            controls.target.set(0, 0, 0);
            controls.minDistance = maxDim * 0.8;
            controls.maxDistance = cameraDistance * 4;
            controls.update();

        } catch (error) {
            console.error('Ошибка центрирования модели:', error);
        }
    }

    // Автоматическое масштабирование
    function autoScaleModel() {
        if (!model) return;

        try {
            const box = new THREE.Box3().setFromObject(model);
            const size = box.getSize(new THREE.Vector3());
            const maxDim = Math.max(size.x, size.y, size.z);
            
            let scale = 1;
            if (maxDim > 10) {
                scale = 10 / maxDim;
            } else if (maxDim < 0.1) {
                scale = 0.1 / maxDim;
            }
            
            if (scale !== 1) {
                model.scale.set(scale, scale, scale);
            }
        } catch (error) {
            console.error('Ошибка масштабирования модели:', error);
        }
    }

    // Загрузка моделей
    function loadModel() {
        if (!initThreeJS()) return;

        switch(fileExtension) {
            case 'glb':
            case 'gltf':
                loadGLTFModel();
                break;
            case 'obj':
                loadOBJModel();
                break;
            case 'stl':
                loadSTLModel();
                break;
            default:
                showError(`Формат .${fileExtension} не поддерживается для просмотра`);
                break;
        }
    }

    function loadGLTFModel() {
        const loader = new THREE.GLTFLoader();
        
        loader.load(
            modelPath,
            function(gltf) {
                try {
                    model = gltf.scene;
                    autoScaleModel();
                    
                    model.traverse(function(child) {
                        if (child.isMesh) {
                            child.castShadow = true;
                            child.receiveShadow = true;
                        }
                    });
                    
                    scene.add(model);
                    centerModel();
                    viewerLoading.style.display = 'none';
                    animate();
                    fileStatus.textContent = 'Модель загружена';
                    fileStatus.style.color = '#28a745';
                    
                } catch (error) {
                    console.error('Ошибка обработки GLTF:', error);
                    showError(`Ошибка обработки GLTF модели: ${error.message}`);
                }
            },
            function(progress) {
                const percent = progress.lengthComputable 
                    ? (progress.loaded / progress.total * 100).toFixed(2)
                    : '0';
                viewerLoading.querySelector('p').textContent = `Загрузка 3D модели... ${percent}%`;
            },
            function(error) {
                console.error('Ошибка загрузки GLTF:', error);
                showError(`Ошибка загрузки GLTF модели: ${error.message}`);
            }
        );
    }

    function loadOBJModel() {
        const loader = new THREE.OBJLoader();
        
        loader.load(
            modelPath,
            function(object) {
                try {
                    model = object;
                    autoScaleModel();
                    
                    // Создаем базовый материал для OBJ
                    model.traverse(function(child) {
                        if (child.isMesh) {
                            child.material = new THREE.MeshPhongMaterial({ 
                                color: 0x888888,
                                shininess: 30
                            });
                            child.castShadow = true;
                            child.receiveShadow = true;
                        }
                    });
                    
                    scene.add(model);
                    centerModel();
                    viewerLoading.style.display = 'none';
                    animate();
                    fileStatus.textContent = 'Модель загружена';
                    fileStatus.style.color = '#28a745';
                    
                } catch (error) {
                    console.error('Ошибка обработки OBJ:', error);
                    showError(`Ошибка обработки OBJ модели: ${error.message}`);
                }
            },
            function(progress) {
                const percent = progress.lengthComputable 
                    ? (progress.loaded / progress.total * 100).toFixed(2)
                    : '0';
                viewerLoading.querySelector('p').textContent = `Загрузка OBJ модели... ${percent}%`;
            },
            function(error) {
                console.error('Ошибка загрузки OBJ:', error);
                showError(`Ошибка загрузки OBJ модели: ${error.message}`);
            }
        );
    }

    function loadSTLModel() {
        const loader = new THREE.STLLoader();
        
        loader.load(
            modelPath,
            function(geometry) {
                try {
                    // Создаем материал для STL модели
                    const material = new THREE.MeshPhongMaterial({ 
                        color: 0x888888,
                        specular: 0x111111,
                        shininess: 30,
                        flatShading: true
                    });
                    
                    // Создаем mesh из geometry и material
                    model = new THREE.Mesh(geometry, material);
                    
                    // Настраиваем модель
                    model.castShadow = true;
                    model.receiveShadow = true;
                    
                    autoScaleModel();
                    scene.add(model);
                    centerModel();
                    viewerLoading.style.display = 'none';
                    animate();
                    fileStatus.textContent = 'Модель загружена';
                    fileStatus.style.color = '#28a745';
                    
                } catch (error) {
                    console.error('Ошибка обработки STL:', error);
                    showError(`Ошибка обработки STL модели: ${error.message}`);
                }
            },
            function(progress) {
                const percent = progress.lengthComputable 
                    ? (progress.loaded / progress.total * 100).toFixed(2)
                    : '0';
                viewerLoading.querySelector('p').textContent = `Загрузка STL модели... ${percent}%`;
            },
            function(error) {
                console.error('Ошибка загрузки STL:', error);
                showError(`Ошибка загрузки STL модели: ${error.message}`);
            }
        );
    }

    function showError(message) {
        viewerLoading.style.display = 'none';
        viewerError.style.display = 'flex';
        if (message) {
            errorDetail.textContent = message;
        }
        fileStatus.textContent = 'Ошибка загрузки';
        fileStatus.style.color = '#dc3545';
    }

    function animate() {
        if (!renderer || !scene || !camera) return;
        
        requestAnimationFrame(animate);
        
        if (controls) {
            controls.update();
        }
        
        renderer.render(scene, camera);
    }

    // Обработка ресайза
    function handleResize() {
        if (camera && renderer && viewerContainer) {
            camera.aspect = viewerContainer.clientWidth / viewerContainer.clientHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(viewerContainer.clientWidth, viewerContainer.clientHeight);
        }
    }

    // Инициализация
    async function initialize() {
        try {
            // Проверяем доступность файла
            const fileAvailable = await checkFileAvailability();
            if (!fileAvailable) return;
            
            // Проверяем поддержку формата
            const formatSupported = checkFormatSupport();
            if (!formatSupported) return;
            
            // Загружаем модель
            loadModel();
            
        } catch (error) {
            console.error('Ошибка инициализации:', error);
            showError(`Ошибка инициализации: ${error.message}`);
        }
    }

    // Запускаем инициализацию
    initialize();

    // Обработчики событий
    window.addEventListener('resize', handleResize);
});
</script>