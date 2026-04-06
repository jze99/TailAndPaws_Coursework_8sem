<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $this->cleanTables();

        $brands = [
            [
                'name' => 'Royal Canin',
                'slug' => 'royal-canin',
                'description' => 'Премиальные корма для кошек и собак',
                'country' => 'Франция',
                'website' => 'https://www.royalcanin.com',
            ],
            [
                'name' => 'ABBA',
                'slug' => 'abba',
                'description' => 'Качественные корма для домашних животных',
                'country' => 'Россия',
                'website' => 'https://abba.ru',
            ],
            [
                'name' => 'RURRI',
                'slug' => 'rurri',
                'description' => 'Одежда и амуниция для собак',
                'country' => 'Россия',
            ],
            [
                'name' => 'Ownat',
                'slug' => 'ownat',
                'description' => 'Натуральные корма премиум-класса',
                'country' => 'Испания',
                'website' => 'https://www.ownat.com',
            ],
            [
                'name' => 'Grandin',
                'slug' => 'grandin',
                'description' => 'Корма и лакомства для собак',
                'country' => 'Россия',
            ],
        ];

        foreach ($brands as $brandData) {
            Brand::create($brandData);
        }

        $this->command->info('✅ Бренды созданы: ' . Brand::count());
    }

    private function cleanTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('products')->truncate();
        DB::table('brands')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
