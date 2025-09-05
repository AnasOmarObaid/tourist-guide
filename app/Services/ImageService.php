<?php

namespace App\Services;

use App\Models\Hotel;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Upload cover image for hotel
     *
     * @param  \Illuminate\Http\UploadedFile $cover
     * @param  Hotel $hotel
     * @return void
     */
    public function storeHotelCover(UploadedFile $cover, Hotel $hotel): void
    {
        // Store the cover in the correct path
        $path = $cover->storeAs(
            'uploads/images/hotels/hotel_' . $hotel->id,
            strtoupper(uniqid()) . '_cover.' . $cover->getClientOriginalExtension(),
            'public'
        );

        // update hotel with cover path
        $hotel->update(['cover' => $path]);
    }

    /**
     * updateHotelCover
     *
     * @param  \Illuminate\Http\UploadedFile $cover
     * @param  Hotel $hotel
     * @return void
     */
    public function updateHotelCover(UploadedFile $cover, Hotel $hotel): void
    {
        // check if this hotel has cover or not, remove it from storage
        $this->deleteHotelCover($hotel);

        // now upload the new cover
        $this->storeHotelCover($cover, $hotel);
    }

    /**
     * uploadRoomImages
     *
     * @param  Request $request
     * @param  Hotel $hotel
     * @return void
     */
    public function storeRoomImages(Request $request, Hotel $hotel): void
    {
        foreach ($request->file('images') as $image) {

            $path = $image->storeAs(
                'uploads/images/hotels/hotel_' . $hotel->id . '/rooms',
                strtoupper(uniqid()) . '_room_' . $hotel->id . '_.' . $image->getClientOriginalExtension(),
                'public'
            );

            // store this path in database
            $hotel->images()->create(['path' => $path]);
        }
    }

    /**
     * updateRoomImages
     *
     * @param  Request $request
     * @param  Hotel $hotel
     * @return void
     */
    public function updateRoomImages(Request $request, Hotel $hotel): void
    {
        // delete old images from disk and database
        foreach ($hotel?->images as $img) {
            if (Storage::disk('public')->exists($img->path))
                Storage::disk('public')->delete($img->path);

            $img->delete();
        }

        // now upload the new images
        $this->storeRoomImages($request, $hotel);
    }

    /**
     * store
     *
     * @param  Request $request
     * @param  mixed $imageable
     * @param  string $storeAs
     * @return mixed
     */
    public function store(Request $request, mixed $imageable, string $storeAs = ''): mixed
    {
        // store image in local and return path
        $path = $request->file('image')->store('uploads\images\\' . $storeAs);

        // create image and store it in database in images table
        return $imageable->image()->create([
            'path' => $path,
        ]);
    }

    /**
     * update
     *
     * @param  Request $request
     * @param  mixed $imageable
     * @param  string $storeAs
     * @return mixed
     */
    public function update(Request $request, mixed $imageable, string $storeAs = 'uploads/'): mixed
    {
        // delete old image, and check if this model has image
        if ($imageable->hasImage())
            $this->delete($imageable);

        // upload new image
        return $this->store($request, $imageable, $storeAs);
    }

    /**
     * delete
     *
     * @param  mixed $imageable
     * @return void
     */
    public function delete(mixed $imageable): void
    {
        // check if the image is exist or not
        if (Storage::disk('public')->exists($imageable->image?->path)) {

            // delete from local
            Storage::delete($imageable->image->path);

            // delete from database
            $imageable->image->delete();
        }

        return;
    }

    /**
     * deleteCover
     *
     * @param  Hotel $hotel
     * @return void
     */
    public function deleteHotelCover(Hotel $hotel): void
    {
        // delete from disk
        if ($hotel->hasCover() && Storage::disk('public')->exists($hotel?->cover))
            Storage::disk('public')->delete($hotel->cover);
    }

    /**
     * deleteHotelImages
     *
     * @param  Hotel $hotel
     * @return void
     */
    public function deleteHotelImages(Hotel $hotel): void
    {
        //check if the folder is exists and delete it the folder name is hotel_{id}
        $path = 'uploads/images/hotels/hotel_' . $hotel->id;

        if (Storage::disk('public')->exists($path))
            Storage::disk('public')->deleteDirectory($path);

        // delete the images from database
        $hotel->images()->delete();
    }
}
