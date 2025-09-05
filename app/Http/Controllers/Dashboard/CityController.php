<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityStoreRequest;
use App\Http\Requests\CityUpdateRequest;
use App\Models\City;
use App\Services\ImageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CityController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cities = City::with('image')
            ->latest()
            ->get();

        return view('dashboard.city.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.city.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityStoreRequest $request, ImageService $image)
    {
        try {
            // get validated data
            $data = $request->validated();

            // get status of city
            $data['status'] = $request->has('status') ?? false;

            // create city
            $city = City::create($data);

            // store the image
            if ($request->hasFile('image'))
                $image->store($request, $city, 'cities');

            // return redirect back
            return redirect()->back()->with('success', "Create City Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        return view('dashboard.city.edit', compact('city'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityUpdateRequest $request, City $city, ImageService $image)
    {
        try {
            // validate the request
            $data = $request->validated();

            // set status
            $data['status'] = $request->has('status') ?? false;

            // update city
            $city->update($data);

            // update image
            if ($request->hasFile('image'))
                $image->update($request, $city, 'cities');

            // return back with success message
            return redirect()->back()->with('success', "Update City Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city, ImageService $image)
    {
        try {
            // delete the image if exist
            if ($city->hasImage())
                $image->delete($city);

            // delete the user from database
            return $city->delete() ?
                $this->successResponse("City deleted successfully", null, 200) :
                $this->errorResponse("Something went wrong, please try again later", null, 500);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }
}
