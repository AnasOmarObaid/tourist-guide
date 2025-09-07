<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Show the profile edit form
     */
    public function edit()
    {
        $user = Auth::user();

        return view('dashboard.profile.edit', compact('user'));
    }

    /**
     * Update the profile information
     */
    public function update(Request $request)
    {
        try {
            // get validated data
            $credentials = $request->all();

            // get user
            $user = Auth::user();

            //dd($credentials);
            $this->profileService->updateProfile($user, $credentials, $request);

            return redirect()->back()->with('success', "Update Profile Successfully");

        } catch (\Exception $e) {
             return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

    /**
     * Update the password
     */
    public function updatePassword(Request $request)
    {
        try {
            $user = Auth::user();

            $this->profileService->updatePassword(
                $user,
                $request->current_password,
                $request->new_password
            );

            return redirect()->back()->with('success', 'Password updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }
}
