<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\View;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $menuController = new MenuController();
            $menuData = $menuController->getMenuData();

            $view->with('menuCategories', $menuData['categories']);
            $view->with('menuContacts', $menuData['contacts']);
            $view->with('menuBrands', $menuData['popularBrands']);
            $view->with('footerCategories', $menuData['footerCategories']);
        });
    }
}
