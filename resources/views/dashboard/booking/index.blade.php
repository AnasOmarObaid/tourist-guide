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
                        <li class="breadcrumb-item active">Bookings</li>
            </ul>
        </div>

        <div class="row">

            <div class="col-12">
                <div class="tile cu-rounded border shadow-sm w-100">
                    <div class="tile-body">
                        <div class="filter-card">
                            <span id="bookingResultsCount" class="badge bg-light border align-self-center text-success">Showing {{ $bookings->count() }} of {{ $bookings->total() }}</span>
                            <div class="row g-2 mt-2">

                                <div class="col-12 col-lg-8">
                                    <div class="position-relative">
                                        <span class="position-absolute top-50 translate-middle-y ms-3 text-muted"><i class="bi bi-search"></i></span>
                                        <input type="text" id="bookingSearch" class="form-control ps-5 rounded-pill" placeholder="Search by hotel, user, or order..." aria-label="Search bookings" value="{{ request('q') }}">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="d-flex flex-wrap align-items-center gap-2 float-lg-end">
                                        <div class="btn-group" role="group" aria-label="Status filter">
                                            <input type="radio" class="btn-check cu-rounded" name="bookingStatusFilter" id="statusAllBooking" value="all" autocomplete="off" {{ empty(request('statuses')) ? 'checked' : '' }}>
                                            <label class="btn btn-outline-secondary" for="statusAllBooking"><i class="bi bi-ui-checks-grid me-1"></i>All</label>

                                            <input type="radio" class="btn-check cu-rounded" name="bookingStatusFilter" id="statusConfirmed" value="confirmed" autocomplete="off" {{ in_array('confirmed', request('statuses', [])) ? 'checked' : '' }}>
                                            <label class="btn btn-outline-success mr-2" for="statusConfirmed"><i class="bi bi-check-circle me-1"></i>Confirmed</label>

                                            <input type="radio" class="btn-check" name="bookingStatusFilter" id="statusPending" value="pending" autocomplete="off" {{ in_array('pending', request('statuses', [])) ? 'checked' : '' }}>
                                            <label class="btn btn-outline-warning" for="statusPending"><i class="bi bi-clock me-1"></i>Pending</label>

                                            <input type="radio" class="btn-check" name="bookingStatusFilter" id="statusCanceled" value="canceled" autocomplete="off" {{ in_array('canceled', request('statuses', [])) ? 'checked' : '' }}>
                                            <label class="btn btn-outline-danger" for="statusCanceled"><i class="bi bi-x-circle me-1"></i>Canceled</label>
                                        </div>
                                        <button type="button" id="resetBookingFilters" class="btn btn-outline-secondary cu-rounded">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                        </button>
                                    </div>
                                </div>

                            </div>

                            <div id="bookingActiveFilters" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="tile-body">
                    <div id="bookingNoResults" class="d-none">
                        <div class="alert alert-light border d-flex justify-content-between align-items-center cu-rounded">
                            <div><i class="bi bi-exclamation-circle text-warning me-2"></i>No bookings match your filters.</div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="clearBookingFiltersBtn"><i class="bi bi-x-circle me-1"></i> Clear</button>
                        </div>
                    </div>
                    <div class="bookings row row-cols-1 row-cols-xl-3 g-4">
                        {{-- foreach to fetch all Bookings --}}
                        @foreach ($bookings as $booking)
                            <div class="col-lg-4 col-md-12 h-100 tr" data-hotel-name="{{ $booking->hotel->name }}" data-user-name="{{ $booking->user->full_name }}" data-order-number="{{ $booking->order->order_number }}" data-booking-status="{{ $booking->status }}">
                                <div class="card booking-card shadow-lg border-0 cu-rounded overflow-hidden">
                                    {{-- Hotel Cover --}}
                                    <div class="booking-header position-relative">
                                        <img src="{{ $booking->hotel->cover_url }}"
                                            class="img-fluid w-100"
                                            style="height: 250px; object-fit: cover;"
                                            alt="Hotel">
                                        <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25"></div>
                                        <div class="booking-title position-absolute bottom-0 start-0 p-3 text-white">
                                            <small class="mb-0 d-block">{{ $booking->hotel->name }}</small>
                                            <small><i class="bi bi-geo-alt-fill text-danger"></i> {{ $booking->hotel->city->name }}, {{ $booking->hotel->venue }}</small>
                                        </div>
                                    </div>

                                    {{-- Booking Body --}}
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <small class="fw-bold mb-1">Booked by</small>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset($booking->user->getImagePath()) }}"
                                                        class="cu-rounded border me-2"
                                                        style="width: 45px; height: 45px; object-fit: cover;"
                                                        alt="User">
                                                    <span class="fw-semibold">{{ $booking->user->full_name }}</span>
                                                </div>
                                            </div>
                                            @php
                                                $statusClass = match($booking->status) {
                                                    'confirmed' => 'bg-success',
                                                    'pending' => 'bg-warning',
                                                    'canceled' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                            @endphp
                                            <span class="badge {{ $statusClass }} px-3 py-2 cu-rounded">{{ ucfirst($booking->status) }}</span>
                                        </div>

                                        <div class="row text-muted mb-3">
                                            <div class="col-6">
                                                <small>Order Number</small>
                                                <p class="fw-bold mb-0 text-success">{{ $booking->order->order_number }}</p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small>Total Price</small>
                                                <p class="fw-bold mb-0">${{ $booking->total_price }}</p>
                                            </div>
                                        </div>

                                        <div class="row text-muted mb-3">
                                            <div class="col-6">
                                                <small>Check-in</small>
                                                <p class="fw-bold mb-0 text-success">{{ $booking->formatted_check_in }}</p>
                                            </div>
                                            <div class="col-6 text-end">
                                                <small>Check-out</small>
                                                <p class="fw-bold mb-0 text-danger">{{ $booking->formatted_check_out }}</p>
                                            </div>
                                        </div>

                                        {{-- QR Code --}}
                                        <div class="text-center border-top">
                                            <img src="{{ asset('storage/uploads/images/tickets/ticket.png') }}"
                                                alt="QR Code" class="img-fluid"
                                                style="max-height: 75px;">
                                            <p class="text-muted small" style="margin-top: -20px;margin-bottom: 0;">
                                                {{ $booking->order->order_number }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-5 float-end">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>

        </div>
    </main>

    @section('scripts')
        <script src="{{ asset('dashboards/js/booking.js') }}"></script>
    @endsection

</x-dashboard.layouts>
