<?php

namespace App\Providers;

use App\Filament\Clusters\Product;
use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

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
        Filament::serving(function () {
            \Filament\Tables\Table::configureUsing(function (\Filament\Tables\Table $table) {
                $table->paginated([10, 25, 50, 100, 200]);
            });
        });
    }
}
