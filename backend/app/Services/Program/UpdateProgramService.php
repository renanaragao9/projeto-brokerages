<?php

namespace App\Services\Program;

use App\Models\Program;

class UpdateProgramService
{
    public function run(Program $program, array $data): ?Program
    {
        $program->update($data);

        return $program;
    }
}
