<?php

namespace App\Policies;

class BankPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'bank';
    }
}
