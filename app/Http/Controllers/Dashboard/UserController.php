<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use App\Services\ImageService;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('image')
            ->latest()
            ->isAdmin(false)
            ->get();
        return view('dashboard.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request, ImageService $image)
    {
        try {
            // get validated data
            $data = $request->validated();

            // get current time now to store email verified at field, to store in database
            if ($request->has('email_verified_at'))
                $data['email_verified_at'] = now()->toDateTimeString();

            // create user
            $user = User::create($data);

            // check if there is image
            if ($request->hasFile('image'))
                $image->store($request, $user, 'users');

            return redirect()->back()->with('success', "Create User Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //return view('dashboard.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        // if the user is admin return 404 error
        return $user->is_admin ? abort(404) : view('dashboard.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, ImageService $image)
    {
        try {

            // get validated data
            $data = $request->validated();

            // get current time now to store email verified at field, to store in database
            $data['email_verified_at'] = $request->has('email_verified_at') ? now()->toDateTimeString() : null;

            // update user
            $user->update($data);

            // check if there is image or not
            if($request->hasFile('image'))
                $image->update($request, $user, 'users');

            // return redirect route
            return redirect()->back()->with('success', "Update User Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, ImageService $image)
    {
        // delete the image if exist
        if($user->hasImage())
            $image->delete($user);

        // delete the user from database
        return $user->delete() ?
        $this->successResponse("User deleted successfully", null, 200) :
        $this->errorResponse("Something went wrong, please try again later", null, 500);
    }
}
