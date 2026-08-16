<?php

namespace App\Policies;

class NoticePolicy extends BasePolicy
{
    protected function resourceCode(): string
    {
        return 'notice';
    }
}
