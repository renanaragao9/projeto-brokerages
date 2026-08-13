<?php

namespace App\Services\Program;

use App\Models\Program;

class StoreProgramService
{
    public function run(array $data): ?Program
    {
        return Program::create($data);
    }
}
