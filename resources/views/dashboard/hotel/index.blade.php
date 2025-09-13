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
                        <li class="breadcrumb-item active">Hotels</li>
                  </ul>
            </div>

            <div class="row">
                {{-- filtering --}}
                  <div class="col-12">
                        <div class="tile cu-rounded">
                              <div class="tile-body">
                                    @php
                                          $priceMin = 1;
                                          $priceMax = 9999;
                                          $selectedMin = (int) (request('price_min') !== null ? request('price_min') : $priceMin);
                                          $selectedMax = (int) (request('price_max') !== null ? request('price_max') : $priceMax);
                                          if ($selectedMin < $priceMin) $selectedMin = $priceMin;
                                          if ($selectedMax > $priceMax) $selectedMax = $priceMax;
                                          if ($selectedMin > $selectedMax) { $tmp = $selectedMin; $selectedMin = $selectedMax; $selectedMax = $tmp; }
                                          $selectedStatuses = collect(request('statuses', []))->map(fn($v) => (string) $v)->toArray();
                                          $selectedServices = collect(request('service_ids', []))->map(fn($v) => (int) $v)->toArray();
                                    @endphp
                                    <form method="GET" action="{{ route('dashboard.hotel.index') }}" class="mb-2">
                                          <div class="row g-2 align-items-end">

                                                <div class="col-md-4">
                                                      <label class="form-label">Search</label>
                                                      <input type="text" name="q" class="form-control" placeholder="Search hotels by name, owner, or venue..." value="{{ request('q') }}">
                                                </div>


                                                <div class="col-md-4">
                                                      <label class="form-label">Status</label>
                                                      <select name="statuses[]" id="status_id" class="form-select" multiple>
                                                            <option value="1" {{ in_array('1', $selectedStatuses) ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ in_array('0', $selectedStatuses) ? 'selected' : '' }}>Cancelled</option>
                                                      </select>
                                                </div>

                                                <div class="col-md-3">
                                                      <label class="form-label">Services</label>
                                                      <select name="service_ids[]" id="service_id" class="form-select" multiple>
                                                            @foreach ($services as $service)
                                                                  <option value="{{ $service->id }}" {{ in_array($service->id, $selectedServices) ? 'selected' : '' }}>{{ $service->name }}</option>
                                                            @endforeach
                                                      </select>
                                                </div>

                                                <div class="col-md-3">
                                                      <label class="form-label">Date from</label>
                                                      <input type="date" name="date_from" id="date_from" class="form-control" value="{{ request('date_from') ? \Carbon\Carbon::parse(request('date_from'))->toDateString() : '' }}">
                                                </div>

                                                <div class="col-md-3">
                                                      <label class="form-label">Date to</label>
                                                      <input type="date" name="date_to" id="date_to" class="form-control" value="{{ request('date_to') ? \Carbon\Carbon::parse(request('date_to'))->toDateString() : '' }}">
                                                </div>

                                                <div class="col-md-2">
                                                      <label class="form-label">City</label>
                                                      <select name="city_id" class="form-select" id="city_id">
                                                            <option value="">Any</option>
                                                            @foreach ($cities as $city)
                                                                  <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                            @endforeach
                                                      </select>
                                                </div>


                                                <div class="col-12">
                                                      <div class="p-2 border rounded">
                                                            <div class="row g-2">
                                                                  <div class="col-md-3">
                                                                        <label class="form-label">Min price</label>
                                                                        <input type="number" class="form-control" name="price_min" id="price_min" min="{{ $priceMin }}" max="{{ $priceMax }}" value="{{ $selectedMin }}">
                                                                  </div>
                                                                  <div class="col-md-3">
                                                                        <label class="form-label">Max price</label>
                                                                        <input type="number" class="form-control" name="price_max" id="price_max" min="{{ $priceMin }}" max="{{ $priceMax }}" value="{{ $selectedMax }}">
                                                                  </div>
                                                                  <div class="col-md-6">
                                                                        <label class="form-label">Price range</label>
                                                                        <div class="d-flex flex-column">
                                                                              <input type="range" class="form-range" id="price_min_range" min="{{ $priceMin }}" max="{{ $priceMax }}" value="{{ $selectedMin }}">
                                                                              <input type="range" class="form-range mt-1" id="price_max_range" min="{{ $priceMin }}" max="{{ $priceMax }}" value="{{ $selectedMax }}">
                                                                              <small class="text-muted">Current: <span id="price_display">${{ $selectedMin }} - ${{ $selectedMax }}</span></small>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>

                                                <div class="col-md-2 ms-auto">
                                                      <button type="submit" class="btn btn-outline-primary w-100">Apply</button>
                                                </div>
                                                <div class="col-md-2">
                                                      <a href="{{ route('dashboard.hotel.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
                                                </div>
                                          </div>
                                    </form>

                              </div>
                        </div>

                        <div class="col-12">
                              <div class="tile-body">
                                    <div class="cities row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-3 g-4">

                                          {{-- foreach to fetch all hotels --}}
                                          @foreach ($hotels as $hotel)
                                                <div class="col-md-4 tr">
                                                      <div
                                                            class="card shadow-lg border-0 cu-rounded overflow-hidden h-100">

                                                            {{-- Cover --}}
                                                            <img src="{{ $hotel->cover_url }}" class="card-img-top"
                                                                  style="height:200px; object-fit:cover;"
                                                                  alt="{{ $hotel->name }}">

                                                            <div class="card-body d-flex flex-column">

                                                                  {{-- Title & Owner --}}
                                                                  <div
                                                                        class="d-flex justify-content-between align-items-baseline">
                                                                        <h5 class="card-title mb-1">{{ $hotel->name }}
                                                                        </h5>
                                                                        <small style="font-size: .65rem; padding: 0.35rem 0.55rem;"
                                                                              class="status-badge {{ $hotel->status ? 'status-badge-success' : 'status-badge-danger' }}">
                                                                              {{ $hotel->status ? 'Active' : 'Cancelled' }}
                                                                        </small>
                                                                  </div>
                                                                  <small class="text-muted">Owned by
                                                                        {{ $hotel->owner }}</small>

                                                                  {{-- Venue --}}
                                                                  <p class="mt-2 mb-1"><i
                                                                              class="bi bi-geo-alt-fill text-danger"></i>
                                                                        {{ $hotel->city->name . ',' . $hotel->venue }}
                                                                  </p>

                                                                  {{-- Price & Rate --}}
                                                                  <div
                                                                        class="d-flex justify-content-between align-items-center mb-3">
                                                                        <span class="fw-bold text-success">${{ $hotel->price_per_night }}
                                                                              <small>/night</small></span>
                                                                        <span class="text-warning">
                                                                              @for ($i = 1; $i <= 5; $i++)
                                                                                    <i class="bi {{ $i <= $hotel->rate ? 'bi-star-fill' : 'bi-star' }}"></i>
                                                                              @endfor
                                                                        </span>
                                                                  </div>

                                                                  {{-- Tags --}}
                                                                  <div class="mb-2">
                                                                        @foreach ($hotel->tags as $tag)
                                                                              <span class="badge bg-primary rounded-pill me-1">{{ $tag->name }}</span>
                                                                        @endforeach
                                                                  </div>

                                                                  {{-- Services --}}
                                                                  <div class="mb-3">
                                                                        @foreach ($hotel->services as $service)
                                                                              <span class="badge bg-light text-dark border me-1 cu-rounded">
                                                                                    <i class="bi bi-check-circle-fill text-success cu-rounded"></i>
                                                                                    {{ $service->name }}
                                                                              </span>
                                                                        @endforeach
                                                                  </div>

                                                                  <div class="mb-2">
                                                                        <small class="text-muted">
                                                                              {{ $hotel->description }}
                                                                        </small>
                                                                  </div>

                                                                  {{-- Guests --}}
                                                                  <div
                                                                        class="d-flex justify-content-between align-items-center mt-auto">
                                                                        <span class="text-muted"><i
                                                                                    class="bi bi-people-fill"></i>
                                                                              {{ $hotel->bookings_count }} Guests
                                                                              Booked</span>
                                                                        <div>
                                                                              <a class="btn btn-outline-primary btn-sm rounded-pill"
                                                                                    href="{{ route('dashboard.hotel.edit', $hotel) }}"><i
                                                                                          class="bi bi-pencil-square"></i>
                                                                                    Edit</a>
                                                                                <form class="d-inline" method="post" action="{{ route('dashboard.hotel.destroy', $hotel) }}">
                                                                                    @csrf
                                                                                    @method('DELETE')
                                                                                    <button class="btn btn-outline-danger btn-sm rounded-pill btn-delete" type="submit">
                                                                                    <i class="bi bi-trash"></i>Delete</button>
                                                                                </form>
                                                                        </div>
                                                                  </div>
                                                            </div>

                                                      </div>
                                                </div>
                                          @endforeach
                                    </div>

                              </div>
                        </div>

                  </div>
      </main>

      @section('scripts')
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="{{ asset('dashboards/js/hotel.js') }}">
            </script>
      @endsection

</x-dashboard.layouts>
