@extends('layouts.app')
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Конвертер Моделей</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🔄</text></svg>">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/OBJLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/STLLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/GLTFLoader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/exporters/OBJExporter.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/exporters/GLTFExporter.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: #ffffff;
            color: #333333;
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .converter-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
        }
        
        .page-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: #FF6B35;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            color: #666666;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 400;
        }
        
        .card {
            background: #ffffff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.1);
            margin-bottom: 40px;
            border: 1px solid #FFE5DC;
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #FF6B35;
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.2s ease;
            text-decoration: none;
        }
        
        .btn:hover {
            background: #E55A2B;
            color: white;
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.15);
        }
        
        .btn:active {
            transform: scale(0.98);
        }
        
        .btn:disabled {
            background: #E0E0E0;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .btn-secondary {
            background: #4CAF50;
        }
        
        .btn-secondary:hover {
            background: #388E3C;
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.15);
        }
        
        .upload-area {
            border: 2px dashed #FF6B35;
            border-radius: 16px;
            padding: 40px 30px;
            text-align: center;
            margin-bottom: 30px;
        }
        
        .upload-btn {
            background: #FF6B35;
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .upload-btn:hover {
            background: #FFFFFF;
            color: #FF6B35;
            box-shadow: 0 0 0 4px rgba(255, 107, 53, 0.15);
        }
        
        .file-types {
            color: #666666;
            margin-top: 10px;
            font-size: 1rem;
        }
        
        .file-input {
            display: none;
        }
        
        .conversion-controls {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            align-items: center;
            justify-content: center;
            margin: 30px 0;
            padding: 25px;
            background: rgba(255, 107, 53, 0.03);
            border-radius: 16px;
            border: 1px solid rgba(255, 107, 53, 0.1);
        }
        
        .format-display {
            padding: 12px 24px;
            border: 2px solid #FF6B35;
            border-radius: 12px;
            font-size: 16px;
            background: white;
            font-weight: 600;
            color: #FF6B35;
            text-align: center;
            min-width: 120px;
        }
        
        .format-select-wrapper {
            position: relative;
            display: inline-block;
        }
        
        .format-select {
            padding: 12px 24px;
            padding-right: 50px;
            border: 2px solid #E0E0E0;
            border-radius: 12px;
            font-size: 16px;
            background: white;
            transition: all 0.3s;
            font-weight: 500;
            min-width: 180px;
            color: #333333;
            cursor: pointer;
            appearance: none;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .format-select:hover {
            border-color: #FF6B35;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.1);
        }
        
        .format-select:focus {
            outline: none;
            border-color: #FF6B35;
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
        }
        
        .format-select-arrow {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #FF6B35;
            font-size: 18px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .format-select:focus + .format-select-arrow {
            transform: translateY(-50%) rotate(90deg);
        }
        
        .conversion-arrow {
            font-size: 24px;
            color: #FF6B35;
            font-weight: bold;
        }
        
        .file-info {
            margin-top: 20px;
            padding: 25px;
            background: rgba(255, 107, 53, 0.03);
            border-radius: 16px;
            border: 1px solid rgba(255, 107, 53, 0.1);
            display: none;
        }
        
        .file-info.active {
            display: block;
            animation: fadeIn 0.4s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .file-info p {
            margin-bottom: 12px;
            font-size: 1rem;
            color: #333333;
            font-weight: 500;
        }
        
        .model-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 20px;
            padding: 25px;
            background: white;
            border-radius: 16px;
            border: 1px solid #FFE5DC;
            box-shadow: 0 5px 15px rgba(255, 107, 53, 0.05);
            display: none;
        }
        
        .stat-item {
            text-align: center;
            padding: 18px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.08) 0%, rgba(255, 142, 83, 0.08) 100%);
            border-radius: 12px;
            border: 1px solid rgba(255, 107, 53, 0.15);
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #666666;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }
        
        .stat-value {
            font-weight: 700;
            color: #FF6B35;
            font-size: 1.3rem;
        }
        
        .preview-container {
            margin-top: 30px;
            display: none;
        }
        
        .preview-container.active {
            display: block;
            animation: slideUp 0.5s ease;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .preview-canvas {
            width: 100%;
            height: 350px;
            border: 2px solid #FFE5DC;
            border-radius: 16px;
            background: #FAFAFA;
        }
        
        .download-section {
            margin-top: 30px;
            text-align: center;
            display: none;
            background: white;
            border-radius: 20px;
            padding: 40px;
            border: 2px solid #4CAF50;
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.15);
            animation: slideDown 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .download-section.active {
            display: block;
        }
        
        @keyframes slideDown {
            0% {
                opacity: 0;
                transform: translateY(-30px) scale(0.95);
            }
            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        
        .supported-formats {
            margin-top: 40px;
        }
        
        .supported-formats h2 {
            font-size: 2rem;
            margin-bottom: 30px;
            color: #333333;
            text-align: center;
            font-weight: 700;
        }
        
        .formats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }
        
        .format-card {
            background: white;
            border-radius: 18px;
            padding: 30px;
            border: 1px solid #FFE5DC;
            transition: all 0.3s ease;
        }
        
        .format-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 107, 53, 0.1);
            border-color: rgba(255, 107, 53, 0.3);
        }
        
        .format-card h3 {
            color: #333333;
            margin-bottom: 15px;
            font-size: 1.3rem;
            font-weight: 700;
        }
        
        .format-card p {
            color: #666666;
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        /* Стили для опций селекта */
        .format-select option {
            padding: 12px;
            background: white;
            color: #333333;
            font-size: 15px;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        
        .format-select option:hover,
        .format-select option:checked {
            background: #FF6B35;
            color: white;
        }
        
        @media (max-width: 1024px) {
            .formats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 2.2rem;
            }
            
            .card {
                padding: 25px 20px;
            }
            
            .upload-area {
                padding: 30px 20px;
            }
            
            .conversion-controls {
                flex-direction: column;
                padding: 20px;
                gap: 15px;
            }
            
            .format-select, .format-display {
                width: 100%;
                min-width: unset;
            }
            
            .model-stats {
                grid-template-columns: 1fr;
                padding: 20px;
            }
            
            .formats-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .preview-canvas {
                height: 300px;
            }
            
            .btn {
                width: 100%;
            }
        }
        
        @media (max-width: 480px) {
            .upload-area {
                padding: 25px 15px;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .page-subtitle {
                font-size: 1rem;
            }
            
            .supported-formats h2 {
                font-size: 1.6rem;
            }
            
            .format-card {
                padding: 25px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- <header class="converter-header">
            <h1 class="page-title">Convert 3D models</h1>
            <p class="page-subtitle">High-quality conversion between popular formats</p>
        </header> -->
        
        <main>
            <section class="card">
                <div class="upload-area" id="uploadArea">
                    <button class="upload-btn" id="selectFileBtn">
                        Place 3D model
                    </button>
                    <p class="file-types">Supported formats: OBJ, STL, GLB, GLTF</p>
                    <input type="file" id="fileInput" class="file-input" accept=".obj,.stl,.glb,.gltf">
                </div>
                
                <div class="file-info" id="fileInfo">
                    <p><strong>Файл:</strong> <span id="fileName">-</span></p>
                    <p><strong>Размер:</strong> <span id="fileSize">-</span></p>
                    <p><strong>Формат:</strong> <span id="fileType">-</span></p>
                    <div class="model-stats" id="modelStats">
                        <div class="stat-item">
                            <div class="stat-label">Вершин</div>
                            <div class="stat-value" id="vertexCount">-</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Полигонов</div>
                            <div class="stat-value" id="faceCount">-</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-label">Материалы</div>
                            <div class="stat-value" id="materialCount">-</div>
                        </div>
                    </div>
                </div>
                
                <div class="conversion-controls">
                    <span style="color: #333333; font-weight: 600;">Из:</span>
                    <div class="format-display" id="sourceFormatDisplay">-</div>
                    
                    <span class="conversion-arrow">→</span>
                    
                    <div class="format-select-wrapper">
                        <select id="toFormat" class="format-select" disabled>
                            <option value="">В формат...</option>
                            <option value="obj">OBJ</option>
                            <option value="stl">STL</option>
                            <option value="glb">GLB</option>
                            <option value="gltf">GLTF</option>
                        </select>
                        <span class="format-select-arrow">▶</span>
                    </div>
                    
                    <button class="btn btn-secondary" id="convertBtn" disabled>
                        Конвертировать
                    </button>
                </div>
                
                <div class="preview-container" id="previewContainer">
                    <canvas class="preview-canvas" id="previewCanvas"></canvas>
                </div>
                
                <div class="download-section" id="downloadSection">
                    <h3 style="color: #4CAF50; margin-bottom: 20px; font-size: 1.5rem;">Конвертация завершена</h3>
                    <p style="color: #333333; margin-bottom: 25px; font-size: 1.1rem;">Ваша модель успешно конвертирована</p>
                    <button class="btn" id="downloadBtn" style="background: #FF6B35;">
                        Скачать файл
                    </button>
                </div>
            </section>
            
            <section class="supported-formats card">
                <h2>Поддерживаемые форматы</h2>
                <div class="formats-grid">
                    <div class="format-card">
                        <h3>Формат OBJ</h3>
                        <p>Стандартный 3D формат с поддержкой материалов и текстур. Совместим с большинством 3D программ и игровых движков.</p>
                    </div>
                    <div class="format-card">
                        <h3>Формат STL</h3>
                        <p>Формат оптимизированный для 3D печати. Содержит только геометрические данные без материалов и текстур.</p>
                    </div>
                    <div class="format-card">
                        <h3>Форматы GLB/GLTF</h3>
                        <p>Современные 3D форматы поддерживающие материалы, текстуры, анимации и PBR рендеринг. Идеальны для веб и real-time приложений.</p>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('fileInput');
            const selectFileBtn = document.getElementById('selectFileBtn');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const fileType = document.getElementById('fileType');
            const sourceFormatDisplay = document.getElementById('sourceFormatDisplay');
            const modelStats = document.getElementById('modelStats');
            const vertexCount = document.getElementById('vertexCount');
            const faceCount = document.getElementById('faceCount');
            const materialCount = document.getElementById('materialCount');
            const toFormat = document.getElementById('toFormat');
            const convertBtn = document.getElementById('convertBtn');
            const previewContainer = document.getElementById('previewContainer');
            const previewCanvas = document.getElementById('previewCanvas');
            const downloadSection = document.getElementById('downloadSection');
            const downloadBtn = document.getElementById('downloadBtn');
            const formatSelectArrow = document.querySelector('.format-select-arrow');
            
            let scene, renderer, camera;
            let loadedModel = null;
            let originalModelForExport = null;
            let currentFile = null;
            let convertedFile = null;
            let currentFileExtension = '';
            let selectFocused = false;
            
            function initThreeJS() {
                scene = new THREE.Scene();
                scene.background = new THREE.Color(0xfafafa);
                camera = new THREE.PerspectiveCamera(75, previewCanvas.clientWidth / previewCanvas.clientHeight, 0.1, 1000);
                renderer = new THREE.WebGLRenderer({ 
                    canvas: previewCanvas, 
                    antialias: true,
                    alpha: true
                });
                renderer.setSize(previewCanvas.clientWidth, previewCanvas.clientHeight);
                renderer.setPixelRatio(window.devicePixelRatio);
                
                camera.position.z = 5;
                
                const light1 = new THREE.DirectionalLight(0xffffff, 1.2);
                light1.position.set(2, 2, 2);
                scene.add(light1);
                
                const light2 = new THREE.DirectionalLight(0xffffff, 0.6);
                light2.position.set(-2, -1, 1);
                scene.add(light2);
                
                const ambientLight = new THREE.AmbientLight(0x404040, 0.8);
                scene.add(ambientLight);
                
                animate();
            }
            
            function animate() {
                requestAnimationFrame(animate);
                if (loadedModel) {
                    loadedModel.rotation.y += 0.005;
                }
                renderer.render(scene, camera);
            }
            
            // Фикс двойного вызова
            let fileInputClicked = false;
            
            selectFileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (!fileInputClicked) {
                    fileInputClicked = true;
                    fileInput.click();
                    setTimeout(() => {
                        fileInputClicked = false;
                    }, 100);
                }
            });
            
            fileInput.addEventListener('change', function(e) {
                if (e.target.files.length) {
                    handleFile(e.target.files[0]);
                }
            });
            
            // Анимация стрелки при фокусе и потере фокуса
            toFormat.addEventListener('focus', () => {
                selectFocused = true;
                formatSelectArrow.style.transform = 'translateY(-50%) rotate(90deg)';
            });
            
            toFormat.addEventListener('blur', () => {
                selectFocused = false;
                formatSelectArrow.style.transform = 'translateY(-50%) rotate(0deg)';
            });
            
            // Возврат стрелки при клике вне селекта
            document.addEventListener('click', (e) => {
                if (!e.target.closest('.format-select-wrapper') && selectFocused) {
                    toFormat.blur();
                }
            });
            
            toFormat.addEventListener('change', updateConvertButtonState);
            convertBtn.addEventListener('click', convertFile);
            downloadBtn.addEventListener('click', downloadConvertedFile);
            
            function handleFile(file) {
                const maxSize = 50 * 1024 * 1024;
                if (file.size > maxSize) {
                    alert('Файл слишком большой (максимум 50MB)');
                    return;
                }
                
                currentFileExtension = file.name.split('.').pop().toLowerCase();
                const supportedFormats = ['obj', 'stl', 'glb', 'gltf'];
                
                if (!supportedFormats.includes(currentFileExtension)) {
                    alert('Неподдерживаемый формат');
                    return;
                }
                
                currentFile = file;
                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                fileType.textContent = currentFileExtension.toUpperCase();
                sourceFormatDisplay.textContent = currentFileExtension.toUpperCase();
                
                fileInfo.classList.add('active');
                modelStats.style.display = 'none';
                updateToFormatOptions();
                previewContainer.classList.remove('active');
                downloadSection.classList.remove('active');
                
                loadModelToScene(file, scene, true)
                    .then(() => {
                        previewContainer.classList.add('active');
                    })
                    .catch(error => {
                        alert(`Ошибка: ${error.message}`);
                    });
                
                updateConvertButtonState();
            }
            
            function updateToFormatOptions() {
                toFormat.value = '';
                while (toFormat.options.length > 0) {
                    toFormat.remove(0);
                }
                
                const emptyOption = document.createElement('option');
                emptyOption.value = '';
                emptyOption.textContent = 'В формат...';
                toFormat.appendChild(emptyOption);
                
                const allFormats = ['obj', 'stl', 'glb', 'gltf'];
                allFormats.forEach(format => {
                    if (format !== currentFileExtension) {
                        const option = document.createElement('option');
                        option.value = format;
                        option.textContent = format.toUpperCase();
                        toFormat.appendChild(option);
                    }
                });
                
                toFormat.disabled = false;
            }
            
            async function loadModelToScene(file, scene, isOriginal = true) {
                const loader = getLoader(currentFileExtension);
                if (!loader) {
                    throw new Error(`Не поддерживается формат .${currentFileExtension}`);
                }
                
                const url = URL.createObjectURL(file);
                
                return new Promise((resolve, reject) => {
                    if (currentFileExtension === 'gltf' || currentFileExtension === 'glb') {
                        loader.load(url, 
                            (gltf) => {
                                try {
                                    cleanupScene(scene);
                                    const model = gltf.scene;
                                    if (isOriginal) {
                                        originalModelForExport = gltf.scene.clone(true);
                                    }
                                    scene.add(model);
                                    model.traverse((child) => {
                                        if (child.isMesh && !child.material) {
                                            child.material = new THREE.MeshStandardMaterial({ 
                                                color: 0xFF6B35,
                                                roughness: 0.6,
                                                metalness: 0.4
                                            });
                                        }
                                    });
                                    centerAndScaleModelForDisplay(model);
                                    calculateModelStats(model);
                                    if (isOriginal) {
                                        loadedModel = model;
                                    }
                                    URL.revokeObjectURL(url);
                                    resolve(model);
                                } catch (error) {
                                    URL.revokeObjectURL(url);
                                    reject(error);
                                }
                            },
                            undefined,
                            (error) => {
                                URL.revokeObjectURL(url);
                                reject(new Error(`Ошибка загрузки: ${error.message}`));
                            }
                        );
                    } else if (currentFileExtension === 'stl') {
                        loader.load(url, 
                            (geometry) => {
                                try {
                                    cleanupScene(scene);
                                    if (!geometry.attributes || !geometry.attributes.position) {
                                        throw new Error('Некорректная геометрия');
                                    }
                                    const material = new THREE.MeshStandardMaterial({ 
                                        color: 0xFF6B35,
                                        roughness: 0.6,
                                        metalness: 0.4
                                    });
                                    const mesh = new THREE.Mesh(geometry, material);
                                    if (isOriginal) {
                                        originalModelForExport = mesh.clone();
                                    }
                                    scene.add(mesh);
                                    centerAndScaleModelForDisplay(mesh);
                                    calculateModelStats(mesh);
                                    if (isOriginal) {
                                        loadedModel = mesh;
                                    }
                                    URL.revokeObjectURL(url);
                                    resolve(mesh);
                                } catch (error) {
                                    URL.revokeObjectURL(url);
                                    reject(error);
                                }
                            },
                            undefined,
                            (error) => {
                                URL.revokeObjectURL(url);
                                reject(new Error(`Ошибка загрузки: ${error.message}`));
                            }
                        );
                    } else if (currentFileExtension === 'obj') {
                        loader.load(url, 
                            (group) => {
                                try {
                                    cleanupScene(scene);
                                    if (isOriginal) {
                                        originalModelForExport = group.clone(true);
                                    }
                                    scene.add(group);
                                    centerAndScaleModelForDisplay(group);
                                    calculateModelStats(group);
                                    if (isOriginal) {
                                        loadedModel = group;
                                    }
                                    URL.revokeObjectURL(url);
                                    resolve(group);
                                } catch (error) {
                                    URL.revokeObjectURL(url);
                                    reject(error);
                                }
                            },
                            undefined,
                            (error) => {
                                URL.revokeObjectURL(url);
                                reject(new Error(`Ошибка загрузки: ${error.message}`));
                            }
                        );
                    }
                });
            }
            
            function cleanupScene(scene) {
                const objectsToRemove = [];
                scene.traverse((child) => {
                    if (!child.isLight && !child.isCamera) {
                        objectsToRemove.push(child);
                    }
                });
                
                objectsToRemove.forEach(obj => {
                    if (obj.parent) {
                        obj.parent.remove(obj);
                    }
                    if (obj.geometry) {
                        obj.geometry.dispose();
                    }
                    if (obj.material) {
                        if (Array.isArray(obj.material)) {
                            obj.material.forEach(mat => mat.dispose());
                        } else {
                            obj.material.dispose();
                        }
                    }
                });
            }
            
            function centerAndScaleModelForDisplay(model) {
                const box = new THREE.Box3().setFromObject(model);
                const center = box.getCenter(new THREE.Vector3());
                const size = box.getSize(new THREE.Vector3());
                
                model.userData.originalPosition = model.position.clone();
                model.userData.originalScale = model.scale.clone();
                model.userData.originalRotation = model.rotation.clone();
                
                model.position.x = -center.x;
                model.position.y = -center.y;
                model.position.z = -center.z;
                
                const maxDim = Math.max(size.x, size.y, size.z);
                const scale = maxDim > 0 ? 2.5 / maxDim : 1;
                model.scale.multiplyScalar(scale);
                
                if (model.scale.x < 0.1 || model.scale.y < 0.1 || model.scale.z < 0.1) {
                    model.scale.multiplyScalar(10);
                }
            }
            
            function calculateModelStats(model) {
                let vertices = 0;
                let faces = 0;
                let materials = new Set();
                
                model.traverse((child) => {
                    if (child.isMesh) {
                        const geometry = child.geometry;
                        if (geometry && geometry.attributes && geometry.attributes.position) {
                            vertices += geometry.attributes.position.count;
                        }
                        if (geometry && geometry.index) {
                            faces += geometry.index.count / 3;
                        } else if (geometry && geometry.attributes && geometry.attributes.position) {
                            faces += geometry.attributes.position.count / 3;
                        }
                        
                        if (child.material) {
                            if (Array.isArray(child.material)) {
                                child.material.forEach(mat => {
                                    materials.add(mat.type || 'Material');
                                });
                            } else {
                                materials.add(child.material.type || 'Material');
                            }
                        }
                    }
                });
                
                vertexCount.textContent = vertices.toLocaleString();
                faceCount.textContent = faces.toLocaleString();
                materialCount.textContent = materials.size;
                modelStats.style.display = 'grid';
            }
            
            function getLoader(format) {
                switch(format) {
                    case 'obj': return new THREE.OBJLoader();
                    case 'stl': return new THREE.STLLoader();
                    case 'gltf':
                    case 'glb': return new THREE.GLTFLoader();
                    default: return null;
                }
            }
            
            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }
            
            function updateConvertButtonState() {
                const to = toFormat.value;
                convertBtn.disabled = !(to && to !== currentFileExtension);
            }
            
            function convertFile() {
                if (!currentFile || !loadedModel) {
                    alert('Модель не загружена');
                    return;
                }
                
                const to = toFormat.value;
                if (!to || to === currentFileExtension) {
                    alert('Выберите другой формат');
                    return;
                }
                
                convertBtn.disabled = true;
                toFormat.disabled = true;
                
                convertModel(originalModelForExport || loadedModel, to)
                    .then(convertedData => {
                        const convertedFileName = currentFile.name.replace(`.${currentFileExtension}`, `.${to}`);
                        convertedFile = new File([convertedData], convertedFileName, { 
                            type: getMimeType(to) 
                        });
                        
                        downloadSection.classList.add('active');
                    })
                    .catch(error => {
                        alert(`Ошибка: ${error.message}`);
                    })
                    .finally(() => {
                        convertBtn.disabled = false;
                        toFormat.disabled = false;
                    });
            }
            
            function convertModel(model, targetFormat) {
                return new Promise((resolve, reject) => {
                    try {
                        const exportModel = model.clone(true);
                        exportModel.updateMatrixWorld(true);
                        
                        switch(targetFormat) {
                            case 'obj':
                                const objExporter = new THREE.OBJExporter();
                                const objResult = objExporter.parse(exportModel);
                                resolve(new Blob([objResult], { type: 'text/plain' }));
                                break;
                                
                            case 'stl':
                                const stlString = exportToSTL(exportModel);
                                resolve(new Blob([stlString], { type: 'application/octet-stream' }));
                                break;
                                
                            case 'gltf':
                                const gltfExporter = new THREE.GLTFExporter();
                                gltfExporter.parse(exportModel, (gltf) => {
                                    const jsonString = JSON.stringify(gltf, null, 2);
                                    resolve(new Blob([jsonString], { type: 'model/gltf+json' }));
                                }, { 
                                    binary: false,
                                    trs: false,
                                    onlyVisible: true
                                });
                                break;
                                
                            case 'glb':
                                const glbExporter = new THREE.GLTFExporter();
                                glbExporter.parse(exportModel, (glb) => {
                                    resolve(glb);
                                }, { 
                                    binary: true,
                                    trs: false,
                                    onlyVisible: true
                                });
                                break;
                                
                            default:
                                reject(new Error('Неподдерживаемый формат'));
                        }
                    } catch (error) {
                        reject(error);
                    }
                });
            }
            
            function exportToSTL(scene) {
                let stlData = "solid Exported_Model\n";
                let triangleCount = 0;
                
                const rotationMatrix = new THREE.Matrix4();
                rotationMatrix.makeRotationX(-Math.PI / 2);
                
                const allVertices = [];
                const allIndices = [];
                let vertexOffset = 0;
                
                scene.traverse((child) => {
                    if (child.isMesh && child.geometry) {
                        const geometry = child.geometry;
                        const clonedGeometry = geometry.clone();
                        clonedGeometry.applyMatrix4(child.matrixWorld);
                        clonedGeometry.applyMatrix4(rotationMatrix);
                        
                        const positions = clonedGeometry.attributes.position;
                        const vertexCount = positions.count;
                        
                        let indices;
                        if (clonedGeometry.index) {
                            indices = clonedGeometry.index;
                        } else {
                            const tempIndices = [];
                            for (let i = 0; i < vertexCount; i += 3) {
                                if (i + 2 < vertexCount) {
                                    tempIndices.push(i, i + 1, i + 2);
                                }
                            }
                            indices = { array: tempIndices, count: tempIndices.length };
                        }
                        
                        for (let i = 0; i < vertexCount; i++) {
                            const vertex = new THREE.Vector3(
                                positions.getX(i),
                                positions.getY(i),
                                positions.getZ(i)
                            );
                            allVertices.push(vertex);
                        }
                        
                        for (let i = 0; i < indices.count; i++) {
                            allIndices.push(indices.array[i] + vertexOffset);
                        }
                        
                        vertexOffset += vertexCount;
                    }
                });
                
                for (let i = 0; i < allIndices.length; i += 3) {
                    const i1 = allIndices[i];
                    const i2 = allIndices[i + 1];
                    const i3 = allIndices[i + 2];
                    
                    if (i1 >= allVertices.length || i2 >= allVertices.length || i3 >= allVertices.length) {
                        continue;
                    }
                    
                    const v1 = allVertices[i1];
                    const v2 = allVertices[i2];
                    const v3 = allVertices[i3];
                    
                    const edge1 = new THREE.Vector3().subVectors(v2, v1);
                    const edge2 = new THREE.Vector3().subVectors(v3, v1);
                    const normal = new THREE.Vector3()
                        .crossVectors(edge1, edge2)
                        .normalize();
                    
                    if (isNaN(normal.x) || isNaN(normal.y) || isNaN(normal.z)) {
                        normal.set(0, 0, 1);
                    }
                    
                    const formatNumber = (num) => {
                        const val = parseFloat(num);
                        if (Math.abs(val) < 0.000001) return '0.000000';
                        return val.toFixed(6);
                    };
                    
                    stlData += `  facet normal ${formatNumber(normal.x)} ${formatNumber(normal.y)} ${formatNumber(normal.z)}\n`;
                    stlData += "    outer loop\n";
                    stlData += `      vertex ${formatNumber(v1.x)} ${formatNumber(v1.y)} ${formatNumber(v1.z)}\n`;
                    stlData += `      vertex ${formatNumber(v2.x)} ${formatNumber(v2.y)} ${formatNumber(v2.z)}\n`;
                    stlData += `      vertex ${formatNumber(v3.x)} ${formatNumber(v3.y)} ${formatNumber(v3.z)}\n`;
                    stlData += "    endloop\n";
                    stlData += "  endfacet\n";
                    
                    triangleCount++;
                }
                
                stlData += "endsolid Exported_Model\n";
                return stlData;
            }
            
            function getMimeType(format) {
                const mimeTypes = {
                    'obj': 'text/plain',
                    'stl': 'application/sla',
                    'glb': 'model/gltf-binary',
                    'gltf': 'model/gltf+json'
                };
                return mimeTypes[format] || 'application/octet-stream';
            }
            
            function downloadConvertedFile() {
                if (!convertedFile) {
                    alert('Нет файла для скачивания');
                    return;
                }
                
                const url = URL.createObjectURL(convertedFile);
                const a = document.createElement('a');
                a.href = url;
                a.download = convertedFile.name;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
            }
            
            window.addEventListener('resize', () => {
                renderer.setSize(previewCanvas.clientWidth, previewCanvas.clientHeight);
                camera.aspect = previewCanvas.clientWidth / previewCanvas.clientHeight;
                camera.updateProjectionMatrix();
            });
            
            initThreeJS();
        });
    </script>
</body>
</html>