<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventDetailsCollection;
use App\Models\Event;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    use ResponseTrait;

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            // get the event by using id
            $event = Event::with(['city', 'tickets', 'image', 'favorites'])->where('id', $id)->first();

            // if the id not found redirect it
            if (!$event)
                return $this->errorResponse('Event not found', null, 404);

            // fetch event details collection
            EventDetailsCollection::$user = Auth::guard('sanctum')->user();
            $data['event'] = EventDetailsCollection::make($event)->resolve();

            // return the success response
            return $this->successResponse('featch event details successfully', $data, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error try later', 'error' => $e->getMessage()], 500);
        }
    }
}
