<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelStoreRequest;
use App\Http\Requests\HotelUpdateRequest;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Service;
use App\Models\Tag;
use App\Services\ImageService;
use App\Traits\ResponseTrait;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class HotelController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::with(['tags', 'services', 'city', 'images', 'bookings.user'])
            ->latest()
            ->withCount('bookings')
            ->get();

        $services = Service::get();
        return view('dashboard.hotel.index', compact('hotels', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::get();
        $tags = Tag::get();
        $services = Service::get();

        return view('dashboard.hotel.create', compact('cities', 'tags', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HotelStoreRequest $request, ImageService $image)
    {
        try {
            // get validate data
            $data = $request->validated();

            // get status for hotel
            $data['status'] = request()->has('status') ? true : false;

            // create hotel without cover first
            $hotel = Hotel::create(collect($data)->except(['cover', 'images', 'tags', 'services'])->toArray());

            // add tags for this hotel
            if (request()->has('tags'))
                $hotel->tags()->sync($data['tags']);

            // add services for this hotel
            if (request()->has('services'))
                $hotel->services()->sync($data['services']);

            // upload cover for hotel and store it in hotel_{id}/ path
            if (request()->hasFile('cover'))
                $image->storeHotelCover(request()->file('cover'), $hotel);

            // upload rooms for hotel and store it in the same folder hotel_{id}
            if (request()->hasFile('images'))
                $image->storeRoomImages($request, $hotel);

            // return redirect withe success message
            return redirect()->back()->with('success', "Create Hotel Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        $cities = City::get();
        $tags = Tag::get();
        $services = Service::get();

        return view('dashboard.hotel.edit', compact('hotel', 'cities', 'tags', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelUpdateRequest $request, Hotel $hotel, ImageService $image)
    {
        // Use HotelUpdateRequest for validation
        // and ImageService for image operations
        try {
            $data = $request->validated();

            // get status for hotel
            $data['status'] = request()->has('status') ? true : false;

            // update hotel fields (except cover, images, tags, services)
            $hotel->update(collect($data)->except(['cover', 'images', 'tags', 'services'])->toArray());

            // sync tags
            if (request()->has('tags'))
                $hotel->tags()->sync($data['tags']);


            // sync services
            if (request()->has('services'))
                $hotel->services()->sync($data['services']);

            // check if there is cover in request
            if (request()->hasFile('cover'))
                $image->updateHotelCover(request()->file('cover'), $hotel);

            // update room images
            if (request()->hasFile('images'))
                $image->updateRoomImages($request, $hotel);

            return redirect()->back()->with('success', 'Update Hotel Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, please try again later => ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel, ImageService $image)
    {
        try {

            // delete the cover image if exists
            // delete rooms images if exists
            if ($hotel->hasImages() or $hotel->hasCover())
                $image->deleteHotelImages($hotel);

            // delete the tags
            $hotel->tags()?->detach();

            // delete the services
            $hotel->services()?->detach();

            // delete the hotel
            return $hotel->delete()
                ? $this->successResponse("Event deleted successfully", null, 200)
                : $this->errorResponse("Something went wrong, please try again later", null, 500);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

}
