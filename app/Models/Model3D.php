<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Model3D extends Model
{
    use HasFactory;
    protected $table = 'models';

    protected $fillable = [
        'user_id',
        'name',
          'slug',
        'price',
        'category', 
        'phone',
        'email',
        'telegram',
        'description',
        'image_path',
        'model_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
      public function getRouteKeyName()
    {
        return 'slug'; // ← ДОБАВЬ ЭТО
    }
}