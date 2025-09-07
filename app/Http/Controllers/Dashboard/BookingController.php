<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\City;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::with(['hotel', 'hotel.city', 'user', 'order'])
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $cities = City::get();

        return view('dashboard.booking.index', compact('bookings', 'cities'));
    }
}
