<?php

namespace Tests\Unit\Models;

use App\Models\Feature;
use App\Models\Property;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function feature(array $attributes = []): Feature
    {
        return Feature::create(array_merge([
            'name' => 'Swimming Pool',
            'slug' => 'swimming-pool',
        ], $attributes));
    }

    public function test_can_create_feature(): void
    {
        $feature = $this->feature();

        $this->assertDatabaseHas('features', [
            'id' => $feature->id,
            'name' => 'Swimming Pool',
            'slug' => 'swimming-pool',
        ]);
    }

    public function test_can_read_feature(): void
    {
        $feature = $this->feature();

        $found = Feature::find($feature->id);

        $this->assertNotNull($found);
        $this->assertSame('Swimming Pool', $found->name);
        $this->assertSame('swimming-pool', $found->slug);
    }

    public function test_can_update_feature(): void
    {
        $feature = $this->feature();

        $feature->update(['name' => 'Piscina']);

        $this->assertDatabaseHas('features', [
            'id' => $feature->id,
            'name' => 'Piscina',
        ]);
    }

    public function test_can_delete_feature(): void
    {
        $feature = $this->feature();

        $feature->delete();

        $this->assertSoftDeleted('features', ['id' => $feature->id]);
        $this->assertNull(Feature::find($feature->id));
    }

    public function test_feature_is_active_by_default(): void
    {
        $feature = $this->feature();

        $this->assertTrue($feature->refresh()->is_active);
    }

    public function test_feature_is_a_global_catalog_without_company(): void
    {
        $feature = $this->feature();

        $this->assertFalse(
            array_key_exists('company_id', $feature->getAttributes()),
            'Característica é catálogo global e não deve ter company_id.'
        );
    }

    public function test_feature_slug_is_unique(): void
    {
        $this->feature();

        $this->expectException(QueryException::class);

        Feature::create([
            'name' => 'Piscina',
            'slug' => 'swimming-pool',
        ]);
    }

    public function test_feature_has_properties_relationship(): void
    {
        $feature = $this->feature();

        $this->assertInstanceOf(
            BelongsToMany::class,
            $feature->properties()
        );
    }

    public function test_property_and_feature_share_pivot_with_value(): void
    {
        $feature = $this->feature();
        $property = Property::create([
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);

        $property->features()->attach($feature->id, ['value' => '2']);

        $this->assertDatabaseHas('property_features', [
            'property_id' => $property->id,
            'feature_id' => $feature->id,
            'value' => '2',
        ]);
    }
}
