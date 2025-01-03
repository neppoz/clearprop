<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define the gates for the navigation here
        Gate::define('viewReservations', [\App\Policies\NavigationPolicy::class, 'viewReservations']);
        Gate::define('viewActivities', [\App\Policies\NavigationPolicy::class, 'viewActivities']);
        Gate::define('viewPayments', [\App\Policies\NavigationPolicy::class, 'viewPayments']);
        Gate::define('viewUsers', [\App\Policies\NavigationPolicy::class, 'viewUsers']);
        Gate::define('viewAircrafts', [\App\Policies\NavigationPolicy::class, 'viewAircrafts']);
        Gate::define('viewPackages', [\App\Policies\NavigationPolicy::class, 'viewPackages']);
        Gate::define('viewSettings', [\App\Policies\NavigationPolicy::class, 'viewSettings']);
        Gate::define('viewReports', [\App\Policies\NavigationPolicy::class, 'viewReports']);
    }
}
