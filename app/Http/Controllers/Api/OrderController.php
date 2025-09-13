<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingDetailsCollection;
use App\Http\Resources\EventShortCollection;
use App\Http\Resources\HotelShortCollection;
use App\Http\Resources\TicketDetailsCollection;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\User;
use App\Traits\RequestRulesTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    use ResponseTrait, RequestRulesTrait;

    protected User $user;

    public function __construct()
    {
        $this->user = Auth::guard('sanctum')->user();
    }

    /**
     * store
     *
     * @param  Request $request
     * @return JsonResponse|ResponseTrait
     */
    public function store(Request $request) : JsonResponse | ResponseTrait
    {
        try {
            // validate the request
            $validation = $this->apiValidationHandel($request, $this->storeOrderRules());

            if ($validation)
                return $this->errorResponse('The request cannot be fulfilled due to bad syntax.', $validation->errors()->toArray(), 422);

            $credentials = $request->only(['orderable_type', 'orderable_id', 'total_price']);

            // store the order in database
            $order = $this->storeOrder($credentials);


            // handel to store ticket or booking
            return $credentials['orderable_type'] == Event::class ? $this->ticketStore($order) : ($credentials['orderable_type'] == Hotel::class ? $this->bookingStore($order) : $this->errorResponse('Check the Orderable_type', null, 400));

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e, 400);
        }
    }

    /**
     * storeOrder
     *
     * @param  array $credentials
     * @return Order
     */
    public function storeOrder(array $credentials): Order
    {
        return $this->user->orders()->create([
            'orderable_type' => $credentials['orderable_type'],
            'orderable_id'   => $credentials['orderable_id'],
            'total_price'    => $credentials['total_price'],
            'status'         => 'paid' // for now we set it to paid
        ]);
    }

    /**
     * ticketStore
     *
     * @param  Order $order
     * @return JsonResponse|ResponseTrait
     */
    public function ticketStore(Order $order): JsonResponse | ResponseTrait
    {
        $order->ticket()->create([
            'barcode'  => strtoupper(uniqid('TKT-')),
            'status'   => 'valid' // for now we set it to valid
        ]);
        $ticketCollection['ticket'] = TicketDetailsCollection::make($order)->resolve();
        return $this->successResponse('Ticket created successfully.', $ticketCollection, 201);
    }

    /**
     * bookingStore
     *
     * @param  Order $order
     * @return JsonResponse|ResponseTrait
     */
    public function bookingStore(Order $order): JsonResponse | ResponseTrait
    {
        $order->booking()->create([
            'check_in'    => now(),
            'check_out'   => now()->addDays(5),
            'total_price' => $order->total_price,
            'status'      => 'confirmed' // for now we set it to confirmed
        ]);
        $bookingCollection['booking'] = BookingDetailsCollection::make($order)->resolve();
        return $this->successResponse('Booking created successfully.', $bookingCollection, 201);
    }

    /**
     * showUserOrder
     *
     * @return JsonResponse | ResponseTrait
     */
    public function showUserOrder(): JsonResponse | ResponseTrait
    {
        // Upcoming events using model scopes for clarity
        $upcoming_events = $this->user
            ->orderedEvents()
            ->upcoming()
            ->latest()
            ->get();

        // Expired events using model scopes for clarity
        $past_events = $this->user
            ->orderedEvents()
            ->expired()
            ->latest()
            ->get();

        // Hotel bookings for the user, categorized via Booking scopes
        $current_bookings = $this->user
            ->bookings()
            ->current()
            ->latest()
            ->get();
        $current_bookings = collect($current_bookings)->unique(fn ($b) => $b->hotel->id);

        $past_bookings = $this->user
            ->bookings()
            ->past()
            ->latest()
            ->get();
        $past_bookings = collect($past_bookings)->unique(fn ($b) => $b->hotel->id);

        // mapping the collection
        EventShortCollection::$user = $this->user;
        $data = [
            'events' => [
                'upcoming' => EventShortCollection::collection($upcoming_events),
                'past'     => EventShortCollection::collection($past_events),
            ],
            'hotels' => [
                'current' => collect($current_bookings)->map($this->mapHotelFromBooking())->filter()->values()->all(),
                'past'    => collect($past_bookings)->map($this->mapHotelFromBooking())->filter()->values()->all(),
            ],
        ];

        return $this->successResponse('User orders fetched successfully.', $data, 200);
    }

    /**
     * mapHotelFromBooking
     *
     */
    public function mapHotelFromBooking()
    {
        return function ($booking) {

            $hotel = $booking->hotel;

            if (!$hotel) return null;

            return [
                'id' => $hotel->id,
                'cover_url' => $hotel->cover_url,
                'name' => $hotel->name,
                'rate' => $hotel->rate,
                'city' => $hotel->city->name ?? null,
                'venue' => $hotel->venue,
                'price_per_night' => $hotel->price_per_night,
                'is_favorite' => $hotel->favorites()->where('user_id', $this->user->id)->exists(),
                'favoritable_type' => Hotel::class,
            ];
        };
    }
}
