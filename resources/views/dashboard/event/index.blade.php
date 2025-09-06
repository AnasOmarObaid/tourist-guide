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
                        <li class="breadcrumb-item active">Events</li>
                  </ul>
            </div>

            <div class="row">

                {{-- filter search --}}
                <div class="col-12">
                        <div class="tile cu-rounded border shadow-sm w-100">
                              <div class="tile-body">
                                    @php
                                          $priceMin = 1;
                                          $priceMax = 9999;
                                          $selectedMin = (int) (request('price_min') !== null ? request('price_min') : $priceMin);
                                          $selectedMax = (int) (request('price_max') !== null ? request('price_max') : $priceMax);
                                          if ($selectedMin < $priceMin) $selectedMin = $priceMin;
                                          if ($selectedMax > $priceMax) $selectedMax = $priceMax;
                                          if ($selectedMin > $selectedMax) { $tmp = $selectedMin; $selectedMin = $selectedMax; $selectedMax = $tmp; }
                                          $selectedTags = collect(request('tags', []))->map(fn($v) => (int) $v)->toArray();
                                    @endphp

                                    <form method="GET" action="{{ route('dashboard.event.index') }}" class="mb-2">

                                          <div class="row g-2 align-items-end">

                                                {{-- search --}}
                                                <div class="col-md-4">
                                                      <label class="form-label">Search</label>
                                                      <input type="text" name="q" class="form-control" placeholder="Search events by name..." value="{{ request('q') }}">
                                                </div>

                                                   {{-- start at --}}
                                                <div class="col-md-3">
                                                      <label class="form-label">Start date (from)</label>
                                                      <input type="date" id="start_at" name="start_at_from" class="form-control" value="{{ request('start_at_from') }}">
                                                </div>

                                                {{-- end at --}}
                                                <div class="col-md-3">
                                                      <label class="form-label">End date (to)</label>
                                                      <input type="date" id="end_at" name="end_at_to" class="form-control" value="{{ request('end_at_to') }}">
                                                </div>

                                                {{-- tags --}}
                                                <div class="col-md-3">
                                                      <label class="form-label">Tags</label>
                                                      <select name="tags[]" class="form-select" id="tags_id" multiple>
                                                            @foreach ($tags as $tag)
                                                                  <option value="{{ $tag->id }}" {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                                            @endforeach
                                                      </select>
                                                </div>

                                                {{-- city --}}
                                                <div class="col-md-2">
                                                      <label class="form-label">City</label>
                                                      <select name="city_id" class="form-select" id="city_id">
                                                            <option value="">Any</option>
                                                            @foreach ($cities as $city)
                                                                  <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                            @endforeach
                                                      </select>
                                                </div>

                                                {{-- status --}}
                                                <div class="col-md-3">
                                                      <label class="form-label">Status</label>
                                                      <select name="status" class="form-select" id="status_id">
                                                            <option value="any" selected>Any</option>
                                                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Cancelled</option>
                                                      </select>
                                                </div>

                                                {{-- price --}}
                                                <div class="col-12 mt-4">
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
                                                      <button type="submit" class="btn btn-outline-primary cu-rounded w-100">Apply</button>
                                                </div>
                                                <div class="col-md-2">
                                                      <a href="{{ route('dashboard.event.index') }}" class="btn btn-outline-secondary cu-rounded w-100">Reset</a>
                                                </div>

                                          </div>
                                    </form>

                              </div>
                        </div>
                  </div>

                  <div class="col-12">
                        <div class="tile-body">
                              <div class="cities row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-3 g-4">

                                    {{-- foreach to fetch all events --}}
                                    @foreach ($events as $event)
                                          <div class="col-lg-4 col-md-12 tr">
                                                <div class="card event-card h-100">

                                                      <div class="event-image">
                                                            <img src="{{ $event->image_url }}" alt="Event">

                                                            <div class="attendees users-stack">
                                                                @foreach ($event->attendees_images as $image)
                                                                     <img src="{{ asset($image) }}"
                                                                        alt="User1">
                                                                @endforeach
                                                            </div>

                                                      </div>

                                                      <div class="event-body">
                                                            <div
                                                                  class="d-flex justify-content-between align-items-baseline">
                                                                  <div class="price-tag">${{ $event->price }}</div>
                                                                  <p
                                                                        class="status-badge {{ $event->status ? 'status-badge-success' : 'status-badge-danger' }}">
                                                                        {{ $event->status ? 'Active' : 'Cancelled' }}
                                                                  </p>
                                                            </div>
                                                            <h5 class="card-title">{{ $event->title }}</h5>
                                                            <div class="d-flex align-items-center">
                                                            <p class="text-muted mb-1"><i
                                                                        class="bi bi-geo-alt-fill text-danger"></i>
                                                                  {{ $event->city->name }}, {{ $event->venue }}
                                                            </p>
                                                            <span class=" text-success mb-1" style="margin-left: .5rem; cursor:pointer"> +{{ $event->tickets_count  }} ticket</span>
                                                            </div>
                                                            <p class="text-secondary mt-1">{{ $event->description }}</p>
                                                            <div>
                                                                  @foreach ($event->tags as $tag)
                                                                        <span
                                                                              class="tag-badge">{{ $tag->name }}</span>
                                                                  @endforeach
                                                                  <div class="details mt-3"><span>👤</span>
                                                                        {{ $event->organizer }}
                                                                    </div>
                                                                  <div class="d-flex justify-content-between align-items-center">
                                                                        <div class="date">
                                                                            <div class="details text-success mt-3">
                                                                              <span>📅</span> Start:
                                                                              {{ $event->formatted_created_at }}
                                                                            </div>
                                                                            <div class="details text-danger"><span>📅</span>
                                                                                End: {{ $event->formatted_end_at }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="dateStatus">
                                                                            <p class="px-2 status-badge d-inline
                                                                            @if ($event->event_date_status === \App\Enums\EventDateStatus::UPCOMING) status-badge-success-e
                                                                            @elseif($event->event_date_status === \App\Enums\EventDateStatus::ONGOING) status-badge-primary
                                                                            @elseif($event->event_date_status === \App\Enums\EventDateStatus::EXPIRED) status-badge-danger
                                                                            @else status-badge-secondary @endif
                                                                            "> {{ $event->event_date_status }} Event
                                                                            </p>
                                                                        </div>
                                                                  </div>

                                                            </div>

                                                      </div>
                                                      <div div class="event-footer">
                                                            <a class="btn btn-outline-primary btn-sm cu-rounded" href="{{ route('dashboard.event.edit', $event) }}"><i
                                                                        class="bi bi-pencil-square"></i> Edit</a>
                                                            <form class="d-inline" method="post" action="{{ route('dashboard.event.destroy', $event) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                 <button class="btn btn-outline-danger btn-sm rounded-pill btn-delete" type="submit"
                                                                  style="margin-left: 5px"><i class="bi bi-trash"></i>
                                                                  Delete</button>
                                                            </form>
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
            <script src="{{ asset('dashboards/js/event.js') }}">
            </script>
      @endsection

</x-dashboard.layouts>
