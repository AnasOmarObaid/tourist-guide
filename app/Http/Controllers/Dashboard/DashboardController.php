<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\City;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() : View {

        // Widgets: counts
        $usersCount = User::count();
        $citiesCount = City::count();
        $ticketsCount = Ticket::count();
        $bookingsCount = Booking::count();

        // Revenue charts: last 6 months for tickets and bookings (paid orders)
        $months = [];
        $ticketRevenue = [];
        $bookingRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $start = Carbon::now()->subMonths($i)->startOfMonth();
            $end = (clone $start)->endOfMonth();
            $months[] = $start->format('M Y');

            $ticketRevenue[] = (float) Order::where('orderable_type', Event::class)
                ->where('status', 'paid')
                ->whereBetween('created_at', [$start, $end])
                ->sum('total_price');

            $bookingRevenue[] = (float) Order::where('orderable_type', Hotel::class)
                ->where('status', 'paid')
                ->whereBetween('created_at', [$start, $end])
                ->sum('total_price');
        }

        // Status distributions
        $bookingStatusCounts = Booking::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')->pluck('count', 'status');
        $ticketStatusCounts = Ticket::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')->pluck('count', 'status');

        // KPI widgets
        $revenueToday = (float) Order::where('status', 'paid')
            ->whereDate('created_at', Carbon::today())
            ->sum('total_price');
        $revenueThisMonth = (float) Order::where('status', 'paid')
            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()])
            ->sum('total_price');
        $avgOrderValue = (float) Order::where('status', 'paid')->avg('total_price');

        // Orders last 7 days (tickets vs bookings)
        $ordersDays = [];
        $ordersTickets = [];
        $ordersBookings = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::now()->subDays($i)->startOfDay();
            $ordersDays[] = $day->format('D d');
            $dayEnd = (clone $day)->endOfDay();
            $ordersTickets[] = (int) Order::where('orderable_type', Event::class)
                ->where('status', 'paid')
                ->whereBetween('created_at', [$day, $dayEnd])
                ->count();
            $ordersBookings[] = (int) Order::where('orderable_type', Hotel::class)
                ->where('status', 'paid')
                ->whereBetween('created_at', [$day, $dayEnd])
                ->count();
        }

        // Top cities by paid orders (tickets and bookings)
        $topCitiesTickets = DB::table('orders')
            ->join('events', 'orders.orderable_id', '=', 'events.id')
            ->join('cities', 'events.city_id', '=', 'cities.id')
            ->select('cities.name', DB::raw('COUNT(orders.id) as count'))
            ->where('orders.orderable_type', Event::class)
            ->where('orders.status', 'paid')
            ->groupBy('cities.name')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        $topCitiesBookings = DB::table('orders')
            ->join('hotels', 'orders.orderable_id', '=', 'hotels.id')
            ->join('cities', 'hotels.city_id', '=', 'cities.id')
            ->select('cities.name', DB::raw('COUNT(orders.id) as count'))
            ->where('orders.orderable_type', Hotel::class)
            ->where('orders.status', 'paid')
            ->groupBy('cities.name')
            ->orderByDesc('count')
            ->limit(5)
            ->get();

        // Latest items
        $latestBookings = Booking::with(['hotel.city', 'user', 'order'])
            ->latest()->take(10)->get();
        $latestTickets = Ticket::with(['event.city', 'user', 'order'])
            ->latest()->take(10)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('dashboard.welcome', compact(
            'usersCount',
            'citiesCount',
            'ticketsCount',
            'bookingsCount',
            'months',
            'ticketRevenue',
            'bookingRevenue',
            'bookingStatusCounts',
            'ticketStatusCounts',
            'revenueToday',
            'revenueThisMonth',
            'avgOrderValue',
            'ordersDays',
            'ordersTickets',
            'ordersBookings',
            'topCitiesTickets',
            'topCitiesBookings',
            'latestBookings',
            'latestTickets',
            'recentUsers'
        ));
    }
}
