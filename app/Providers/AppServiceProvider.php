<?php

namespace App\Providers;

use App\Models\Broker;
use App\Models\Construction;
use App\Models\Feature;
use App\Models\Permission;
use App\Models\Program;
use App\Models\Property;
use App\Models\Role;
use App\Models\User;
use App\Policies\BrokerPolicy;
use App\Policies\ConstructionPolicy;
use App\Policies\FeaturePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProgramPolicy;
use App\Policies\PropertyPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends AuthServiceProvider
{
    /**
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Broker::class => BrokerPolicy::class,
        Construction::class => ConstructionPolicy::class,
        Feature::class => FeaturePolicy::class,
        Permission::class => PermissionPolicy::class,
        Program::class => ProgramPolicy::class,
        Property::class => PropertyPolicy::class,
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
    }
}
