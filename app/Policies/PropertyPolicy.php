<?php

namespace App\Policies;

class PropertyPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'property';
    }
}
