<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\{Order, Product, Review, User};
use App\Policies\{OrderPolicy, ProductPolicy, ReviewPolicy, PointPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Product::class => ProductPolicy::class,
        Order::class => OrderPolicy::class,
        Review::class => ReviewPolicy::class,
        Order::class => OrderPolicy::class,
        User::class => PointPolicy::class,
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //
    }
}
