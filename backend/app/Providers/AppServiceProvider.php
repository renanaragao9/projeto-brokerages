<?php

namespace App\Providers;

use App\Models\Bank;
use App\Models\Broker;
use App\Models\Construction;
use App\Models\ConstructionUpdate;
use App\Models\Feature;
use App\Models\Notice;
use App\Models\Permission;
use App\Models\Program;
use App\Models\Property;
use App\Models\PropertyBooking;
use App\Models\Role;
use App\Models\User;
use App\Policies\BankPolicy;
use App\Policies\BrokerPolicy;
use App\Policies\ConstructionPolicy;
use App\Policies\ConstructionUpdatePolicy;
use App\Policies\FeaturePolicy;
use App\Policies\NoticePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProgramPolicy;
use App\Policies\PropertyBookingPolicy;
use App\Policies\PropertyPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class AppServiceProvider extends AuthServiceProvider
{
    protected $policies = [
        Bank::class => BankPolicy::class,
        Broker::class => BrokerPolicy::class,
        Construction::class => ConstructionPolicy::class,
        ConstructionUpdate::class => ConstructionUpdatePolicy::class,
        Feature::class => FeaturePolicy::class,
        Notice::class => NoticePolicy::class,
        Permission::class => PermissionPolicy::class,
        Program::class => ProgramPolicy::class,
        Property::class => PropertyPolicy::class,
        PropertyBooking::class => PropertyBookingPolicy::class,
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
    ];

    public function register(): void {}

    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        $this->registerPolicies();

        Gate::define('viewApiDocs', function (?User $user): bool {
            return (bool) $user?->is_super_admin;
        });

        $this->configureRateLimiting();
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('public-read', function (Request $request) {
            return Limit::perMinute(120)->by($request->ip());
        });

        RateLimiter::for('public-write', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            $key = Str::lower((string) $request->input('email')).'|'.$request->ip();

            return Limit::perMinute(5)->by($key);
        });
    }
}
