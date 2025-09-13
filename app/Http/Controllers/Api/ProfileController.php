<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileCollection;
use App\Models\User;
use App\Services\ProfileService;
use App\Traits\RequestRulesTrait;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ResponseTrait, RequestRulesTrait;

    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {

            // get the authenticated user
            $user = Auth::guard('sanctum')->user()->load(['image', 'favorites', 'favoriteHotels', 'favoriteEvents']);

            // transform the user data
            $data = ProfileCollection::make($user)->resolve();

            return $this->successResponse('Profile fetched successfully', $data, 200);

        } catch (Exception $e) {
            return $this->errorResponse('Error try later', $e->getMessage(), 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try
        {
        $user = $user = Auth::guard('sanctum')->user();

        // validate the request
        $validation = $this->apiValidationHandel($request, $this->updateProfileRules());

        if ($validation)
            return $this->errorResponse('The request cannot be fulfilled due to bad syntax.', $validation->errors()->toArray(), 422);

        $credentials = $request->only('full_name', 'about_me');

        // call the service to update the profile
        $this->profileService->updateProfile($user, $credentials, $request);

        return $this->successResponse('Profile updated successfully', null, 200);
        }
        catch (Exception $e) {
            return $this->errorResponse('Error try later', $e->getMessage(), 500);
        }
    }
}
