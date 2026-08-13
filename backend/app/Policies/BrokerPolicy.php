<?php

namespace App\Policies;

class BrokerPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'broker';
    }
}
