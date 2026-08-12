<?php

namespace App\Policies;

class FeaturePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'feature';
    }
}
