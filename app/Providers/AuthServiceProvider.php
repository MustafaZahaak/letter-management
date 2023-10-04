<?php

namespace App\Providers;

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
        \App\Models\Organization::class => \App\Policies\OrganizationPolicy::class,
        'App\Models\Role'               => 'App\Policies\RolePolicy',
        'App\Models\Customer'           => 'App\Policies\CustomerPolicy',
        'App\Models\Originator'         => \App\Policies\OriginatorPolicy::class,
        \App\Models\User::class         => \App\Policies\UserPolicy::class,
        \App\Models\Group::class        => \App\Policies\GroupPolicy::class,
        \App\Models\SmsRequest::class   => \App\Policies\SmsPolicy::class,
        \App\Models\GroupMember::class  => \App\Policies\GroupMemberPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });

        Passport::routes();
        Passport::tokensExpireIn(now()->addDays(2));
        Gate::define('report', 'App\Policies\ReportPolicy@report');
        Gate::define('restPassword', 'App\Policies\UserPolicy@restPassword');
        Gate::define('subscriptions-list', 'App\Policies\SubscriberPolicy@list');
    }
}
