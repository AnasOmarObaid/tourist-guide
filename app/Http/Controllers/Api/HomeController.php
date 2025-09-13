<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventShortCollection;
use App\Models\Event;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    use ResponseTrait;

    // get event data for home page
    /**
     * index
     *
     * @return JsonResponse|ResponseTrait
     */
    public function index(): JsonResponse | ResponseTrait
    {

        try {

            // Get upcoming events
            $upcomingEvents = Event::display()
                ->upcoming()
                ->orderBy('start_at', 'asc')
                ->get();

            // Get ongoing events
            $ongoingEvents = Event::display()
                ->ongoing()
                ->orderBy('start_at', 'asc')
                ->get();

            // Get expired events
            $expiredEvents = Event::display()
                ->expired()
                ->orderBy('end_at', 'desc')
                ->get();


            // Set the authenticated user in the resource
            EventShortCollection::$user = Auth::guard('sanctum')->user();
            $data['events'] =  [
                'upcoming' => EventShortCollection::collection($upcomingEvents),
                'ongoing' => EventShortCollection::collection($ongoingEvents),
                'expired' => EventShortCollection::collection($expiredEvents)
            ];

            return $this->successResponse('Events fetched successfully', $data, 200);
        } catch (\Exception $e) {
            return $this->errorResponse('Error try later', $e->getMessage(), 500);
        }
    }
}
