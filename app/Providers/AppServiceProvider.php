<?php

namespace App\Providers;

use App\Actions\Cart\AddToCartAction;
use App\Actions\Cart\GetCartAction;
use App\Actions\Cart\RemoveItemAction;
use App\Actions\Cart\UpdateCartItemAction;
use App\Actions\Order\SubmitOrderAction;
use App\Contracts\Cart\AddToCartContract;
use App\Contracts\Cart\GetCartContract;
use App\Contracts\Cart\RemoveItemContract;
use App\Contracts\Cart\UpdateCartItemContract;
use App\Contracts\Order\SubmitOrderContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(GetCartContract::class, GetCartAction::class);
        $this->app->bind(AddToCartContract::class, AddToCartAction::class);
        $this->app->bind(RemoveItemContract::class, RemoveItemAction::class);
        $this->app->bind(UpdateCartItemContract::class, UpdateCartItemAction::class);
        $this->app->bind(SubmitOrderContract::class, SubmitOrderAction::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Model::shouldBeStrict(!app()->isProduction());
        Model::preventLazyLoading(!app()->isProduction());
    }
}
