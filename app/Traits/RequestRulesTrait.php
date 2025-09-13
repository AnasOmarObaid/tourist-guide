<?php

namespace App\Traits;

use App\Models\Event;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidatorResponse;

trait RequestRulesTrait
{

    /**
     * apiValidationHandel
     *
     * @param  mixed $request
     * @param  mixed $rules
     * @return ValidatorResponse|null
     */
    public function apiValidationHandel(Request $request, array $rules): ValidatorResponse|null
    {
        // make validation
        $validator = Validator::make($request->all(), $rules);

        // return validated the data
        return $validator->fails() ? $validator : null;
    }


    /**
     * loginRules
     *
     * @return array
     */
    public function loginRules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required',  Rules\Password::defaults()],
        ];
    }

    /**
     * registerRules
     *
     * @return array
     */
    public function registerRules(): array
    {
        return [
            'full_name' => ['required', 'min:2', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ];
    }

    /**
     * verifyEmailRules
     *
     * @return array
     */
    public function verifyEmailRules(): array
    {
        return [
            'code' => ['required',  'exists:email_verifications']
        ];
    }

    /**
     * sendPasswordResetCodeRules
     *
     * @return array
     */
    public function sendPasswordResetCodeRules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function passwordResetRules(): array
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['required', 'digits:4'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ];
    }

    /**
     * createUserRules
     *
     * @return array
     */
    public function createUserRules(): array
    {
        return [
            'full_name' => ['required', 'min:2', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users')],
            'password' => ['required', Rules\Password::defaults()],
            'phone' => ['nullable', 'max:40'],
            'address' => ['nullable', 'max:100'],
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'email_verified_at' => ['nullable']
        ];
    }


     /**
     * updateUserRules
     *
     * @return array
     */
    public function updateUserRules(): array
    {
        return [
            'full_name' => ['required', 'min:2', 'max:20'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user)],
            'phone' => ['nullable', 'max:40'],
            'address' => ['nullable', 'max:100'],
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'email_verified_at' => ['nullable']
        ];
    }


    /**
     * createCityRules
     *
     * @return array
     */
    public function createCityRules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:30', Rule::unique('cities')],
            'country' => ['required', 'min:2', 'max:20'],
            'description' => ['nullable', 'max:200'],
            'lat' => ['required', 'min:2'],
            'lng' => ['required', 'min:2'],
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'status' => ['nullable'],
        ];
    }

    /**
     * updateCityRules
     *
     * @return array
     */
    public function updateCityRules(): array
    {
        return [
            'name' => ['required', 'min:2', 'max:30', Rule::unique('cities')->ignore($this->city)],
            'country' => ['required', 'min:2', 'max:20'],
            'description' => ['nullable', 'max:200'],
            'lat' => ['required', 'min:2'],
            'lng' => ['required', 'min:2'],
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'status' => ['nullable'],
        ];
    }

    /**
     * createCityRules
     *
     * @return array
     */
    public function createEventRules(): array
    {
        return [
            'image'       => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'price'       => ['required','numeric','min:0'],
            'title'       => ['required','string','max:255', 'min:3',  Rule::unique('events')],
            'city_id'     => ['required', 'exists:cities,id'],
            'venue'       => ['required', 'string', 'max:255'],
            'organizer'   => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000', 'min:10'],
            'start_at'    => ['required', 'date', 'after:now'],
            'end_at'      => ['required', 'date', 'after_or_equal:start_at'],
            'lat'         => ['required', 'numeric'],
            'lng'         => ['required', 'numeric'],
            'status'      => ['nullable'],
            'tags'        => ['required', 'array'],
            'tags.*'      => ['exists:tags,id'],
        ];
    }

    /**
     * updateEventRules
     *
     * @return array
     */
    public function updateEventRules(): array
    {
        return [
            'image'       => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'price'       => ['required','numeric','min:0'],
            'title'       => ['required','string','max:255', 'min:3',  Rule::unique('events')->ignore($this->event)],
            'city_id'     => ['required', 'exists:cities,id'],
            'venue'       => ['required', 'string', 'max:255'],
            'organizer'   => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:2000', 'min:10'],
            'start_at'    => ['required', 'date', 'after:now'],
            'end_at'      => ['required', 'date', 'after_or_equal:start_at'],
            'lat'         => ['required', 'numeric'],
            'lng'         => ['required', 'numeric'],
            'status'      => ['nullable'],
            'tags'        => ['required', 'array'],
            'tags.*'      => ['exists:tags,id'],
        ];
    }

    public function createHotelRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100', Rule::unique('hotels')],
            'cover' => 'required|image|mimes:jpg,png,jpeg|max:4096',
            'images' => ['nullable', 'array'],
            'images.*' => 'image|mimes:jpg,png,jpeg|max:4096',
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'city_id' => ['required', 'exists:cities,id'],
            'venue' => ['required', 'string', 'max:255'],
            'owner' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'rate' => ['required', 'integer', 'min:1', 'max:5'],
            'tags' => ['required', 'array'],
            'tags.*' => ['exists:tags,id'],
            'services' => ['required', 'array'],
            'services.*' => ['exists:services,id'],
            'status' => ['nullable', 'boolean'],
        ];
    }

    /**
     * updateHotelRules
     *
     * @return array
     */
    public function updateHotelRules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:100', Rule::unique('hotels')->ignore($this->hotel)],
            'cover' => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
            'images' => ['nullable', 'array'],
            'images.*' => 'image|mimes:jpg,png,jpeg|max:4096',
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'city_id' => ['required', 'exists:cities,id'],
            'venue' => ['required', 'string', 'max:255'],
            'owner' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'lat' => ['required', 'numeric'],
            'lng' => ['required', 'numeric'],
            'rate' => ['required', 'integer', 'min:1', 'max:5'],
            'tags' => ['required', 'array'],
            'tags.*' => ['exists:tags,id'],
            'services' => ['required', 'array'],
            'services.*' => ['exists:services,id'],
        ];
    }

    /**
     * updateProfileRules
     *
     * @return array
     */
    public function updateProfileRules() : array
    {
        return [
            'full_name' => ['required', 'string', 'min:2', 'max:100'],
            'about_me'  => ['required', 'string', 'min:2','max:500'],
            'image'     => 'nullable|image|mimes:jpg,png,jpeg|max:4096',
        ];
    }

    /**
     * updateFavoriteRules
     *
     * @return array
     */
    public function updateFavoriteRules() : array
    {
        // check if there is favoritable_type
        $type = (string) request()->input('favoritable_type', ''); // App/Models/Event or App/Models/Hotel

        if(!$type)
            return ['favoritable_type' => ['required']];

        // Map input to actual tables
        $table = in_array($type, [Event::class, 'event', 'events']) ? 'event' : 'hotel';

        if(!$table)
            return ['favoritable_type' => Rule::in(['App\Models\Event', 'App\Models\Hotel'])];

        return [
            'favoritable_type' => ['required', 'string', Rule::in(['App\Models\Event', 'App\Models\Hotel'])],
            'favoritable_id' => ['required', 'integer', 'exists:'.$table.'s,id'],
        ];
    }

     /**
      * storeOrderRules
      *
      * @return array
      */
     public function storeOrderRules() : array
    {
        // check if there is orderable_type
        $type = (string) request()->input('orderable_type', ''); // App/Models/Event or App/Models/Hotel

        if(!$type)
            return ['orderable_type' => ['required']];

        // Map input to actual tables
        $table = in_array($type, [Event::class, 'event', 'events']) ? 'event' : 'hotel';

        if(!$table)
            return ['orderable_type' => Rule::in(['App\Models\Event', 'App\Models\Hotel'])];

        return [
            'orderable_type' => ['required', 'string', Rule::in(['App\Models\Event', 'App\Models\Hotel'])],
            'orderable_id' => ['required', 'integer', 'exists:'.$table.'s,id'],
            'total_price' => ['required', 'numeric', 'min:0'],
        ];
    }


}
