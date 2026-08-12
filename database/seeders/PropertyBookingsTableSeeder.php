<?php

namespace Database\Seeders;

use App\Models\PropertyBooking;
use Illuminate\Database\Seeder;

class PropertyBookingsTableSeeder extends Seeder
{
    public function run(): void
    {
        $bookings = [];

        foreach ($bookings as $booking) {
            PropertyBooking::updateOrCreate(['id' => $booking['id']], $booking);
        }
    }
}
