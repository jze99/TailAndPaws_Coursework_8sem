<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Удаляем JSON поля из таблицы products
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('attributes');
        });

        // Удаляем JSON поля из таблицы product_variations
        Schema::table('product_variations', function (Blueprint $table) {
            $table->dropColumn('attributes');
            $table->dropColumn('images');
        });

        // Создаем таблицу для изображений вариаций
        Schema::create('variation_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('product_variations')->cascadeOnDelete();
            $table->string('path');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['variation_id', 'sort_order']);
        });

        // Создаем таблицу для атрибутов вариаций
        Schema::create('variation_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('product_variations')->cascadeOnDelete();
            $table->string('key');
            $table->string('value')->nullable();
            $table->timestamps();

            $table->index(['variation_id', 'key']);
        });

        // Создаем таблицу для атрибутов товара
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->string('key');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->index(['product_id', 'key']);
        });
    }

    public function down()
    {
        // Возвращаем JSON поля
        Schema::table('products', function (Blueprint $table) {
            $table->json('attributes')->nullable();
        });

        Schema::table('product_variations', function (Blueprint $table) {
            $table->json('attributes')->nullable();
            $table->json('images')->nullable();
        });

        // Удаляем новые таблицы
        Schema::dropIfExists('variation_images');
        Schema::dropIfExists('variation_attributes');
        Schema::dropIfExists('product_attributes');
    }
};
