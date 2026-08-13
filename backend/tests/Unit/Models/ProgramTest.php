<?php

namespace Tests\Unit\Models;

use App\Models\Program;
use App\Models\Property;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramTest extends TestCase
{
    use RefreshDatabase;

    protected function program(array $attributes = []): Program
    {
        return Program::create(array_merge([
            'name' => 'Minha Casa Minha Vida',
            'slug' => 'minha-casa-minha-vida',
        ], $attributes));
    }

    public function test_can_create_program(): void
    {
        $program = $this->program();

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'name' => 'Minha Casa Minha Vida',
            'slug' => 'minha-casa-minha-vida',
        ]);
    }

    public function test_can_read_program(): void
    {
        $program = $this->program();

        $found = Program::find($program->id);

        $this->assertNotNull($found);
        $this->assertSame('Minha Casa Minha Vida', $found->name);
        $this->assertSame('minha-casa-minha-vida', $found->slug);
    }

    public function test_can_update_program(): void
    {
        $program = $this->program();

        $program->update(['name' => 'Casa Verde e Amarela', 'slug' => 'casa-verde-e-amarela']);

        $this->assertDatabaseHas('programs', [
            'id' => $program->id,
            'name' => 'Casa Verde e Amarela',
        ]);
    }

    public function test_can_delete_program(): void
    {
        $program = $this->program();

        $program->delete();

        $this->assertSoftDeleted('programs', ['id' => $program->id]);
        $this->assertNull(Program::find($program->id));
    }

    public function test_program_is_active_by_default(): void
    {
        $program = $this->program();

        $this->assertTrue($program->refresh()->is_active);
    }

    public function test_program_is_a_global_catalog_without_company(): void
    {
        $program = $this->program();

        $this->assertFalse(
            array_key_exists('company_id', $program->getAttributes()),
            'Programa é catálogo global e não deve ter company_id.'
        );
    }

    public function test_program_slug_is_unique(): void
    {
        $this->program();

        $this->expectException(QueryException::class);

        Program::create([
            'name' => 'Minha Casa Minha Vida 2',
            'slug' => 'minha-casa-minha-vida',
        ]);
    }

    public function test_program_has_properties_relationship(): void
    {
        $program = $this->program();

        $this->assertInstanceOf(
            HasMany::class,
            $program->properties()
        );
    }

    public function test_property_belongs_to_program(): void
    {
        $program = $this->program();

        $property = Property::create([
            'program_id' => $program->id,
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);

        $this->assertSame($program->id, $property->program->id);
    }
}
