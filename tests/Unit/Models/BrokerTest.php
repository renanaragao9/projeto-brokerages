<?php

namespace Tests\Unit\Models;

use App\Models\Broker;
use App\Models\Construction;
use App\Models\Property;
use App\Models\PropertyBooking;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrokerTest extends TestCase
{
    use RefreshDatabase;

    protected function broker(array $attributes = []): Broker
    {
        return Broker::create(array_merge([
            'name' => 'João Corretor',
            'email' => 'joao@corretor.com',
        ], $attributes));
    }

    public function test_can_create_broker(): void
    {
        $broker = $this->broker();

        $this->assertDatabaseHas('brokers', [
            'id' => $broker->id,
            'name' => 'João Corretor',
            'email' => 'joao@corretor.com',
        ]);
    }

    public function test_can_read_broker(): void
    {
        $broker = $this->broker();

        $found = Broker::find($broker->id);

        $this->assertNotNull($found);
        $this->assertSame('João Corretor', $found->name);
    }

    public function test_can_update_broker(): void
    {
        $broker = $this->broker();

        $broker->update(['name' => 'Maria Corretora']);

        $this->assertDatabaseHas('brokers', [
            'id' => $broker->id,
            'name' => 'Maria Corretora',
        ]);
    }

    public function test_can_delete_broker(): void
    {
        $broker = $this->broker();

        $broker->delete();

        $this->assertSoftDeleted('brokers', ['id' => $broker->id]);
        $this->assertNull(Broker::find($broker->id));
    }

    public function test_broker_is_active_by_default(): void
    {
        $broker = $this->broker();

        $this->assertTrue($broker->refresh()->is_active);
    }

    public function test_broker_is_a_global_catalog_without_company(): void
    {
        $broker = $this->broker();

        $this->assertFalse(
            array_key_exists('company_id', $broker->getAttributes()),
            'Corretor é catálogo global e não deve ter company_id.'
        );
    }

    public function test_broker_belongs_to_construction(): void
    {
        $construction = Construction::create(['name' => 'Construtora Alpha']);
        $broker = $this->broker(['construction_id' => $construction->id]);

        $this->assertInstanceOf(BelongsTo::class, $broker->construction());
        $this->assertSame($construction->id, $broker->construction->id);
    }

    public function test_broker_has_properties_relationship(): void
    {
        $broker = $this->broker();

        $this->assertInstanceOf(
            HasMany::class,
            $broker->properties()
        );
    }

    public function test_broker_has_property_bookings_relationship(): void
    {
        $broker = $this->broker();

        $this->assertInstanceOf(
            HasMany::class,
            $broker->propertyBookings()
        );
    }

    public function test_property_belongs_to_broker(): void
    {
        $broker = $this->broker();

        $property = Property::create([
            'broker_id' => $broker->id,
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);

        $this->assertSame($broker->id, $property->broker->id);
    }

    public function test_property_booking_belongs_to_broker(): void
    {
        $broker = $this->broker();
        $property = Property::create([
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);

        $booking = PropertyBooking::create([
            'property_id' => $property->id,
            'broker_id' => $broker->id,
            'name' => 'Interessado Teste',
            'phone' => '11999999999',
        ]);

        $this->assertSame($broker->id, $booking->broker->id);
    }
}
