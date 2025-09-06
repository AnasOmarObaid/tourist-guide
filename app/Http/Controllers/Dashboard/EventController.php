<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Models\City;
use App\Models\Event;
use App\Models\Tag;
use App\Services\ImageService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $events = Event::with(['tags', 'city', 'image', 'tickets.user'])
            ->withCount('tickets')
            ->filter($request)
            ->latest()
            ->get();

        $tags = Tag::get();
        $cities = City::get();
        return view('dashboard.event.index', compact('events', 'tags', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cities = City::get();
        $tags = Tag::get();

        return view('dashboard.event.create', compact('cities', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request, ImageService $image)
    {
        try {
            // get validate data
            $data = $request->validated();

            // get status for event
            $data['status'] = request()->has('status') ?? false;

            // create event
            $event = Event::create(collect($data)->except(['image', 'tags'])->toArray());

            // add tags for event
            if (request()->has('tags'))
                $event->tags()->sync($data['tags']);

            // store the image
            if (request()->hasFile('image'))
                $image->store($request, $event, 'events');

            // return redirect back
            return redirect()->back()->with('success', "Create Event Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $cities = City::get();
        $tags = Tag::get();
        $tickets_count = $event->tickets_count;
        return view('dashboard.event.edit', compact('event', 'cities', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event, ImageService $image)
    {
        try {
            // validate the data
            $data = $request->validated();

            // set status
            $data['status'] = request()->has('status') ?? false;

            // update event
            $event->update(collect($data)->except('image', 'tags')->toArray());

            // sync tags for event
            if (request()->has('tags'))
                $event->tags()->sync($data['tags']);

            // update the image
            if (request()->hasFile('image'))
                $image->update($request, $event, 'events');

            // return back with success message
            return redirect()->back()->with('success', "Update Event Successfully");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, ImageService $image)
    {
        try {

            // delete the image if exists
            if ($event->hasImage())
                $image->delete($event);

            // delete the tags
            $event->tags()->detach();

            // delete the event
            return $event->delete() ?
                $this->successResponse("Event deleted successfully", null, 200) :
                $this->errorResponse("Something went wrong, please try again later", null, 500);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', "Something went wrong, please try again later => " . $e->getMessage());
        }
    }
}
