<?php

namespace App\Policies;

class ConstructionPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'construction';
    }
}
