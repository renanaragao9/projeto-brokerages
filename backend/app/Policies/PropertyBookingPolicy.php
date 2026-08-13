<?php

namespace App\Policies;

class PropertyBookingPolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'property_booking';
    }
}
