<?php

namespace App\Http\Controllers;

use App\Models\Model3D;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Добавьте проверку на админа если нужно
        // $this->middleware('admin');
    }

    public function index(Request $request)
    {
        // Запрос для всех моделей с пользователями
        $query = Model3D::with('user');
        
        // Поиск
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Фильтр по категориям
        if ($request->has('categories') && $request->categories) {
            $categories = is_array($request->categories) 
                ? $request->categories 
                : explode(',', $request->categories);
            $query->whereIn('category', $categories);
        }
        
        // Сортировка
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->orderBy('created_at');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }
        
        $models = $query->paginate(12);
        
        // Статистика для админ-панели
        $totalModels = Model3D::count();
        $totalUsers = User::count();
        $totalPrice = Model3D::sum('price');
        $todayModels = Model3D::whereDate('created_at', today())->count();
        
        return view('models.admin', compact(
            'models', 
            'totalModels', 
            'totalUsers', 
            'totalPrice', 
            'todayModels'
        ));
    }
    
    public function destroy($id)
    {
        $model = Model3D::findOrFail($id);
        
        // Удаление файлов модели
        if ($model->image_path) {
            Storage::disk('public')->delete($model->image_path);
        }
        if ($model->model_path) {
            Storage::disk('public')->delete($model->model_path);
        }
        
        $model->delete();
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Модель успешно удалена');
    }
    
    public function destroyAll()
    {
        DB::transaction(function () {
            $models = Model3D::all();
            
            foreach ($models as $model) {
                if ($model->image_path) {
                    Storage::disk('public')->delete($model->image_path);
                }
                if ($model->model_path) {
                    Storage::disk('public')->delete($model->model_path);
                }
                $model->delete();
            }
        });
        
        return redirect()->route('admin.dashboard')
            ->with('success', 'Все модели успешно удалены');
    }
    
    public function export()
    {
        // Простая реализация экспорта
        $models = Model3D::with('user')->get();
        
        $csvData = "ID,Название,Цена,Категория,Автор,Email,Дата создания\n";
        
        foreach ($models as $model) {
            $csvData .= "{$model->id},{$model->name},{$model->price},{$model->category},{$model->user->name},{$model->user->email},{$model->created_at}\n";
        }
        
        $filename = 'models_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }


    // В вашем AdminController добавьте методы:

            
}