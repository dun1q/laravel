<?php

namespace App\Providers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Любой залогиненный может создавать
        Gate::define('create-car', function (User $user) {
            return true; // auth() гарантирует залогиненность
        });

        // Только владелец может редактировать/удалять (мягко)
        Gate::define('update-car', function (User $user, Car $car) {
            return $user->id === $car->user_id || $user->is_admin;
        });

        Gate::define('delete-car', function (User $user, Car $car) {
            return $user->id === $car->user_id || $user->is_admin;
        });

        // Только админ — восстанавливать / удалять навсегда
        Gate::define('restore-car', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('force-delete-car', function (User $user) {
            return $user->is_admin;
        });

        $this->registerPolicies();
        //Passport::routes();
    }
}