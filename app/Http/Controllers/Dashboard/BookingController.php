<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['hotel', 'hotel.city', 'user', 'order'])
        ->get()
        ->groupBy(function ($booking){
            return $booking->hotel->name . '-' . $booking->hotel->name;
        })
        ;
       // dd($bookings);
        return view('dashboard.booking.index', compact('bookings'));
    }
}
