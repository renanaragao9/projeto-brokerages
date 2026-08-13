<?php

namespace App\Services\Program;

use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;

class IndexProgramService
{
    public function run(): Collection
    {
        return Program::with('properties')->where('is_active', true)->get();
    }
}
