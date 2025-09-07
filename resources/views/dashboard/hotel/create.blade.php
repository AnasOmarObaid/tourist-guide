<x-dashboard.layouts>

      @section('css')
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <style>
                  .select2 {
                        width: initial !important;
                        display: block;
                  }
            </style>
      @endsection

      <main class="app-content">

            <div class="app-title">
                  <div>
                        <h1><i class="bi bi-speedometer"></i> Dashboard </h1>
                        <p>Enjoy a powerful and modern control panel for project management.</p>
                  </div>

                  <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.welcome') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="{{ route('dashboard.hotel.index') }}">Hotels</a>
                        </li>
                        <li class="breadcrumb-item">Create Hotel</li>
                  </ul>
            </div>

            <div class="row mb-4">

                  {{-- create hotel --}}
                  <div class="col-12 col-lg-6">
                        <div class="tile cu-rounded">
                              <div class="tile-body">
                                    <form class="form" method="POST" action="{{ route('dashboard.hotel.store') }}"
                                          enctype="multipart/form-data">
                                          @method('POST')
                                          @csrf

                                          {{-- image filed --}}
                                          <label class="control-label mb-2">Upload Cover Hotel</label>
                                          <div class="form-image mb-3 d-flex @error('cover') border-color-red @enderror"
                                                onclick="document.getElementById('cover_image').click()"
                                                style="height: 180px;border: 1px solid;align-items: center;justify-content: space-around; cursor: pointer;">
                                                <div class="icon"><i class="bi bi-image fs-1"></i></div>
                                          </div>
                                          <input type="file" name="cover" id="cover_image" accept="image/*"
                                                style="display: none;">

                                           {{-- Name field --}}
                                          <div class="mb-3">
                                                <label class="form-label">Hotel Name</label>
                                                <input class="form-control @error('name') is-invalid  @enderror"
                                                      type="text" id="name" name="name"
                                                      value="{{ old('name') }}" placeholder="Title">
                                                @error('name')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- price_per_night filed --}}
                                          <div class="mb-3">
                                                <label class="form-label">Price per night</label>
                                                <input class="form-control @error('price_per_night') is-invalid  @enderror"
                                                      type="number" id="price_per_night" name="price_per_night" step="0.01"
                                                      value="{{ old('price_per_night') }}" placeholder="Price per night">
                                                @error('price_per_night')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- City filed --}}
                                          <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <select class="form-select @error('city_id') is-invalid  @enderror"
                                                      name="city_id" id="city_id">
                                                      <option value=""></option>
                                                      @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                  {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                                  {{ $city->name }}
                                                            </option>
                                                      @endforeach
                                                </select>
                                                @error('city_id')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- venue field and Owner --}}
                                          <div class="mb-3 row">
                                                <div class="col">
                                                      <label class="form-label">Venue</label>
                                                      <input class="form-control @error('venue') is-invalid  @enderror"
                                                            type="text" id="venue" name="venue"
                                                            value="{{ old('venue') }}" placeholder="Venue">
                                                      @error('venue')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                <div class="col">
                                                      <label class="form-label">Owner</label>
                                                      <input class="form-control @error('owner') is-invalid  @enderror"
                                                            type="text" id="owner" name="owner"
                                                            value="{{ old('owner') }}" placeholder="Organizer">
                                                      @error('owner')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>
                                          </div>

                                          {{-- description field --}}
                                          <div class="mb-3">
                                                <label for="form-label">Description</label>
                                                <textarea class="form-control @error('description') is-invalid  @enderror" id="description" name="description"
                                                      placeholder="Description" rows="5">{{ old('description') }}</textarea>
                                                @error('description')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- lat & lng filed in same row --}}
                                          <div class="mt-3 mb-3 row">
                                                <div class="col">
                                                      <label for="form-label">Latitude</label>
                                                      <input class="form-control @error('lat') is-invalid  @enderror"
                                                            type="text" id="latitude" name="lat"
                                                            value="{{ old('lat') }}" placeholder="Latitude">
                                                      @error('lat')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>
                                                <div class="col">
                                                      <label for="form-label">Longitude</label>
                                                      <input class="form-control @error('lng') is-invalid  @enderror"
                                                            type="text" id="longitude" name="lng"
                                                            value="{{ old('lng') }}" placeholder="Longitude">
                                                      @error('lng')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>
                                          </div>

                                          {{-- set rating for hotel --}}
                                          <div class="mt-3 mb-3">
                                            <label class="form-label">Rating</label>
                                            <input class="form-control @error('rate') is-invalid  @enderror"
                                                      type="number" id="rate" name="rate" min="1" max="5"
                                                      value="{{ old('rate') }}" placeholder="Rate">
                                            @error('rate')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                            @enderror
                                          </div>

                                          {{-- set tags for hotels --}}
                                          <div class="mb-3">
                                                <label class="form-label">Tags</label>
                                                <select name="tags[]" class="form-select" id="tags_id" multiple>
                                                      <option value="">Select Tags</option>
                                                      @foreach ($tags as $tag)
                                                            <option value="{{ $tag->id }}"
                                                                  {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                                                                  {{ $tag->name }}
                                                            </option>
                                                      @endforeach
                                                </select>
                                                @error('tags')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                            {{-- set services for hotel --}}
                                          <div class="mb-3">
                                                <label class="form-label">Services</label>
                                                <select name="services[]" class="form-select" id="service_id" multiple>
                                                      <option value="">Select Services</option>
                                                      @foreach ($services as $service)
                                                            <option value="{{ $service->id }}"
                                                                  {{ collect(old('service'))->contains($service->id) ? 'selected' : '' }}>
                                                                  {{ $service->name }}
                                                            </option>
                                                      @endforeach
                                                </select>
                                                @error('service')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                           {{-- room images field --}}
                                          <label class="mt-2 control-label mb-2">Upload Room Images</label>
                                          <div class="form-image mb-3 d-flex @error('images') border-color-red @enderror"
                                                onclick="document.getElementById('room_images').click()"
                                                style="min-height: 200px; border: 1px solid; align-items: center; justify-content: space-around; cursor: pointer;">
                                                <div class="icon"><i class="bi bi-images fs-1"></i></div>
                                          </div>
                                          <input type="file" name="images[]" id="room_images" accept="image/*" multiple style="display: none;">

                                          {{-- mark as a available or not --}}
                                          <div class="mb-3 form-check">
                                                <input class="form-check-input" type="checkbox" id="status"
                                                      name="status" value="1" checked>
                                                <label class="form-check-label" for="status">
                                                      Mark as a available hotel
                                                </label>
                                          </div>

                                          {{--  submit --}}
                                          <div class="tile-footer text-center">
                                                <button class="btn btn-primary w-100 mb-0"
                                                      style="border-radius: 1.5rem;" type="submit">
                                                      <i class="bi bi-check-circle-fill"></i>Create Hotel
                                                </button>
                                          </div>

                                    </form>
                              </div>
                        </div>
                  </div>

                  {{-- hotel preview  --}}
                  <div class="col-12 col-md-12 col-lg-6">
                        <div class="col-md-12">
                              <div class="card shadow-lg border-0 cu-rounded overflow-hidden h-100">

                                    {{-- Cover --}}
                                    <img id="previewImage" src="{{ asset('https://placehold.co/350x350/') }}"
                                          class="card-img-top" style="height:400px; object-fit:cover;"
                                          alt="Hotel Image">

                                    <div class="card-body d-flex flex-column">

                                          {{-- Title & Owner --}}
                                          <div class="d-flex justify-content-between align-items-baseline">
                                                <h5 class="card-title mb-1" id="name_preview">{{ old('name') }}
                                                </h5>
                                                <small id="status_preview"
                                                      style="font-size: .65rem; padding: 0.35rem 0.55rem;"
                                                      class="status-badge status-badge-success">
                                                      Active
                                                </small>
                                          </div>
                                          <small class="text-muted" id="owner_preview">Owned by {{ old('owner') }}</small>

                                          {{-- Venue --}}
                                          <p class="mt-2 mb-1"><i class="bi bi-geo-alt-fill text-danger"></i>
                                                <span id="city_preview"></span>, <span
                                                      id="venue_preview">{{ old('venue') }}</span>
                                          </p>

                                          {{-- Price & Rate --}}
                                          <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="fw-bold text-success"
                                                      id="price_per_night_preview">${{ old('price_per_night') }}
                                                      <small>/night</small></span>
                                                <span class="text-warning" id="rate_preview">

                                                </span>
                                          </div>

                                          {{-- Tags --}}
                                          <div class="mb-3" id="tags_preview">
                                          </div>

                                          {{-- Services --}}
                                          <div class="mb-3" id="services_preview">
                                          </div>

                                          {{-- description --}}
                                          <div class="mb-2">
                                                <small class="text-muted" id="description_preview">
                                                      {{ old('description') }}
                                                </small>
                                          </div>

                                        {{-- Room Images Preview --}}
                                        <div id="roomImagesPreview" class="d-flex flex-wrap gap-2"></div>

                                          {{-- Guests --}}
                                          <div class="d-flex justify-content-between align-items-center mt-auto">
                                                <span class="text-muted"><i class="bi bi-people-fill"></i> 0 Guests Booked</span>
                                          </div>

                                    </div>

                              </div>
                        </div>
                  </div>

            </div>

      </main>

      @section('scripts')
            <script src="{{ asset('dashboards/js/city.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


            {{-- live preview --}}
            <script src="{{ asset('dashboards/js/hotel.js') }}"></script>

      @endsection
</x-dashboard.layouts>
