<x-dashboard.layouts>

      @section('css')
            <link rel="stylesheet" href="{{ asset('dashboards/css/user.create.css') }}">
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
                        <li class="breadcrumb-item active"><a href="{{ route('dashboard.city.index') }}">Cities</a></li>
                        <li class="breadcrumb-item">Edit city</li>
                  </ul>
            </div>
            <div class="row">

                  {{-- create city  --}}
                  <div class="row mb-4">

                        {{-- form --}}
                        <div class="col-12 col-lg-6">
                              <div class="tile">
                                    <div class="tile-body">
                                          <form class="form" method="POST" action="{{ route('dashboard.city.update', $city) }}"
                                                enctype="multipart/form-data">
                                                @method('PUT')
                                                @csrf

                                                {{-- image filed --}}
                                                <label class="control-label mb-2">Upload Image</label>
                                                <div class="form-image mb-3 d-flex @error('image') border-color-red @enderror"
                                                      onclick="document.getElementById('city_image').click()"
                                                      style="height: 180px;border: 1px solid;align-items: center;justify-content: space-around; cursor: pointer;">
                                                      <div class="icon"><i class="bi bi-image fs-1"></i></div>
                                                </div>

                                                <input type="file" name="image" id="city_image" accept="image/*" style="display: none;">

                                                {{-- Name field --}}
                                                <div class="mb-3">
                                                      <label class="form-label">Name</label>
                                                      <input class="form-control @error('name') is-invalid  @enderror"
                                                            type="text" id="name" name="name"
                                                            value="{{ old('name', $city->name) }}" placeholder="Name">
                                                      @error('name')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                {{-- Country field --}}
                                                <div class="mb-3">
                                                      <label class="form-label">Country</label>
                                                      <input class="form-control @error('country') is-invalid  @enderror"
                                                            type="text" id="country" name="country"
                                                            value="{{ old('country', $city->country) }}" placeholder="Country">
                                                      @error('country')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                {{-- description field --}}
                                                <div class="mb-3">
                                                      <label for="form-label">Description</label>
                                                      <textarea class="form-control @error('description') is-invalid  @enderror" id="description" name="description"
                                                            placeholder="Description">{{ old('description', $city->description) }}</textarea>
                                                      @error('description')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                {{-- lat & lng filed in same row --}}
                                                <div class="mb-3 row">
                                                      <div class="col">
                                                            <label for="form-label">Latitude</label>
                                                            <input class="form-control @error('lat') is-invalid  @enderror"
                                                                  type="text" id="latitude" name="lat"
                                                                  value="{{ old('lat', $city->lat) }}" placeholder="Latitude">
                                                            @error('lat')
                                                                  <small class="invalid-feedback"
                                                                        role="alert"><strong>{{ $message }}</strong></small>
                                                            @enderror
                                                      </div>
                                                      <div class="col">
                                                            <label for="form-label">Longitude</label>
                                                            <input class="form-control @error('lng') is-invalid  @enderror"
                                                                  type="text" id="longitude" name="lng"
                                                                  value="{{ old('lng', $city->lng) }}" placeholder="Longitude">
                                                            @error('lng')
                                                                  <small class="invalid-feedback"
                                                                        role="alert"><strong>{{ $message }}</strong></small>
                                                            @enderror
                                                      </div>
                                                </div>

                                                {{-- mark as a available or not --}}
                                                <div class="mb-3 form-check">
                                                      <input class="form-check-input" type="checkbox" id="status"
                                                            name="status" value="1" {{ $city->status ? 'checked' : '' }}>
                                                      <label class="form-check-label" for="status">
                                                            Mark as a available city
                                                      </label>
                                                </div>

                                                <div class="tile-footer text-center">
                                                    <button class="btn btn-primary w-100 mb-0" type="submit">
                                                        <i class="bi bi-check-circle-fill"></i>Edit City
                                                    </button>
                                                </div>
                                          </form>
                                    </div>
                              </div>
                        </div>

                        {{-- City preview --}}
                        <div class="col">
                              {{-- city card --}}
                              <div class="card h-70">
                                    <div class="card-img-container">
                                          <img id="previewImage" src="{{ asset($city->getImagePath()) }}"
                                                class="card-img-top border-radius-6" alt="Random" />
                                    </div>
                                    <div class="card-body">
                                          <div class="info mb-1"
                                                style="align-items: baseline;">
                                                <h5 class="card-title d-inline" id="name_preview">{{ old('name', $city->name) }}</h5>
                                                , <h5 class="card-title d-inline" id="country_preview">{{ old('country', $city->country) }}</small>
                                          </div>
                                        <span class="badge {{ $city->status ? 'bg-success' : 'bg-danger' }}" id="previewStatus">{{ $city->status ? 'Available City' : 'Unavailable City' }}</span>
                                          <p class="card-text mt-2" id="description_preview">{{ old('description', $city->description) }}</p>
                                          <div class="card-tail">
                                                <p class="card-text d-inline" id="latitude_preview">{{ old('lat', $city->lat) }}</p>
                                                <p class="card-text d-inline" id="longitude_preview">{{ old('lng', $city->lng) }}</p>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </main>

      @section('scripts')
            <script src="{{ asset('dashboards/js/city.js') }}"></script>
      @endsection
</x-dashboard.layouts>
