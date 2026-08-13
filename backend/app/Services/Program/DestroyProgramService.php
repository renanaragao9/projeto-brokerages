<?php

namespace App\Services\Program;

use App\Models\Program;

class DestroyProgramService
{
    public function run(Program $program): void
    {
        $program->delete();
    }
}
