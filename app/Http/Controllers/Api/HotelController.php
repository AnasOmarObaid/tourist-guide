<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HotelDetailsCollection;
use App\Http\Resources\HotelShortCollection;
use App\Models\Hotel;
use App\Traits\RequestRulesTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    use ResponseTrait;

    /**
     * index
     *
     * @return JsonResponse|ResponseTrait
     */
    public function index(): JsonResponse | ResponseTrait
    {
        try
        {
            // get near location hotels
            $near_location_hotels = Hotel::with(['tags', 'city'])
                ->latest()
                ->get();

            // get popular hotel base on rate stars
            $popular_hotels = Hotel::with(['tags', 'city'])
                ->orderBy('rate', 'desc')
                ->limit(5)
                ->get();

            // collection the hotels
            HotelShortCollection::$user = Auth::guard('sanctum')->user();
            $data['hotels'] = [
                'near_location_hotels'=> HotelShortCollection::collection($near_location_hotels),
                'popular_hotels' => HotelShortCollection::collection($popular_hotels)
            ];

            return $this->successResponse('hotels fetched successfully', $data, 200);
        }catch (\Exception $e) {
            return $this->errorResponse('Error try later', $e->getMessage(), 500);
        }
    }

    public function show(int $id)
    {
        try
        {
            // get hotel by using id
            $hotel = Hotel::with(['tags', 'services', 'city', 'images', 'bookings.user'])
            ->where('id', $id)
            ->first();

            // if the hotel is not exist
            if(!$hotel)
                return $this->errorResponse('Hotel not found', null, 404);

            // fetch hotel details with data
            HotelDetailsCollection::$user = Auth::guard('sanctum')->user();
            $data['hotel'] = HotelDetailsCollection::make($hotel)->resolve();

            return $this->successResponse('hotel fetched successfully', $data, 200);

        }catch (\Exception $e) {
            return $this->errorResponse('Error try later', $e->getMessage(), 500);
        }
    }
}
