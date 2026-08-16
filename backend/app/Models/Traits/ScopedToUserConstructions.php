<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait ScopedToUserConstructions
{
    protected static function addConstructionScope(string $column, ?string $viaRelation = null): void
    {
        static::addGlobalScope('construction', function (Builder $builder) use ($column, $viaRelation): void {
            $user = Auth::user();

            if (! $user instanceof User || $user->is_super_admin) {
                return;
            }

            $constructionIds = $user->constructions()
                ->withoutGlobalScope('construction')
                ->pluck('constructions.id');

            if ($viaRelation) {
                $builder->whereHas($viaRelation, fn (Builder $query) => $query->whereIn($column, $constructionIds));

                return;
            }

            $builder->whereIn($column, $constructionIds);
        });
    }
}
