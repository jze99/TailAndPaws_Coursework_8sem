<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $this->cleanTables();

        $categories = [
            // ============================================
            // ДЛЯ СОБАК
            // ============================================
            [
                'name' => 'Для собак',
                'slug' => 'dlya-sobak',
                'sort_order' => 10,
                'children' => [
                    // Корма для собак
                    [
                        'name' => 'Корма',
                        'slug' => 'korma-dlya-sobak',
                        'sort_order' => 10,
                        'children' => [
                            [
                                'name' => 'Сухие корма',
                                'slug' => 'suhie-korma',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Влажные корма',
                                'slug' => 'vlazhnye-korma',
                                'sort_order' => 20
                            ],
                            [
                                'name' => 'Диетическое питание',
                                'slug' => 'dieticheskoe-pitanie',
                                'sort_order' => 30
                            ],
                        ]
                    ],
                    // Амуниция для собак
                    [
                        'name' => 'Амуниция',
                        'slug' => 'amunitsiya',
                        'sort_order' => 20,
                        'children' => [
                            [
                                'name' => 'Ошейники и поводки',
                                'slug' => 'osheyniki-i-povodki',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Намордники',
                                'slug' => 'namordniki',
                                'sort_order' => 20
                            ],
                            [
                                'name' => 'Шлейки',
                                'slug' => 'shleyki',
                                'sort_order' => 30
                            ],
                        ]
                    ],
                    // Игрушки для собак
                    [
                        'name' => 'Игрушки',
                        'slug' => 'igrushki',
                        'sort_order' => 30,
                        'children' => [
                            [
                                'name' => 'Мячики и фрисби',
                                'slug' => 'myachiki-i-frisbi',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Канаты и кости',
                                'slug' => 'kanaty-i-kosti',
                                'sort_order' => 20
                            ],
                        ]
                    ],
                    // Лежанки и домики
                    [
                        'name' => 'Лежанки и домики',
                        'slug' => 'lezhanki-i-domiki',
                        'sort_order' => 40,
                        'children' => [
                            [
                                'name' => 'Лежанки',
                                'slug' => 'lezhanki',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Домики',
                                'slug' => 'domiki',
                                'sort_order' => 20
                            ],
                        ]
                    ],
                    // Миски и кормушки
                    [
                        'name' => 'Миски и кормушки',
                        'slug' => 'miski-i-kormushki',
                        'sort_order' => 50,
                        'children' => [
                            [
                                'name' => 'Миски',
                                'slug' => 'miski',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Автокормушки',
                                'slug' => 'avtokormushki',
                                'sort_order' => 20
                            ],
                        ]
                    ],
                ]
            ],

            // ============================================
            // ДЛЯ КОШЕК
            // ============================================
            [
                'name' => 'Для кошек',
                'slug' => 'dlya-koshek',
                'sort_order' => 20,
                'children' => [
                    // Корма для кошек
                    [
                        'name' => 'Корма',
                        'slug' => 'korma-dlya-koshek',
                        'sort_order' => 10,
                        'children' => [
                            [
                                'name' => 'Сухие корма',
                                'slug' => 'suhie-korma-dlya-koshek',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Паучи и консервы',
                                'slug' => 'pauchi-i-konservy',
                                'sort_order' => 20
                            ],
                            [
                                'name' => 'Лакомства',
                                'slug' => 'lakomstva-dlya-koshek',
                                'sort_order' => 30
                            ],
                        ]
                    ],
                    // Наполнители
                    [
                        'name' => 'Наполнители',
                        'slug' => 'napolniteli',
                        'sort_order' => 20,
                        'children' => [
                            [
                                'name' => 'Древесные',
                                'slug' => 'drevesnye',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Силикагелевые',
                                'slug' => 'silikagelevye',
                                'sort_order' => 20
                            ],
                            [
                                'name' => 'Комкующиеся',
                                'slug' => 'komkuyuschiesya',
                                'sort_order' => 30
                            ],
                        ]
                    ],
                    // Когтеточки и домики
                    [
                        'name' => 'Когтеточки и домики',
                        'slug' => 'kogtetochki-i-domiki',
                        'sort_order' => 30,
                        'children' => [
                            [
                                'name' => 'Когтеточки',
                                'slug' => 'kogtetochki',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Лежанки для кошек',
                                'slug' => 'lezhanki-dlya-koshek',
                                'sort_order' => 20
                            ],
                            [
                                'name' => 'Игровые комплексы',
                                'slug' => 'igrovye-kompleksy',
                                'sort_order' => 30
                            ],
                        ]
                    ],
                ]
            ],

            // ============================================
            // ДЛЯ ГРЫЗУНОВ
            // ============================================
            [
                'name' => 'Для грызунов',
                'slug' => 'dlya-gryzunov',
                'sort_order' => 30,
                'children' => [
                    [
                        'name' => 'Корма',
                        'slug' => 'korma-dlya-gryzunov',
                        'sort_order' => 10,
                        'children' => [
                            [
                                'name' => 'Зерновые смеси',
                                'slug' => 'zernovye-smesi',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Сено и травы',
                                'slug' => 'seno-i-travy',
                                'sort_order' => 20
                            ],
                            [
                                'name' => 'Лакомства',
                                'slug' => 'lakomstva-dlya-gryzunov',
                                'sort_order' => 30
                            ],
                        ]
                    ],
                    [
                        'name' => 'Клетки и аксессуары',
                        'slug' => 'kletki-i-aksessuary',
                        'sort_order' => 20,
                        'children' => [
                            [
                                'name' => 'Клетки',
                                'slug' => 'kletki',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Поилки и миски',
                                'slug' => 'poilki-i-miski',
                                'sort_order' => 20
                            ],
                            [
                                'name' => 'Наполнители',
                                'slug' => 'napolniteli-dlya-gryzunov',
                                'sort_order' => 30
                            ],
                        ]
                    ],
                ]
            ],

            // ============================================
            // ДЛЯ ПТИЦ
            // ============================================
            [
                'name' => 'Для птиц',
                'slug' => 'dlya-ptic',
                'sort_order' => 40,
                'children' => [
                    [
                        'name' => 'Корма',
                        'slug' => 'korma-dlya-ptic',
                        'sort_order' => 10,
                        'children' => [
                            [
                                'name' => 'Корма для попугаев',
                                'slug' => 'korma-dlya-popugaev',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Корма для канареек',
                                'slug' => 'korma-dlya-kanareek',
                                'sort_order' => 20
                            ],
                            [
                                'name' => 'Минеральные камни',
                                'slug' => 'mineralnye-kamni',
                                'sort_order' => 30
                            ],
                        ]
                    ],
                    [
                        'name' => 'Аксессуары',
                        'slug' => 'aksessuary-dlya-ptic',
                        'sort_order' => 20,
                        'children' => [
                            [
                                'name' => 'Клетки и жердочки',
                                'slug' => 'kletki-i-zherdochki',
                                'sort_order' => 10
                            ],
                            [
                                'name' => 'Игрушки для птиц',
                                'slug' => 'igrushki-dlya-ptic',
                                'sort_order' => 20
                            ],
                        ]
                    ],
                ]
            ],

            // ============================================
            // ДЛЯ РЫБ
            // ============================================
            [
                'name' => 'Для рыб',
                'slug' => 'dlya-ryb',
                'sort_order' => 50,
                'children' => [
                    [
                        'name' => 'Корма для рыб',
                        'slug' => 'korma-dlya-ryb',
                        'sort_order' => 10
                    ],
                    [
                        'name' => 'Аквариумы',
                        'slug' => 'akvariumy',
                        'sort_order' => 20
                    ],
                    [
                        'name' => 'Фильтрация и помпы',
                        'slug' => 'filtratsiya-i-pompy',
                        'sort_order' => 30
                    ],
                    [
                        'name' => 'Освещение',
                        'slug' => 'osveschenie',
                        'sort_order' => 40
                    ],
                    [
                        'name' => 'Грунт и декор',
                        'slug' => 'grunt-i-dekor',
                        'sort_order' => 50
                    ],
                ]
            ],

            // ============================================
            // ЗДОРОВЬЕ И УХОД
            // ============================================
            [
                'name' => 'Здоровье и уход',
                'slug' => 'zdorovie-i-uhod',
                'sort_order' => 60,
                'children' => [
                    [
                        'name' => 'Шампуни и косметика',
                        'slug' => 'shampuni-i-kosmetika',
                        'sort_order' => 10
                    ],
                    [
                        'name' => 'Витамины и добавки',
                        'slug' => 'vitaminy-i-dobavki',
                        'sort_order' => 20
                    ],
                    [
                        'name' => 'Средства от паразитов',
                        'slug' => 'sredstva-ot-parazitov',
                        'sort_order' => 30
                    ],
                    [
                        'name' => 'Аптечка',
                        'slug' => 'aptechka',
                        'sort_order' => 40
                    ],
                    [
                        'name' => 'Груминг',
                        'slug' => 'gruming',
                        'sort_order' => 50
                    ],
                ]
            ],
        ];

        foreach ($categories as $categoryData) {
            $this->createCategoryWithChildren($categoryData);
        }

        $this->command->info('✅ Категории успешно созданы!');
        $this->command->info('📊 Всего категорий: ' . Category::count());
    }

    private function cleanTables()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    private function createCategoryWithChildren($data, $parentId = null)
    {
        $children = $data['children'] ?? [];
        unset($data['children']);

        $data['parent_id'] = $parentId;
        $data['is_active'] = true;

        $data['icon'] = $data['slug'] . '.svg';

        $data['image'] = $data['slug'] . '.jpg';

        $category = Category::create($data);

        foreach ($children as $childData) {
            $this->createCategoryWithChildren($childData, $category->id);
        }
    }
}
