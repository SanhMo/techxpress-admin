<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'badge')) {
                $table->string('badge')->nullable()->after('stock');
            }
            if (!Schema::hasColumn('products', 'price_old')) {
                $table->decimal('price_old', 15, 0)->nullable()->after('price');
            }
            if (!Schema::hasColumn('products', 'description')) {
                $table->text('description')->nullable()->after('category');
            }
            if (!Schema::hasColumn('products', 'specs')) {
                $table->json('specs')->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'images')) {
                $table->json('images')->nullable()->after('image');
            }
            if (!Schema::hasColumn('products', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('stock');
            }
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('products', 'is_flash_sale')) {
                $table->boolean('is_flash_sale')->default(false)->after('is_featured');
            }
            if (!Schema::hasColumn('products', 'flash_sale_sold')) {
                $table->integer('flash_sale_sold')->default(0)->after('is_flash_sale');
            }
            if (!Schema::hasColumn('products', 'flash_sale_total')) {
                $table->integer('flash_sale_total')->default(100)->after('flash_sale_sold');
            }
            if (!Schema::hasColumn('products', 'image')) {
                $table->string('image')->nullable()->after('specs');
            }
            if (!Schema::hasColumn('products', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'badge',
                'price_old',
                'description',
                'specs',
                'images',
                'is_active',
                'is_featured',
                'is_flash_sale',
                'flash_sale_sold',
                'flash_sale_total',
                'image',
                'slug'
            ]);
        });
    }
};
