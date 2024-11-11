<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use App\Http\View\Composers\RequestStatusComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

           View::composer('*', function ($view) {
        $cart = json_decode(Cookie::get('cart', '[]'), true);
        $view->with('cart', $cart);
    });


        // Share request status with specific views or all views
        View::composer(['users.dashboard', 'products.all', 'products.create', 'products.edit'], RequestStatusComposer::class);
    }
}
