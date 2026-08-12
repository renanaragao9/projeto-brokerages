<?php

namespace Tests\Unit\Models;

use App\Models\Broker;
use App\Models\Construction;
use App\Models\Property;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConstructionTest extends TestCase
{
    use RefreshDatabase;

    protected function construction(array $attributes = []): Construction
    {
        return Construction::create(array_merge([
            'name' => 'Construtora Alpha',
            'email' => 'contato@alpha.com',
        ], $attributes));
    }

    public function test_can_create_construction(): void
    {
        $construction = $this->construction();

        $this->assertDatabaseHas('constructions', [
            'id' => $construction->id,
            'name' => 'Construtora Alpha',
            'email' => 'contato@alpha.com',
        ]);
    }

    public function test_can_read_construction(): void
    {
        $construction = $this->construction();

        $found = Construction::find($construction->id);

        $this->assertNotNull($found);
        $this->assertSame('Construtora Alpha', $found->name);
    }

    public function test_can_update_construction(): void
    {
        $construction = $this->construction();

        $construction->update(['name' => 'Construtora Beta']);

        $this->assertDatabaseHas('constructions', [
            'id' => $construction->id,
            'name' => 'Construtora Beta',
        ]);
    }

    public function test_can_delete_construction(): void
    {
        $construction = $this->construction();

        $construction->delete();

        $this->assertSoftDeleted('constructions', ['id' => $construction->id]);
        $this->assertNull(Construction::find($construction->id));
    }

    public function test_construction_is_active_by_default(): void
    {
        $construction = $this->construction();

        $this->assertTrue($construction->refresh()->is_active);
    }

    public function test_construction_is_a_global_catalog_without_company(): void
    {
        $construction = $this->construction();

        $this->assertFalse(
            array_key_exists('company_id', $construction->getAttributes()),
            'Construtora é catálogo global e não deve ter company_id.'
        );
    }

    public function test_construction_has_brokers_relationship(): void
    {
        $construction = $this->construction();

        $this->assertInstanceOf(
            HasMany::class,
            $construction->brokers()
        );
    }

    public function test_construction_has_properties_relationship(): void
    {
        $construction = $this->construction();

        $this->assertInstanceOf(
            HasMany::class,
            $construction->properties()
        );
    }

    public function test_broker_belongs_to_construction(): void
    {
        $construction = $this->construction();

        $broker = Broker::create([
            'construction_id' => $construction->id,
            'name' => 'Corretor João',
        ]);

        $this->assertSame($construction->id, $broker->construction->id);
    }

    public function test_property_belongs_to_construction(): void
    {
        $construction = $this->construction();

        $property = Property::create([
            'construction_id' => $construction->id,
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);

        $this->assertSame($construction->id, $property->construction->id);
    }
}
