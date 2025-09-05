<x-dashboard.layouts>

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

                  <div class="col-12">
                        <div class="tile cu-rounded">
                              <div class="tile-body">
                                    {{-- Search, Filters & Sort --}}
                                    <form method="GET" action="" class="mb-4">
                                          <div class="row g-2 align-items-end">

                                                {{-- Search --}}
                                                <div class="col-md-3">
                                                      <label class="form-label">Search</label>
                                                      <input type="text" name="q" class="form-control"
                                                            placeholder="Search hotels..." value="{{ request('q') }}">
                                                </div>

                                                {{-- Price Min --}}
                                                <div class="col-md-2">
                                                      <label class="form-label">Min Price</label>
                                                      <input type="number" name="min_price" class="form-control"
                                                            value="{{ request('min_price') }}">
                                                </div>

                                                {{-- Price Max --}}
                                                <div class="col-md-2">
                                                      <label class="form-label">Max Price</label>
                                                      <input type="number" name="max_price" class="form-control"
                                                            value="{{ request('max_price') }}">
                                                </div>

                                                {{-- Rate --}}
                                                <div class="col-md-2">
                                                      <label class="form-label">Rate</label>
                                                      <select name="rate" class="form-select">
                                                            <option value="">Any</option>
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                  <option value="{{ $i }}"
                                                                        {{ request('rate') == $i ? 'selected' : '' }}>
                                                                        {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                                                  </option>
                                                            @endfor
                                                      </select>
                                                </div>

                                                {{-- Services --}}
                                                <div class="col-md-2">
                                                      <label class="form-label">Service</label>
                                                      <select name="service_id" class="form-select">
                                                            <option value="">Any</option>
                                                            @foreach ($services as $service)
                                                                  <option value="{{ $service->id }}"
                                                                        {{ request('service_id') == $service->id ? 'selected' : '' }}>
                                                                        {{ $service->name }}
                                                                  </option>
                                                            @endforeach
                                                      </select>
                                                </div>

                                                {{-- Sort --}}
                                                <div class="col-md-2">
                                                      <label class="form-label">Sort By</label>
                                                      <select name="sort" class="form-select">
                                                            <option value="">Default</option>
                                                            <option value="price_asc"
                                                                  {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                                                  Price: Low → High</option>
                                                            <option value="price_desc"
                                                                  {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                                                  Price: High → Low</option>
                                                            <option value="rate_desc"
                                                                  {{ request('sort') == 'rate_desc' ? 'selected' : '' }}>
                                                                  Rating: High → Low</option>
                                                            <option value="latest"
                                                                  {{ request('sort') == 'latest' ? 'selected' : '' }}>
                                                                  Latest</option>
                                                      </select>
                                                </div>

                                                {{-- Submit --}}
                                                <div class="col-md-1">
                                                      <button type="submit"
                                                            class="btn btn-outline-primary w-100">Apply</button>
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

</x-dashboard.layouts>
