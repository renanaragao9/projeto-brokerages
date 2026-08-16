<?php

namespace App\Policies;

class ConstructionUpdatePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'construction_update';
    }
}
