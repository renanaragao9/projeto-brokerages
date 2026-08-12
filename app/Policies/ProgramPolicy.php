<?php

namespace App\Policies;

class ProgramPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'program';
    }
}
