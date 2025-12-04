@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 m-0 vh-100">
    <div class="d-flex h-100">
        <!-- Панель управления слева -->
        <div class="controls-panel">
            <h1 class="main-title">3D Генератор Текста</h1>
            
            <div class="controls">
                <!-- Основные настройки -->
                <div class="control-group">
                    <h3>Основные Настройки</h3>
                    <div class="control-row">
                        <label><span class="icon">T</span> Текст:</label>
                        <input type="text" id="textInput" placeholder="Введите текст..." value="HELLO">
                    </div>
                    <div class="control-row">
                        <label><span class="icon">S</span> Размер:</label>
                        <div class="control-inputs">
                            <input type="range" id="size" min="0.5" max="3" step="0.1" value="1.5">
                            <input type="number" id="sizeValue" value="1.5" step="0.1" min="0.5" max="3">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">H</span> Толщина:</label>
                        <div class="control-inputs">
                            <input type="range" id="height" min="0.1" max="2" step="0.1" value="0.5">
                            <input type="number" id="heightValue" value="0.5" step="0.1" min="0.1" max="2">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">L</span> Расстояние:</label>
                        <div class="control-inputs">
                            <input type="range" id="spacing" min="0.5" max="2" step="0.1" value="1">
                            <input type="number" id="spacingValue" value="1" step="0.1" min="0.5" max="2">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">B</span> Сглаживание:</label>
                        <div class="control-inputs">
                            <input type="range" id="bevel" min="0" max="0.2" step="0.01" value="0.05">
                            <input type="number" id="bevelValue" value="0.05" step="0.01" min="0" max="0.2">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">M</span> Блеск:</label>
                        <div class="control-inputs">
                            <input type="range" id="metallic" min="0" max="1" step="0.1" value="0.5">
                            <input type="number" id="metallicValue" value="0.5" step="0.1" min="0" max="1">
                        </div>
                    </div>
                </div>

                <!-- Раскраска -->
                <div class="control-group">
                    <h3>Раскраска</h3>
                    <div class="control-row">
                        <label><span class="icon">P</span> Цвет:</label>
                        <div class="color-picker-container">
                            <div class="color-display" style="background: #ff6600;">
                                <input type="color" id="colorInput" value="#ff6600">
                            </div>
                        </div>
                    </div>
                    
                    <div class="color-section-title">Быстрые палитры</div>
                    <div class="color-palette">
                        <div class="color-option active" style="background: #ff6600;" data-color="#ff6600"></div>
                        <div class="color-option" style="background: #ff3366;" data-color="#ff3366"></div>
                        <div class="color-option" style="background: #3366ff;" data-color="#3366ff"></div>
                        <div class="color-option" style="background: #33cc66;" data-color="#33cc66"></div>
                        <div class="color-option" style="background: #ffcc00;" data-color="#ffcc00"></div>
                        <div class="color-option" style="background: #9933ff;" data-color="#9933ff"></div>
                        <div class="color-option" style="background: #ff3300;" data-color="#ff3300"></div>
                    </div>
                </div>

                <!-- Поворот -->
                <div class="control-group">
                    <h3>Поворот</h3>
                    <div class="control-hint">Градусы (0-360)</div>
                    <div class="control-row">
                        <label><span class="icon">X</span> X:</label>
                        <div class="control-inputs">
                            <input type="range" id="rotationX" min="0" max="360" step="1" value="0">
                            <input type="number" id="rotationXValue" value="0" min="0" max="360">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">Y</span> Y:</label>
                        <div class="control-inputs">
                            <input type="range" id="rotationY" min="0" max="360" step="1" value="0">
                            <input type="number" id="rotationYValue" value="0" min="0" max="360">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">Z</span> Z:</label>
                        <div class="control-inputs">
                            <input type="range" id="rotationZ" min="0" max="360" step="1" value="0">
                            <input type="number" id="rotationZValue" value="0" min="0" max="360">
                        </div>
                    </div>
                </div>

                <!-- Деформации -->
                <div class="control-group">
                    <h3>Деформации</h3>
                    <div class="control-hint">Все эффекты работают одновременно</div>
                    <div class="control-row">
                        <label><span class="icon">B</span> Изгиб:</label>
                        <div class="control-inputs">
                            <input type="range" id="bend" min="-3" max="3" step="0.1" value="0">
                            <input type="number" id="bendValue" value="0" step="0.1" min="-3" max="3">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">📐</span> Сгиб:</label>
                        <div class="control-inputs">
                            <input type="range" id="fold" min="-2" max="2" step="0.1" value="0">
                            <input type="number" id="foldValue" value="0" step="0.1" min="-2" max="2">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">🌊</span> Волна X:</label>
                        <div class="control-inputs">
                            <input type="range" id="waveX" min="0" max="3" step="0.1" value="0">
                            <input type="number" id="waveXValue" value="0" step="0.1" min="0" max="3">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">🌊</span> Волна Y:</label>
                        <div class="control-inputs">
                            <input type="range" id="waveY" min="0" max="3" step="0.1" value="0">
                            <input type="number" id="waveYValue" value="0" step="0.1" min="0" max="3">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">🌀</span> Спираль:</label>
                        <div class="control-inputs">
                            <input type="range" id="spiral" min="-2" max="2" step="0.1" value="0">
                            <input type="number" id="spiralValue" value="0" step="0.1" min="-2" max="2">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">⚡</span> Искажение:</label>
                        <div class="control-inputs">
                            <input type="range" id="twist" min="0" max="2" step="0.1" value="0">
                            <input type="number" id="twistValue" value="0" step="0.1" min="0" max="2">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">💧</span> Пузырь:</label>
                        <div class="control-inputs">
                            <input type="range" id="bubble" min="0" max="1" step="0.1" value="0">
                            <input type="number" id="bubbleValue" value="0" step="0.1" min="0" max="1">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">📏</span> Сжатие X:</label>
                        <div class="control-inputs">
                            <input type="range" id="squashX" min="0.1" max="2" step="0.1" value="1">
                            <input type="number" id="squashXValue" value="1" step="0.1" min="0.1" max="2">
                        </div>
                    </div>
                    <div class="control-row">
                        <label><span class="icon">📏</span> Сжатие Y:</label>
                        <div class="control-inputs">
                            <input type="range" id="squashY" min="0.1" max="2" step="0.1" value="1">
                            <input type="number" id="squashYValue" value="1" step="0.1" min="0.1" max="2">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Панель просмотра справа -->
        <div class="preview-panel">
            <!-- Заголовок и кнопки экспорта в одной строке -->
            <div class="preview-header">
                <div class="preview-title">Доступные форматы  </div>
                <div class="export-buttons">
                    <button id="downloadGLTF">GLTF</button>
                    <button id="downloadGLB">GLB</button>
                    <button id="downloadOBJ">OBJ</button>
                    <button id="downloadSTL">STL</button>
                </div>
            </div>
            
            <div id="loading" class="loading">Загрузка 3D библиотеки...</div>
            <div id="canvasContainer"></div>
        </div>
    </div>
</div>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body { 
    margin: 0; 
    font-family: 'Inter', 'Segoe UI', system-ui, sans-serif; 
    background: white;
    color: #ff6600; 
    overflow: hidden;
    height: 100vh;
}

.container-fluid {
    height: 100vh;
    overflow: hidden;
}

.d-flex {
    display: flex;
    height: 100vh;
    padding: 20px;
    gap: 20px;
    max-width: 1800px;
    margin: 0 auto;
}

.controls-panel {
    width: 500px;
    background: white;
    padding: 30px;
    border-radius: 25px;
    box-shadow: 
        0 15px 35px rgba(0, 0, 0, 0.1),
        0 5px 15px rgba(0, 0, 0, 0.05);
    overflow-y: auto;
    border: 1px solid rgba(255, 102, 0, 0.1);
    flex-shrink: 0;
}

.preview-panel {
    flex: 1;
    display: flex;
    flex-direction: column;
    min-width: 0;
    gap: 15px;
}

/* Заголовок и кнопки в одной строке */
.preview-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 10px;
    flex-shrink: 0;
    min-height: 60px;
}

.controls { 
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.control-group { 
    background: #f8f9fa; 
    padding: 25px; 
    border-radius: 20px; 
    border: 1px solid rgba(255, 102, 0, 0.1);
    box-shadow: 
        0 5px 15px rgba(0, 0, 0, 0.05);
    position: relative;
    overflow: hidden;
}

.control-group::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: #ff6600;
    border-radius: 20px 20px 0 0;
}

.control-group h3 { 
    margin: 0 0 20px 0; 
    font-size: 15px; 
    color: #ff6600; 
    text-align: center;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    position: relative;
}

.control-group h3::after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 2px;
    background: #ff6600;
}

.control-row {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 16px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255, 102, 0, 0.08);
    transition: all 0.3s ease;
}

.control-row:hover {
    background: rgba(255, 102, 0, 0.04);
    border-radius: 12px;
    margin-left: -8px;
    margin-right: -8px;
    padding-left: 8px;
    padding-right: 8px;
}

.control-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
}

.control-row label {
    min-width: 130px;
    font-size: 14px;
    font-weight: 700;
    color: #ff6600;
    display: flex;
    align-items: center;
    gap: 8px;
}

.control-inputs {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
}

.control-row input[type="range"] {
    flex: 1;
    height: 8px;
    background: #e9ecef;
    border-radius: 10px;
    outline: none;
    border: none;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    -webkit-appearance: none;
}

.control-row input[type="range"]:hover {
    background: #dee2e6;
}

.control-row input[type="number"] {
    width: 80px;
    padding: 10px 12px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    text-align: center;
    font-size: 14px;
    font-weight: 700;
    background: white;
    color: #ff6600;
    transition: all 0.3s ease;
}

.control-row input[type="number"]:focus {
    border-color: #ff6600;
    box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.1);
    outline: none;
}

.color-picker-container {
    display: flex;
    align-items: center;
    gap: 15px;
}

.color-display {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 3px solid #e9ecef;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    background: #ff6600;
    position: relative;
    overflow: hidden;
}

.color-display:hover {
    transform: scale(1.05);
    border-color: #ff6600;
}

#colorInput {
    opacity: 0;
    position: absolute;
    width: 60px;
    height: 60px;
    cursor: pointer;
}

.control-row input[type="text"] {
    flex: 1;
    padding: 12px 14px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 15px;
    background: white;
    color: #ff6600;
    transition: all 0.3s ease;
}

.control-row input[type="text"]:focus {
    border-color: #ff6600;
    box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.1);
    outline: none;
}

.control-row select {
    flex: 1;
    padding: 12px 14px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 14px;
    background: white;
    color: #ff6600;
    transition: all 0.3s ease;
    cursor: pointer;
    font-weight: 600;
}

.control-row select:focus {
    border-color: #ff6600;
    box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.1);
    outline: none;
}

#canvasContainer { 
    flex: 1; 
    background: white; 
    border: 2px solid #e9ecef; 
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    min-height: 300px;
    position: relative;
    overflow: hidden;
}

/* Кнопки экспорта рядом с заголовком */
.export-buttons {
    display: flex;
    gap: 12px;
    flex-shrink: 0;
}

.export-buttons button { 
    background: #ff6600; 
    color: white; 
    border: none; 
    padding: 12px 18px; 
    border-radius: 10px; 
    cursor: pointer; 
    font-size: 14px; 
    font-weight: 700;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
    min-width: 80px;
    white-space: nowrap;
}

.export-buttons button:hover { 
    background: #ff5500; 
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 102, 0, 0.4);
}

.export-buttons button:active {
    transform: translateY(0);
}

.loading { 
    color: #ff6600; 
    font-size: 18px; 
    margin: 20px; 
    text-align: center;
    font-weight: 600;
}

.control-hint {
    font-size: 12px;
    color: #6c757d;
    text-align: center;
    margin-top: 8px;
    line-height: 1.4;
    font-style: italic;
}

.preview-title {
    color: #ff6600;
    font-weight: 700;
    font-size: 20px;
    white-space: nowrap;
}

.main-title {
    text-align: center;
    margin-bottom: 30px;
    color: #ff6600;
    font-size: 26px;
    font-weight: 800;
}

/* Стили для ползунков */
input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 24px;
    height: 24px;
    background: white;
    border: 3px solid #ff6600;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
}

input[type="range"]::-webkit-slider-thumb:hover {
    transform: scale(1.15);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
}

input[type="range"]::-moz-range-thumb {
    width: 24px;
    height: 24px;
    background: white;
    border: 3px solid #ff6600;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    border: none;
}

/* Скрываем скроллбар */
.controls-panel::-webkit-scrollbar {
    width: 8px;
}

.controls-panel::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.controls-panel::-webkit-scrollbar-thumb {
    background: #ff6600;
    border-radius: 10px;
}

.controls-panel::-webkit-scrollbar-thumb:hover {
    background: #ff5500;
}

/* Анимация появления */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.control-group {
    animation: fadeInUp 0.6s ease-out;
}

.control-group:nth-child(1) { animation-delay: 0.1s; }
.control-group:nth-child(2) { animation-delay: 0.2s; }
.control-group:nth-child(3) { animation-delay: 0.3s; }
.control-group:nth-child(4) { animation-delay: 0.4s; }

/* Стили для цветовых палитр */
.color-palette {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
    justify-content: center;
}

.color-option {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}

.color-option:hover {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.color-option.active {
    border-color: #ff6600;
    transform: scale(1.15);
    box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.3);
}

.color-section-title {
    text-align: center;
    margin: 15px 0 10px;
    font-size: 14px;
    font-weight: 700;
    color: #ff6600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Стили для иконок */
.icon {
    font-size: 16px;
    width: 20px;
    text-align: center;
}

/* АДАПТИВНОСТЬ ДЛЯ ТЕЛЕФОНОВ */
@media (max-width: 768px) {
    .container-fluid {
        height: 100vh;
        overflow: hidden;
        padding: 10px;
    }
    
    .d-flex {
        flex-direction: column;
        height: 100vh;
        padding: 10px;
        gap: 10px;
    }
    
    .controls-panel {
        width: 100%;
        height: 45vh;
        padding: 15px;
        order: 2;
        overflow-y: auto;
    }
    
    .preview-panel {
        order: 1;
        height: 50vh;
        gap: 10px;
    }
    
    .preview-header {
        flex-direction: column;
        gap: 10px;
        padding: 0;
        align-items: stretch;
    }
    
    .export-buttons {
        width: 100%;
        justify-content: center;
    }
    
    .export-buttons button {
        flex: 1;
        min-width: 70px;
        padding: 10px 12px;
        font-size: 12px;
    }
    
    .control-row {
        flex-direction: column;
        align-items: stretch;
        gap: 10px;
        padding: 12px 0;
    }
    
    .control-row label {
        min-width: auto;
        justify-content: center;
        font-size: 16px;
    }
    
    .control-inputs {
        width: 100%;
    }
    
    .control-row input[type="range"] {
        height: 12px;
    }
    
    .control-row input[type="number"] {
        width: 100%;
        font-size: 16px;
        padding: 12px;
    }
    
    input[type="range"]::-webkit-slider-thumb {
        width: 28px;
        height: 28px;
    }
    
    .color-display {
        width: 70px;
        height: 70px;
    }
    
    #colorInput {
        width: 70px;
        height: 70px;
    }
    
    .color-option {
        width: 40px;
        height: 40px;
    }
    
    #canvasContainer {
        height: calc(100% - 120px);
        min-height: 200px;
    }
    
    .main-title {
        font-size: 20px;
        margin-bottom: 20px;
    }
    
    .preview-title {
        font-size: 18px;
        text-align: center;
    }
    
    .control-group {
        padding: 20px 15px;
    }
    
    .control-group h3 {
        font-size: 14px;
    }
}

/* Для очень маленьких экранов */
@media (max-width: 480px) {
    .controls-panel {
        padding: 12px;
        height: 40vh;
    }
    
    .preview-panel {
        height: 55vh;
    }
    
    .control-group {
        padding: 15px 12px;
    }
    
    .export-buttons button {
        min-width: 60px;
        padding: 8px 10px;
        font-size: 11px;
    }
    
    .color-palette {
        gap: 6px;
    }
    
    .color-option {
        width: 35px;
        height: 35px;
    }
    
    .main-title {
        font-size: 18px;
    }
}

/* Для горизонтальной ориентации телефона */
@media (max-height: 600px) and (orientation: landscape) {
    .controls-panel {
        height: 85vh;
    }
    
    .preview-panel {
        height: 85vh;
    }
    
    #canvasContainer {
        height: calc(100% - 80px);
    }
    
    .preview-header {
        min-height: 50px;
    }
}

/* Улучшенные ползунки для тач-устройств */
@media (hover: none) and (pointer: coarse) {
    .control-row input[type="range"] {
        height: 16px;
    }
    
    input[type="range"]::-webkit-slider-thumb {
        width: 32px;
        height: 32px;
    }
    
    .control-row:hover {
        background: transparent;
        margin-left: 0;
        margin-right: 0;
        padding-left: 0;
        padding-right: 0;
    }
}

/* Гарантируем что кнопки всегда видны на Mac */
@media (max-height: 800px) {
    .preview-panel {
        gap: 10px;
    }
    
    .preview-header {
        min-height: 50px;
    }
    
    .export-buttons button {
        padding: 10px 14px;
    }
    
    #canvasContainer {
        min-height: 300px;
    }
}

/* Для узких экранов */
@media (max-width: 1200px) {
    .preview-header {
        flex-wrap: wrap;
        gap: 10px;
    }
    
    .export-buttons {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .export-buttons button {
        min-width: 70px;
    }
}
</style>

<!-- Подключаем Three.js из CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/FontLoader.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/geometries/TextGeometry.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/exporters/GLTFExporter.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/exporters/OBJExporter.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/exporters/STLExporter.js"></script>

<script>
window.addEventListener('load', function() {
    document.getElementById('loading').style.display = 'none';
    init();
});

let scene, camera, renderer, controls, mesh;
let currentRotation = { x: 0, y: 0, z: 0 };
let currentDeformations = { 
    bend: 0, 
    fold: 0,
    waveX: 0, 
    waveY: 0, 
    spiral: 0, 
    twist: 0, 
    bubble: 0,
    squashX: 1,
    squashY: 1
};
let originalGeometry = null;
let letterSpacing = 1;

function init() {
    // Создание сцены
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xffffff);
    
    const container = document.getElementById('canvasContainer');
    
    // Создание камеры
    camera = new THREE.PerspectiveCamera(60, container.clientWidth / container.clientHeight, 0.1, 1000);
    camera.position.z = 12;
    camera.position.y = 4;
    
    // Создание рендерера
    renderer = new THREE.WebGLRenderer({ 
        antialias: true,
        alpha: true 
    });
    renderer.setSize(container.clientWidth, container.clientHeight);
    renderer.shadowMap.enabled = true;
    renderer.shadowMap.type = THREE.PCFSoftShadowMap;
    container.appendChild(renderer.domElement);
    
    // Орбитальные контролы
    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    
    // Освещение
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.7);
    scene.add(ambientLight);
    
    const directionalLight1 = new THREE.DirectionalLight(0xffffff, 0.9);
    directionalLight1.position.set(10, 10, 5);
    directionalLight1.castShadow = true;
    scene.add(directionalLight1);
    
    const directionalLight2 = new THREE.DirectionalLight(0xffaa88, 0.4);
    directionalLight2.position.set(-5, -5, -5);
    scene.add(directionalLight2);
    
    // Загрузка шрифта с поддержкой русского
    const fontLoader = new THREE.FontLoader();
    // Используем шрифт с поддержкой кириллицы
    fontLoader.load('https://threejs.org/examples/fonts/helvetiker_regular.typeface.json', function(font) {
        window.font = font;
        generateModel();
    }, undefined, function(error) {
        console.error('Ошибка загрузки шрифта:', error);
        // Создаем простую геометрию как запасной вариант
        createFallbackGeometry();
    });
    
    // Настройка связей между контролами
    setupControlLinks();
    
    // Обработчики событий
    window.addEventListener('resize', onWindowResize);
    document.getElementById('downloadGLTF').addEventListener('click', downloadGLTF);
    document.getElementById('downloadGLB').addEventListener('click', downloadGLB);
    document.getElementById('downloadOBJ').addEventListener('click', downloadOBJ);
    document.getElementById('downloadSTL').addEventListener('click', downloadSTL);
    
    // Обработчики для цветовых палитр
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(o => o.classList.remove('active'));
            this.classList.add('active');
            
            const color = this.getAttribute('data-color');
            document.getElementById('colorInput').value = color;
            updateColorDisplay(color);
            
            if (mesh && mesh.material) {
                mesh.material.color.setStyle(color);
                mesh.material.needsUpdate = true;
            }
        });
    });
    
    // Обработчик для цветового пикера
    document.getElementById('colorInput').addEventListener('input', function() {
        const color = this.value;
        updateColorDisplay(color);
        
        if (mesh && mesh.material) {
            mesh.material.color.setStyle(color);
            mesh.material.needsUpdate = true;
        }
    });
    
    // Блокировка ввода кириллицы
    document.getElementById('textInput').addEventListener('keypress', function(e) {
        // Разрешаем только латинские буквы, цифры и специальные символы
        const char = String.fromCharCode(e.keyCode || e.which);
        if (!/^[a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/? ]*$/.test(char)) {
            e.preventDefault();
            return false;
        }
    });
    
    // Блокировка вставки кириллицы
    document.getElementById('textInput').addEventListener('input', function(e) {
        const value = this.value;
        // Удаляем все кириллические символы
        const cleaned = value.replace(/[^a-zA-Z0-9!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/? ]/g, '');
        if (value !== cleaned) {
            this.value = cleaned;
        }
    });
    
    // Анимация
    animate();
}

function updateColorDisplay(color) {
    const display = document.querySelector('.color-display');
    display.style.background = color;
}

function setupControlLinks() {
    const controls = [
        'size', 'height', 'spacing', 'bevel', 'metallic',
        'rotationX', 'rotationY', 'rotationZ',
        'bend', 'fold', 'waveX', 'waveY', 'spiral', 'twist', 'bubble',
        'squashX', 'squashY'
    ];
    
    controls.forEach(control => {
        const slider = document.getElementById(control);
        const input = document.getElementById(control + 'Value');
        
        if (!slider || !input) return;
        
        // Связь ползунок -> число
        slider.addEventListener('input', function() {
            input.value = this.value;
            if (control === 'size' || control === 'height' || control === 'bevel' || control === 'spacing') {
                generateModel();
            } else {
                updateModel();
            }
        });
        
        // Связь число -> ползунок
        input.addEventListener('input', function() {
            let value = parseFloat(this.value) || 0;
            const min = parseFloat(slider.min);
            const max = parseFloat(slider.max);
            
            value = Math.max(min, Math.min(max, value));
            this.value = value;
            slider.value = value;
            
            if (control === 'size' || control === 'height' || control === 'bevel' || control === 'spacing') {
                generateModel();
            } else {
                updateModel();
            }
        });
        
        // Сброс по двойному клику
        input.addEventListener('dblclick', function() {
            const defaultValue = parseFloat(slider.getAttribute('value')) || 0;
            this.value = defaultValue;
            slider.value = defaultValue;
            
            if (control === 'size' || control === 'height' || control === 'bevel' || control === 'spacing') {
                generateModel();
            } else {
                updateModel();
            }
        });
    });
    
    // Отдельная обработка для текста
    document.getElementById('textInput').addEventListener('input', function() {
        generateModel();
    });
}

function updateModel() {
    if (!mesh) {
        generateModel();
        return;
    }
    
    // Обновляем поворот
    currentRotation.x = (document.getElementById('rotationX').value * Math.PI) / 180;
    currentRotation.y = (document.getElementById('rotationY').value * Math.PI) / 180;
    currentRotation.z = (document.getElementById('rotationZ').value * Math.PI) / 180;
    
    if (mesh) {
        mesh.rotation.x = currentRotation.x;
        mesh.rotation.y = currentRotation.y;
        mesh.rotation.z = currentRotation.z;
    }
    
    // Обновляем материал
    if (mesh && mesh.material) {
        const metallic = parseFloat(document.getElementById('metallic').value);
        mesh.material.metalness = metallic;
        mesh.material.needsUpdate = true;
    }
    
    // Обновляем деформации
    updateDeformations();
}

function updateDeformations() {
    if (!mesh || !originalGeometry) return;
    
    // Получаем значения всех деформаций
    currentDeformations.bend = parseFloat(document.getElementById('bend').value);
    currentDeformations.fold = parseFloat(document.getElementById('fold').value);
    currentDeformations.waveX = parseFloat(document.getElementById('waveX').value);
    currentDeformations.waveY = parseFloat(document.getElementById('waveY').value);
    currentDeformations.spiral = parseFloat(document.getElementById('spiral').value);
    currentDeformations.twist = parseFloat(document.getElementById('twist').value);
    currentDeformations.bubble = parseFloat(document.getElementById('bubble').value);
    currentDeformations.squashX = parseFloat(document.getElementById('squashX').value);
    currentDeformations.squashY = parseFloat(document.getElementById('squashY').value);
    
    // Создаем деформированную геометрию
    const deformedGeometry = originalGeometry.clone();
    const position = deformedGeometry.attributes.position;
    const bbox = originalGeometry.boundingBox;
    
    for (let i = 0; i < position.count; i++) {
        const x = position.getX(i);
        const y = position.getY(i);
        const z = position.getZ(i);
        
        let newX = x;
        let newY = y;
        let newZ = z;
        
        // Изгиб (bend) - параболический изгиб
        if (currentDeformations.bend !== 0) {
            const bendFactor = currentDeformations.bend * 0.8;
            newZ = z + bendFactor * x * x * 0.1;
        }
        
        // Сгиб (fold) - сгибание модели по центру
        if (currentDeformations.fold !== 0) {
            const foldFactor = currentDeformations.fold * 2;
            const centerX = (bbox.max.x + bbox.min.x) / 2;
            const distanceFromCenter = Math.abs(x - centerX);
            const maxDistance = Math.max(bbox.max.x - centerX, centerX - bbox.min.x);
            const foldAmount = (distanceFromCenter / maxDistance) * foldFactor;
            
            if (x > centerX) {
                // Правая сторона
                newZ = z + foldAmount;
            } else {
                // Левая сторона
                newZ = z - foldAmount;
            }
        }
        
        // Волна по X (waveX) - синусоида вдоль X
        if (currentDeformations.waveX !== 0) {
            const waveFactor = currentDeformations.waveX * 2;
            newZ = newZ + Math.sin(x * waveFactor) * 0.3;
        }
        
        // Волна по Y (waveY) - синусоида вдоль Y
        if (currentDeformations.waveY !== 0) {
            const waveFactor = currentDeformations.waveY * 2;
            newZ = newZ + Math.sin(y * waveFactor) * 0.3;
        }
        
        // Спираль (spiral) - закручивание вокруг оси Y
        if (currentDeformations.spiral !== 0) {
            const spiralFactor = currentDeformations.spiral * 1.5;
            const radius = Math.sqrt(x * x + z * z);
            const angle = y * spiralFactor;
            newX = x * Math.cos(angle) - z * Math.sin(angle);
            newZ = x * Math.sin(angle) + z * Math.cos(angle);
        }
        
        // Искажение (twist) - скручивание по оси Z
        if (currentDeformations.twist !== 0) {
            const twistFactor = currentDeformations.twist * 2;
            const angle = z * twistFactor;
            newX = x * Math.cos(angle) - y * Math.sin(angle);
            newY = x * Math.sin(angle) + y * Math.cos(angle);
        }
        
        // Пузырь (bubble) - сферическое искажение
        if (currentDeformations.bubble !== 0) {
            const bubbleFactor = currentDeformations.bubble * 0.5;
            const distance = Math.sqrt(x * x + y * y + z * z);
            const scale = 1 + bubbleFactor * Math.sin(distance * 3);
            newX = x * scale;
            newY = y * scale;
            newZ = z * scale;
        }
        
        // Сжатие по осям
        if (currentDeformations.squashX !== 1) {
            newX = x * currentDeformations.squashX;
        }
        
        if (currentDeformations.squashY !== 1) {
            newY = y * currentDeformations.squashY;
        }
        
        position.setXYZ(i, newX, newY, newZ);
    }
    
    position.needsUpdate = true;
    deformedGeometry.computeVertexNormals();
    
    // Заменяем геометрию
    mesh.geometry.dispose();
    mesh.geometry = deformedGeometry;
}

function onWindowResize() {
    const container = document.getElementById('canvasContainer');
    camera.aspect = container.clientWidth / container.clientHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(container.clientWidth, container.clientHeight);
}

function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}

function generateModel() {
    if (!window.font) {
        alert("Шрифт еще загружается...");
        return;
    }
    
    const text = document.getElementById('textInput').value || "HELLO";
    const size = parseFloat(document.getElementById('size').value);
    const height = parseFloat(document.getElementById('height').value);
    const bevelSize = parseFloat(document.getElementById('bevel').value);
    const color = document.getElementById('colorInput').value;
    const metallic = parseFloat(document.getElementById('metallic').value);
    letterSpacing = parseFloat(document.getElementById('spacing').value);
    
    // Удаляем старую модель
    if(mesh) {
        scene.remove(mesh);
        if (mesh.geometry) mesh.geometry.dispose();
        if (mesh.material) mesh.material.dispose();
    }
    
    try {
        // Создаем текстовую геометрию с учетом расстояния между буквами
        const textGeometry = createTextGeometryWithSpacing(text, {
            font: window.font,
            size: size,
            height: height,
            curveSegments: 12,
            bevelEnabled: true,
            bevelThickness: bevelSize,
            bevelSize: bevelSize,
            bevelOffset: 0,
            bevelSegments: 5
        });
        
        textGeometry.computeBoundingBox();
        textGeometry.center();
        
        // Сохраняем оригинальную геометрию
        originalGeometry = textGeometry.clone();
        
        // Создаем материал
        const material = new THREE.MeshPhysicalMaterial({ 
            color: color, 
            metalness: metallic,
            roughness: 0.3,
            clearcoat: 0.5,
            clearcoatRoughness: 0.1
        });
        
        mesh = new THREE.Mesh(textGeometry, material);
        mesh.castShadow = true;
        mesh.receiveShadow = true;
        
        // Применяем настройки
        updateModel();
        
        scene.add(mesh);
        
    } catch (error) {
        console.error("Ошибка создания текста:", error);
        alert("Ошибка при создании 3D текста. Попробуйте использовать более короткий текст.");
        createFallbackGeometry();
    }
}

function createTextGeometryWithSpacing(text, options) {
    // Создаем отдельную геометрию для каждой буквы
    const letters = text.split('');
    const geometries = [];
    
    let currentPosition = 0;
    
    for (let i = 0; i < letters.length; i++) {
        const letter = letters[i];
        
        // Создаем геометрию для текущей буквы
        const letterGeometry = new THREE.TextGeometry(letter, options);
        letterGeometry.computeBoundingBox();
        
        // Сдвигаем букву на нужную позицию
        const letterWidth = letterGeometry.boundingBox.max.x - letterGeometry.boundingBox.min.x;
        const shift = currentPosition + (letterWidth * (letterSpacing - 1) / 2);
        
        letterGeometry.translate(shift, 0, 0);
        
        // Обновляем текущую позицию для следующей буквы
        currentPosition += letterWidth * letterSpacing;
        
        geometries.push(letterGeometry);
    }
    
    // Объединяем все геометрии в одну
    if (geometries.length === 0) {
        return new THREE.BufferGeometry();
    }
    
    let mergedGeometry = geometries[0];
    
    for (let i = 1; i < geometries.length; i++) {
        mergedGeometry = THREE.BufferGeometryUtils.mergeBufferGeometries([mergedGeometry, geometries[i]]);
    }
    
    return mergedGeometry;
}

function createFallbackGeometry() {
    // Создаем простой куб как запасной вариант
    const geometry = new THREE.BoxGeometry(2, 1, 0.5);
    const material = new THREE.MeshPhysicalMaterial({ 
        color: document.getElementById('colorInput').value,
        metalness: parseFloat(document.getElementById('metallic').value),
        roughness: 0.3
    });
    
    mesh = new THREE.Mesh(geometry, material);
    scene.add(mesh);
}

function downloadGLTF() {
    if(!mesh) {
        alert("Сначала создайте модель!");
        return;
    }
    
    try {
        const exporter = new THREE.GLTFExporter();
        
        exporter.parse(mesh, function (result) {
            const gltfString = JSON.stringify(result);
            const blob = new Blob([gltfString], { type: 'model/gltf+json' });
            downloadBlob(blob, '3d-text.gltf');
        }, { binary: false });
        
    } catch (error) {
        console.error("Ошибка экспорта GLTF:", error);
        alert("Ошибка при экспорте GLTF файла.");
    }
}

function downloadGLB() {
    if(!mesh) {
        alert("Сначала создайте модель!");
        return;
    }
    
    try {
        const exporter = new THREE.GLTFExporter();
        
        exporter.parse(mesh, function (result) {
            const blob = new Blob([result], { type: 'model/gltf-binary' });
            downloadBlob(blob, '3d-text.glb');
        }, { binary: true });
        
    } catch (error) {
        console.error("Ошибка экспорта GLB:", error);
        alert("Ошибка при экспорте GLB файла.");
    }
}

function downloadOBJ() {
    if(!mesh) {
        alert("Сначала создайте модель!");
        return;
    }
    
    try {
        const exporter = new THREE.OBJExporter();
        const tempMesh = new THREE.Mesh(mesh.geometry);
        const objString = exporter.parse(tempMesh);
        
        const blob = new Blob([objString], { type: 'text/plain' });
        downloadBlob(blob, '3d-text.obj');
        
    } catch (error) {
        alert("Ошибка при экспорте OBJ: " + error.message);
    }
}

function downloadSTL() {
    if(!mesh) {
        alert("Сначала создайте модель!");
        return;
    }
    
    try {
        const exporter = new THREE.STLExporter();
        const stlString = exporter.parse(mesh);
        
        const blob = new Blob([stlString], { type: 'application/octet-stream' });
        downloadBlob(blob, '3d-text.stl');
        
    } catch (error) {
        alert("Ошибка при экспорте STL: " + error.message);
    }
}

function downloadBlob(blob, filename) {
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    URL.revokeObjectURL(url);
}

// Добавляем утилиты для объединения геометрий, если их нет
if (typeof THREE.BufferGeometryUtils === 'undefined') {
    THREE.BufferGeometryUtils = {
        mergeBufferGeometries: function(geometries) {
            // Простая реализация объединения геометрий
            const mergedGeometry = new THREE.BufferGeometry();
            const positions = [];
            const normals = [];
            const uvs = [];
            
            for (let i = 0; i < geometries.length; i++) {
                const geometry = geometries[i];
                const positionAttribute = geometry.getAttribute('position');
                const normalAttribute = geometry.getAttribute('normal');
                const uvAttribute = geometry.getAttribute('uv');
                
                for (let j = 0; j < positionAttribute.count; j++) {
                    positions.push(
                        positionAttribute.getX(j),
                        positionAttribute.getY(j),
                        positionAttribute.getZ(j)
                    );
                    
                    if (normalAttribute) {
                        normals.push(
                            normalAttribute.getX(j),
                            normalAttribute.getY(j),
                            normalAttribute.getZ(j)
                        );
                    }
                    
                    if (uvAttribute) {
                        uvs.push(
                            uvAttribute.getX(j),
                            uvAttribute.getY(j)
                        );
                    }
                }
            }
            
            mergedGeometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
            if (normals.length > 0) {
                mergedGeometry.setAttribute('normal', new THREE.Float32BufferAttribute(normals, 3));
            }
            if (uvs.length > 0) {
                mergedGeometry.setAttribute('uv', new THREE.Float32BufferAttribute(uvs, 2));
            }
            
            return mergedGeometry;
        }
    };
}
</script>
@endsection