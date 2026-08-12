<?php

namespace Tests\Unit\Models;

use App\Models\Broker;
use App\Models\Property;
use App\Models\PropertyBooking;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PropertyBookingTest extends TestCase
{
    use RefreshDatabase;

    protected function property(): Property
    {
        return Property::create([
            'name' => 'Apartamento Teste',
            'slug' => 'apartamento-teste',
            'type' => 'apartment',
            'status' => 'available',
        ]);
    }

    protected function booking(array $attributes = []): PropertyBooking
    {
        return PropertyBooking::create(array_merge([
            'property_id' => $this->property()->id,
            'name' => 'Interessado Teste',
            'phone' => '11999999999',
        ], $attributes));
    }

    public function test_can_create_booking(): void
    {
        $booking = $this->booking();

        $this->assertDatabaseHas('property_bookings', [
            'id' => $booking->id,
            'name' => 'Interessado Teste',
            'phone' => '11999999999',
        ]);
    }

    public function test_can_read_booking(): void
    {
        $booking = $this->booking();

        $found = PropertyBooking::find($booking->id);

        $this->assertNotNull($found);
        $this->assertSame('Interessado Teste', $found->name);
    }

    public function test_can_update_booking(): void
    {
        $booking = $this->booking();

        $booking->update(['status' => 'confirmed']);

        $this->assertDatabaseHas('property_bookings', [
            'id' => $booking->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_can_delete_booking(): void
    {
        $booking = $this->booking();

        $booking->delete();

        $this->assertSoftDeleted('property_bookings', ['id' => $booking->id]);
        $this->assertNull(PropertyBooking::find($booking->id));
    }

    public function test_booking_status_is_pending_by_default(): void
    {
        $booking = $this->booking();

        $this->assertSame('pending', $booking->refresh()->status);
    }

    public function test_scheduled_at_is_cast_to_datetime(): void
    {
        $booking = $this->booking(['scheduled_at' => '2026-09-01 14:30:00']);

        $this->assertInstanceOf(Carbon::class, $booking->scheduled_at);
    }

    public function test_booking_belongs_to_property(): void
    {
        $booking = $this->booking();

        $this->assertInstanceOf(BelongsTo::class, $booking->property());
        $this->assertSame($booking->property_id, $booking->property->id);
    }

    public function test_booking_belongs_to_broker(): void
    {
        $broker = Broker::create(['name' => 'João Corretor']);
        $booking = $this->booking(['broker_id' => $broker->id]);

        $this->assertInstanceOf(BelongsTo::class, $booking->broker());
        $this->assertSame($broker->id, $booking->broker->id);
    }

    public function test_property_has_many_bookings(): void
    {
        $property = $this->property();

        PropertyBooking::create([
            'property_id' => $property->id,
            'name' => 'Interessado A',
            'phone' => '11999999991',
        ]);
        PropertyBooking::create([
            'property_id' => $property->id,
            'name' => 'Interessado B',
            'phone' => '11999999992',
        ]);

        $this->assertCount(2, $property->bookings);
    }
}
