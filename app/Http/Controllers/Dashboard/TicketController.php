<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('event','event.city', 'user', 'order')
        ->latest()
        ->paginate(9);

        return view('dashboard.ticket.index', compact('tickets'));
    }


}
