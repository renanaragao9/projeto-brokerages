<?php

namespace Tests\Unit\Models;

use App\Models\Broker;
use App\Models\Construction;
use App\Models\Feature;
use App\Models\Program;
use App\Models\Property;
use App\Models\PropertyBooking;
use App\Models\PropertyImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    protected function property(array $attributes = []): Property
    {
        return Property::create(array_merge([
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ], $attributes));
    }

    public function test_can_create_property(): void
    {
        $property = $this->property();

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);
    }

    public function test_can_read_property(): void
    {
        $property = $this->property();

        $found = Property::find($property->id);

        $this->assertNotNull($found);
        $this->assertSame('Apartamento Teste', $found->name);
        $this->assertSame('apartment', $found->type);
    }

    public function test_can_update_property(): void
    {
        $property = $this->property();

        $property->update(['status' => 'sold', 'price' => 450000.00]);

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'status' => 'sold',
            'price' => 450000.00,
        ]);
    }

    public function test_can_delete_property(): void
    {
        $property = $this->property();

        $property->delete();

        $this->assertSoftDeleted('properties', ['id' => $property->id]);
        $this->assertNull(Property::find($property->id));
    }

    public function test_property_is_active_by_default(): void
    {
        $property = $this->property();

        $this->assertTrue($property->refresh()->is_active);
    }

    public function test_property_slug_is_unique(): void
    {
        $this->property();

        $this->expectException(QueryException::class);

        Property::create([
            'name' => 'Apartamento Teste 2',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);
    }

    public function test_property_belongs_to_construction(): void
    {
        $construction = Construction::create(['name' => 'Construtora Alpha']);
        $property = $this->property(['construction_id' => $construction->id]);

        $this->assertInstanceOf(BelongsTo::class, $property->construction());
        $this->assertSame($construction->id, $property->construction->id);
    }

    public function test_property_belongs_to_broker(): void
    {
        $broker = Broker::create(['name' => 'João Corretor']);
        $property = $this->property(['broker_id' => $broker->id]);

        $this->assertInstanceOf(BelongsTo::class, $property->broker());
        $this->assertSame($broker->id, $property->broker->id);
    }

    public function test_property_belongs_to_program(): void
    {
        $program = Program::create(['name' => 'Minha Casa Minha Vida', 'slug' => 'minha-casa-minha-vida']);
        $property = $this->property(['program_id' => $program->id]);

        $this->assertInstanceOf(BelongsTo::class, $property->program());
        $this->assertSame($program->id, $property->program->id);
    }

    public function test_property_has_images_relationship(): void
    {
        $property = $this->property();

        $this->assertInstanceOf(
            HasMany::class,
            $property->images()
        );
    }

    public function test_property_has_features_relationship(): void
    {
        $property = $this->property();

        $this->assertInstanceOf(
            BelongsToMany::class,
            $property->features()
        );
    }

    public function test_property_has_bookings_relationship(): void
    {
        $property = $this->property();

        $this->assertInstanceOf(
            HasMany::class,
            $property->bookings()
        );
    }

    public function test_property_images_are_force_deleted_with_property(): void
    {
        $property = $this->property();

        PropertyImage::create([
            'property_id' => $property->id,
            'path' => 'properties/1/images/fachada.jpg',
        ]);

        $property->forceDelete();

        $this->assertDatabaseMissing('property_images', [
            'property_id' => $property->id,
        ]);
    }

    public function test_property_bookings_are_force_deleted_with_property(): void
    {
        $property = $this->property();

        PropertyBooking::create([
            'property_id' => $property->id,
            'name' => 'Interessado Teste',
            'phone' => '11999999999',
        ]);

        $property->forceDelete();

        $this->assertDatabaseMissing('property_bookings', [
            'property_id' => $property->id,
        ]);
    }

    public function test_feature_has_properties_relationship(): void
    {
        $feature = Feature::create(['name' => 'Swimming Pool', 'slug' => 'swimming-pool']);

        $this->assertInstanceOf(
            BelongsToMany::class,
            $feature->properties()
        );
    }
}
