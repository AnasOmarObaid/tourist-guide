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
                <li class="breadcrumb-item active">Cities</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="tile cu-rounded border shadow-sm w-100">
                    <div class="tile-body">
                        <div class="filter-card">
                            <span id="cityResultsCount" class="badge bg-light border align-self-center text-success">Showing 0 of 0</span>
                            <div class="row g-2 mt-2">

                                <div class="col-12 col-lg-8">
                                    <div class="position-relative">
                                        <span class="position-absolute top-50 translate-middle-y ms-3 text-muted"><i class="bi bi-search"></i></span>
                                        <input type="text" id="citySearch" class="form-control ps-5 rounded-pill" placeholder="Search cities by name..." aria-label="Search cities">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 float-lg-end">
                                        <div class="btn-group" role="group" aria-label="Status filter">
                                            <input type="radio" class="btn-check cu-rounded" name="cityStatusFilter" id="statusAll" value="all" autocomplete="off" checked>
                                            <label class="btn btn-outline-secondary" for="statusAll"><i class="bi bi-ui-checks-grid me-1"></i>All</label>

                                            <input type="radio" class="btn-check cu-rounded" name="cityStatusFilter" id="statusActive" value="active" autocomplete="off">
                                            <label class="btn btn-outline-success mr-2" for="statusActive"><i class="bi bi-check-circle me-1"></i>Active</label>

                                            <input type="radio" class="btn-check" name="cityStatusFilter" id="statusInactive" value="inactive" autocomplete="off">
                                            <label class="btn btn-outline-danger" for="statusInactive"><i class="bi bi-x-circle me-1"></i>Inactive</label>
                                        </div>
                                        <button type="button" id="resetCityFilters" class="btn btn-outline-secondary cu-rounded">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div id="cityActiveFilters" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="cu-rounded">
                    <div class="tile-body">
                        <div id="cityNoResults" class="d-none">
                            <div class="alert alert-light border d-flex justify-content-between align-items-center cu-rounded">
                                <div><i class="bi bi-exclamation-circle text-warning me-2"></i>No cities match your filters.</div>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="clearFiltersBtn"><i class="bi bi-x-circle me-1"></i> Clear</button>
                            </div>
                        </div>
                        <div class="cities row row-cols-1 row-cols-md-1 row-cols-lg-3 g-4 cu-rounded">

                            {{-- foreach to fetch all cities --}}
                            @foreach ($cities as $city)
                                <div class="tr city-card" data-city-name="{{ $city->name }}" data-city-status="{{ $city->status ? 'active' : 'inactive' }}">

                                    {{-- city card --}}
                                    <div class="card h-100 cu-rounded" id="city-{{ $city->id }}">

                                        <div class="card-img-container cu-rounded">
                                            <img src="{{ $city->image_url }}" class="card-img-top cu-rounded"
                                                alt="Random" />
                                        </div>

                                        <div class="card-body">

                                            {{-- title --}}
                                            <div class="info d-flex justify-content-between mb-1 align-items-center">
                                                <div class="card-title mb-0">
                                                    <small class="text-muted">{{ $city->formatted_created_at }}</small>
                                                    <h5 class="card-title">
                                                        {{ $city->name }},{{ $city->country }}
                                                    </h5>
                                                </div>

                                                <span
                                                    class="badge {{ $city->status ? 'bg-success' : 'bg-danger' }} cu-rounded">{{ $city->status ? 'Active' : 'Inactive' }}</span>
                                            </div>

                                            {{-- Hotels and event --}}
                                            <p class="card-text text-muted mb-1">
                                                <i class="bi bi-buildings-fill fs-5"></i>
                                                <a href="#" class="text-decoration-none text-muted">
                                                    {{ $city->hotels_count }} Hotels,
                                                    {{ $city->hotels->pluck('bookings')->flatten()->count() }} Guests
                                                </a>
                                            </p>

                                            <p class="card-text text-muted mt-1 mb-1">
                                                <i class="bi bi bi-calendar-event-fill fs-5"></i>
                                                <a href="#" class="text-decoration-none text-muted">
                                                    {{ $city->events_count }} Events,
                                                    {{ $city->events->pluck('tickets')->flatten()->count() }} tickets
                                                </a>
                                            </p>

                                            {{-- btns for city --}}
                                            <div class="card-tail mt-3">
                                                <a href="#" data-city-id="{{ $city->id }}"
                                                    data-url="{{ route('dashboard.city.show', $city) }}"
                                                    class="btn btn-primary d-block w-100 cu-rounded view-city-btn">
                                                    <i class="bi bi-eye-fill fs-5"></i>View Details</a>
                                                <div class="manages-btn mt-3 d-flex justify-content-center">

                                                    <form class="d-inline" method="post"
                                                        action="{{ route('dashboard.city.destroy', $city) }}">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="btn btn-outline-danger btn-delete ms-3 me-3 cu-rounded">
                                                            <i class="bi bi-trash3"></i>
                                                            Delete
                                                        </button>
                                                    </form>

                                                    <a href="{{ route('dashboard.city.edit', $city) }}"
                                                        class="btn btn-outline-secondary cu-rounded">
                                                        <i class="bi bi-pen"></i>Edit
                                                    </a>
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
        </div>

        <!-- Modal (add at bottom of your Blade) -->
        <div class="modal fade" id="cityPreviewModal" tabindex="-1" aria-labelledby="cityPreviewModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cityPreviewModalLabel">City Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="cityPreviewContent">
                        <!-- Hotels and events will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

    </main>

    @section('scripts')
        <script src="{{ asset('dashboards/js/city.js') }}"></script>
    @endsection

</x-dashboard.layouts>
