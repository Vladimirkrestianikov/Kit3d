<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->id();
             $table->string('slug')->unique(); // ← ДОБАВЬ ЭТУ СТРОЧКУ
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2)->default(0); // цена с 2 знаками после запятой
            $table->string('category')->default('other'); // категория модели
            $table->string('phone');
            $table->string('email'); // email пользователя
            $table->string('telegram');
            $table->text('description');
            $table->string('image_path'); // путь к превью изображению
            $table->string('model_path'); // путь к 3D модели
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('models');
    }
};