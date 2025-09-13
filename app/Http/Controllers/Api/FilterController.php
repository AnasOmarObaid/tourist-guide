<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventDetailsCollection;
use App\Http\Resources\EventShortCollection;
use App\Http\Resources\HotelShortCollection;
use App\Models\City;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\Tag;
use App\Traits\RequestRulesTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FilterController extends Controller
{
    use ResponseTrait, RequestRulesTrait;

    public function index(Request $request): JsonResponse | ResponseTrait
    {
       try
       {
         // fetch the event data with filter
         $events = Event::with(['tags', 'city', 'image', 'tickets','tickets.user'])
            ->filter($request)
            ->latest()
            ->get();

        $hotels = Hotel::with(['tags', 'services', 'city', 'images', 'bookings.user'])
            ->filter($request)
            ->latest()
            ->get();

        $user = Auth::guard('sanctum')->user();
        EventShortCollection::$user = $user;
        HotelShortCollection::$user = $user;

        $data = [
            'events' => EventShortCollection::collection($events),
            'hotels' => HotelShortCollection::collection($hotels),
        ];

        // return the success response
        return $this->successResponse('featch filter data successfully', $data, 200);

       }catch(\Exception $e){
        return response()->json(['message' => 'Error try later', 'error' => $e->getMessage()], 500);
       }
    }

    public function getDetails(): JsonResponse | ResponseTrait
    {
        try
        {
            // get city and tag
            $cites = City::get(['id', 'name']);
            $tags = Tag::get(['id', 'name']);

            $data['cites'] = $cites;
            $data['tags'] = $tags;

            // return the success response
            return $this->successResponse('featch cites and tags data successfully', $data, 200);

        }catch(\Exception $e){
        return response()->json(['message' => 'Error try later', 'error' => $e->getMessage()], 500);
       }
    }
}
