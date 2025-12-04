<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Model3D;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Model3DController extends Controller
{
    public function index()
    {
        // Начинаем запрос для моделей текущего пользователя
        $query = Model3D::where('user_id', auth()->id());

        // Поиск по названию
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // Фильтр по категориям
        if (request('categories')) {
            $categories = is_array(request('categories')) 
                ? request('categories') 
                : explode(',', request('categories'));
            $query->whereIn('category', $categories);
        }

        // Фильтр по минимальной цене
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        // Фильтр по максимальной цене
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        // Сортировка
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Пагинация - 12 моделей на страницу
        $models = $query->paginate(12);

        // Статистика для отображения
        $totalPrice = $query->sum('price');
        $categoriesCount = $query->distinct()->count('category');

        return view('models.index', compact('models', 'totalPrice', 'categoriesCount'));
    }

    public function create()
    {
        return view('models.create');
    }

    public function store(Request $request)
    {
        Log::info('Store method started', ['files' => $request->allFiles()]);

        // Валидируем форму
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:50',
            'price' => 'required|numeric|min:0|max:10000',
            'category' => 'required|in:architecture,design,science,entertainment,other',
            'phone' => 'required|regex:/^8[0-9]{10}$/',
            'email' => 'required|email|max:255',
            'telegram' => 'required|string|min:5|max:32|regex:/^(@?[a-zA-Z0-9_]+)$/',
            'description' => 'required|string|min:10|max:500',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'model_file' => [
                'required',
                'file',
                'max:102400',
                function($attribute, $value, $fail) {
                    $allowedExtensions = ['obj', 'glb', 'gltf', 'stl'];
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (!in_array($ext, $allowedExtensions)) {
                        $fail('Разрешены только файлы 3D: ' . implode(', ', $allowedExtensions));
                    }
                }
            ],
        ]);

        try {
            // Проверяем файлы
            if (!$request->hasFile('model_file') || !$request->file('model_file')->isValid()) {
                Log::error('Model file invalid', ['file' => $request->file('model_file')]);
                return back()->with('error', 'Ошибка загрузки файла модели')->withInput();
            }

            if (!$request->hasFile('image') || !$request->file('image')->isValid()) {
                Log::error('Image file invalid', ['file' => $request->file('image')]);
                return back()->with('error', 'Ошибка загрузки изображения')->withInput();
            }

            $modelFile = $request->file('model_file');
            $imageFile = $request->file('image');

            Log::info('Files validation passed', [
                'model_file' => [
                    'name' => $modelFile->getClientOriginalName(),
                    'size' => $modelFile->getSize(),
                    'mime' => $modelFile->getMimeType()
                ],
                'image' => [
                    'name' => $imageFile->getClientOriginalName(),
                    'size' => $imageFile->getSize(),
                    'mime' => $imageFile->getMimeType()
                ]
            ]);

            // Сохраняем изображение
            $imagePath = $imageFile->store('models/images', 'public');
            Log::info('Image saved', ['path' => $imagePath]);

            // Сохраняем 3D модель с оригинальным именем
            $modelPath = $modelFile->storeAs(
                'models/files',
                $modelFile->getClientOriginalName(),
                'public'
            );
            Log::info('Model saved', ['path' => $modelPath]);

            // Генерируем slug вручную
            $slug = $this->generateUniqueSlug($validated['name']);
            Log::info('Generated slug', ['slug' => $slug]);

            // Создаем запись в базе с явным указанием slug
            $model = Model3D::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'slug' => $slug,
                'price' => $validated['price'],
                'category' => $validated['category'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'telegram' => $validated['telegram'],
                'description' => $validated['description'],
                'image_path' => $imagePath,
                'model_path' => $modelPath
            ]);

            Log::info('Model created successfully', [
                'id' => $model->id,
                'slug' => $model->slug,
                'name' => $model->name
            ]);

            return redirect()->route('models.show', $model->slug)->with('success', 'Модель успешно добавлена!');

        } catch (\Exception $e) {
            Log::error('Store method error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Ошибка при сохранении: ' . $e->getMessage())->withInput();
        }
    }

    // Метод для генерации уникального slug
    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Model3D::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    public function show(Model3D $model)
    {
        // Для обычных пользователей проверяем, что они владелец
        if (!$this->canViewModel($model)) {
            abort(403, 'У вас нет доступа к этой модели.');
        }

        return view('models.show', compact('model'));
    }

    public function edit(Model3D $model)
    {
        // Проверяем, имеет ли пользователь доступ к редактированию
        if (!$this->canEditModel($model)) {
            abort(403, 'У вас нет прав для редактирования этой модели.');
        }

        // Передаем информацию о том, является ли пользователь админом
        $isAdmin = auth()->user()->is_admin;
        
        return view('models.edit', compact('model', 'isAdmin'));
    }

    public function update(Request $request, Model3D $model)
    {
        // Проверяем, имеет ли пользователь доступ к редактированию
        if (!$this->canEditModel($model)) {
            abort(403, 'У вас нет прав для обновления этой модели.');
        }

        $isAdmin = auth()->user()->is_admin;
        
        // Базовая валидация для всех пользователей
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:10000',
            'category' => 'required|in:architecture,design,science,entertainment,other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'telegram' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'model_file' => [
                'nullable',
                'file',
                function ($attribute, $value, $fail) {
                    $allowed = ['obj','glb', 'gltf','stl'];
                    $ext = strtolower($value->getClientOriginalExtension());
                    if (!in_array($ext, $allowed)) {
                        $fail('Разрешены только файлы: obj,glb,gltf,stl');
                    }
                },
                'max:102400'
            ],
        ]);

        // Если пользователь админ, добавляем дополнительные поля
        if ($isAdmin) {
            $adminValidated = $request->validate([
                'is_public' => 'nullable|boolean',
                'status' => 'nullable|in:active,inactive',
            ]);
            
            $validated = array_merge($validated, $adminValidated);
        }

        try {
            // Обновляем изображение если загружено новое
            if ($request->hasFile('image')) {
                // Удаляем старое изображение
                Storage::disk('public')->delete($model->image_path);
                // Сохраняем новое
                $imagePath = $request->file('image')->store('models/images', 'public');
                $model->image_path = $imagePath;
            }

            // Обновляем 3D модель если загружена новая
            if ($request->hasFile('model_file')) {
                // Удаляем старую модель
                Storage::disk('public')->delete($model->model_path);
                // Сохраняем новую
                $modelPath = $request->file('model_file')->storeAs(
                    'models/files',
                    $request->file('model_file')->getClientOriginalName(),
                    'public'
                );
                $model->model_path = $modelPath;
            }

            // Если изменилось имя, обновляем slug
            if ($model->name !== $validated['name']) {
                $model->slug = $this->generateUniqueSlug($validated['name']);
            }

            // Обновляем остальные данные
            $model->update([
                'name' => $validated['name'],
                'slug' => $model->slug,
                'price' => $validated['price'],
                'category' => $validated['category'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'telegram' => $validated['telegram'],
                'description' => $validated['description'],
                // Добавляем админские поля если они есть
                'is_public' => $isAdmin && isset($validated['is_public']) ? $validated['is_public'] : $model->is_public,
                'status' => $isAdmin && isset($validated['status']) ? $validated['status'] : $model->status,
            ]);

            // Перенаправляем в зависимости от того, кто редактирует
            if ($isAdmin && $request->has('from_admin')) {
                return redirect()->route('admin.dashboard')->with('success', 'Модель успешно обновлена!');
            }

            return redirect()->route('models.show', $model->slug)->with('success', 'Модель успешно обновлена!');

        } catch (\Exception $e) {
            return back()->with('error', 'Ошибка при обновлении: ' . $e->getMessage())->withInput();
        }
    }
        
    public function create3d()
    {
        // Возвращаем представление для создания 3D модели
        return view('models.create3d');
    }

    public function destroy(Model3D $model)
    {
        // Проверяем, имеет ли пользователь доступ к удалению
        if (!$this->canEditModel($model)) {
            abort(403, 'У вас нет прав для удаления этой модели.');
        }

        try {
            // Удаляем файлы из хранилища
            Storage::disk('public')->delete($model->image_path);
            Storage::disk('public')->delete($model->model_path);
            
            // Удаляем запись из базы
            $model->delete();

            // Если удаляет админ - возвращаем на админ-панель
            if (auth()->user()->is_admin && request()->has('from_admin')) {
                return redirect()->route('admin.dashboard')->with('success', 'Модель успешно удалена!');
            }

            // Если удаляет обычный пользователь - возвращаем на его страницу
            return redirect()->route('models.index')->with('success', 'Модель успешно удалена!');

        } catch (\Exception $e) {
            // Если ошибка и пользователь админ - возвращаем на админ-панель
            if (auth()->user()->is_admin && request()->has('from_admin')) {
                return redirect()->route('admin.dashboard')->with('error', 'Ошибка при удалении: ' . $e->getMessage());
            }

            return back()->with('error', 'Ошибка при удалении: ' . $e->getMessage());
        }
    }

    public function allModels()
    {
        // Для публичной страницы всех моделей тоже добавляем поиск и фильтрацию
        $query = Model3D::with('user');

        // Поиск по названию
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // Фильтр по категориям
        if (request('categories')) {
            $categories = is_array(request('categories')) 
                ? request('categories') 
                : explode(',', request('categories'));
            $query->whereIn('category', $categories);
        }

        // Фильтр по минимальной цене
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        // Фильтр по максимальной цене
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        // Сортировка
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Пагинация - 12 моделей на страницу
        $models = $query->paginate(12);

        // Статистика для отображения
        $totalPrice = $query->sum('price');
        $categoriesCount = $query->distinct()->count('category');
        $usersCount = $query->distinct()->count('user_id');

        return view('models.all', compact('models', 'totalPrice', 'categoriesCount', 'usersCount'));
    }

    public function allShow(Model3D $model)
    {
        // Для публичного просмотра не проверяем владельца
        // Но можно добавить другие проверки если нужно
        return view('models.all-show', compact('model'));
    }

    public function admin()
    {
        // Проверка прав администратора
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен');
        }

        // Получаем все модели с пагинацией и фильтрацией
        $query = Model3D::with('user');

        // Поиск по названию
        if (request('search')) {
            $query->where('name', 'like', '%' . request('search') . '%');
        }

        // Фильтр по категориям
        if (request('categories')) {
            $categories = is_array(request('categories')) 
                ? request('categories') 
                : explode(',', request('categories'));
            $query->whereIn('category', $categories);
        }

        // Фильтр по минимальной цене
        if (request('min_price')) {
            $query->where('price', '>=', request('min_price'));
        }

        // Фильтр по максимальной цене
        if (request('max_price')) {
            $query->where('price', '<=', request('max_price'));
        }

        // Сортировка
        $sort = request('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Пагинация - 12 моделей на страницу
        $models = $query->paginate(12);

        // Статистика для админ-панели (общая, без фильтров)
        $totalModels = Model3D::count();
        $usersCount = \App\Models\User::count();
        $totalPrice = Model3D::sum('price');

        return view('models.admin', compact('models', 'totalModels', 'usersCount', 'totalPrice'));
    }

    public function addAdmin()
    {
        // Проверка прав администратора
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен');
        }

        // Получаем всех пользователей (кроме текущего админа)
        $users = \App\Models\User::where('id', '!=', auth()->id())->get();

        return view('models.addadmin', compact('users'));
    }

    public function makeAdmin(Request $request)
    {
        // Проверка прав администратора
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $user->update(['is_admin' => true]);

        return redirect()->route('admin.dashboard')->with('success', 'Пользователь ' . $user->name . ' теперь администратор!');
    }

    public function removeAdmin($id)
    {
        // Проверка прав администратора
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен');
        }

        $user = \App\Models\User::findOrFail($id);
        
        // Не даем убрать админку у самого себя
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Нельзя убрать админку у самого себя!');
        }

        $user->update(['is_admin' => false]);

        return redirect()->route('admin.dashboard')->with('success', 'Пользователь ' . $user->name . ' больше не администратор!');
    }

    public function userManagement(Request $request)
    {
        // Проверка прав администратора
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен');
        }

        // Получаем всех пользователей с количеством их моделей
        $query = User::withCount('models');

        // Поиск пользователей
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Фильтр по ролям - исправленная логика
        if ($request->has('roles')) {
            $roles = is_array($request->roles) ? $request->roles : explode(',', $request->roles);
            
            if (in_array('admin', $roles)) {
                $query->where('is_admin', true);
            }
            if (in_array('user', $roles)) {
                $query->where('is_admin', false);
            }
            if (in_array('new', $roles)) {
                $query->where('created_at', '>=', now()->subDay());
            }
        }

        // Фильтр по количеству моделей - исправленная логика
        $minModels = $request->get('min_models');
        $maxModels = $request->get('max_models');
        
        if ($minModels !== null && $minModels !== '') {
            $query->having('models_count', '>=', (int)$minModels);
        }
        
        if ($maxModels !== null && $maxModels !== '') {
            $query->having('models_count', '<=', (int)$maxModels);
        }

        // Сортировка
        $sort = $request->get('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'models_desc':
                $query->orderBy('models_count', 'desc');
                break;
            case 'models_asc':
                $query->orderBy('models_count', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(20);

        // Рассчитываем статистику для отображения
        $totalUsers = User::count();
        $adminCount = User::where('is_admin', true)->count();
        $todayUsers = User::whereDate('created_at', today())->count();

        return view('models.user-management', compact(
            'users', 
            'totalUsers', 
            'adminCount', 
            'todayUsers'
        ));
    }

    public function userDetail($userId)
    {
        // Проверка прав администратора
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ запрещен');
        }

        $user = User::with('models')->findOrFail($userId);
        
        return view('models.user-detail', compact('user'));
    }

    /**
     * Проверка прав на просмотр модели
     */
    private function canViewModel(Model3D $model): bool
    {
        $user = auth()->user();
        
        // Админы могут просматривать все модели
        if ($user->is_admin) {
            return true;
        }
        
        // Владельцы могут просматривать свои модели
        return $model->user_id === $user->id;
    }

    /**
     * Проверка прав на редактирование модели
     */
    private function canEditModel(Model3D $model): bool
    {
        $user = auth()->user();
        
        // Админы могут редактировать все
        if ($user->is_admin) {
            return true;
        }
        
        // Владельцы могут редактировать свои модели
        return $model->user_id === $user->id;
    }
}