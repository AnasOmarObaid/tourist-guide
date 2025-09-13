<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\User;
use App\Traits\RequestRulesTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class FavoriteController extends Controller
{
    use ResponseTrait, RequestRulesTrait;

    protected User $user;

    public function __construct()
    {
        $this->user = Auth::guard('sanctum')->user()->load(['favoriteEvents', 'favoriteHotels']);
    }

    /**
     * update
     *
     * @param  Request $request
     * @return JsonResponse|ResponseTrait
     */
    public function update(Request $request): JsonResponse | ResponseTrait
    {
        try {
            // validation the request
            $validation = $this->apiValidationHandel($request, $this->updateFavoriteRules());

            if ($validation)
                return $this->errorResponse('The request cannot be fulfilled due to bad syntax.', $validation->errors()->toArray(), 422);

            $credentials = $request->only(['favoritable_id', 'favoritable_type']);

            // now i after to ensure the Event::class or Hotel::class is exists in our database lets detach or syncWithoutDetaching
            // handel if its App\Models\Event or App\Models\Hotel
            return $credentials['favoritable_type'] == Event::class ? $this->eventHandel($credentials['favoritable_id']) : ($credentials['favoritable_type'] == Hotel::class ? $this->hotelHandel($credentials['favoritable_id']) : $this->errorResponse('Check the favoritable_type', $credentials['favoritable_type'], 400));

        } catch (Exception $e) {
            return $this->errorResponse('Error try later', $e->getMessage(), 500);
        }
    }


    /**
     * eventHandel
     *
     * @param  int $id
     * @return JsonResponse|ResponseTrait
     */
    public function eventHandel(int $id): JsonResponse | ResponseTrait
    {
        // get the favorites
        $favorites = $this->user->favoriteEvents();

        if ($favorites->find($id)) {
            $favorites->detach($id);
            return $this->successResponse('Event removed from favorites.', ['type' => Event::class, 'id' => $id, 'is_favorite' => false], 200);
        } else {
            $favorites->syncWithoutDetaching([$id]);
            return $this->successResponse('Event added to favorites.', ['type' => Event::class, 'id' => $id, 'is_favorite' => true], 200);
        }
    }

    /**
     * hotelHandel
     *
     * @param  int $id
     * @return JsonResponse|ResponseTrait
     */
    public function hotelHandel(int $id): JsonResponse | ResponseTrait
    {
        $favorites = $this->user->favoriteHotels();

        if ($favorites->find($id)) {
            $favorites->detach($id);
            return $this->successResponse('Hotel removed from favorites.', ['type' => Hotel::class, 'id' => $id, 'is_favorite' => false], 200);
        } else {
            $favorites->syncWithoutDetaching([$id]);
            return $this->successResponse('Hotel added to favorites.', ['type' => Hotel::class, 'id' => $id, 'is_favorite' => true], 200);
        }
    }
}
