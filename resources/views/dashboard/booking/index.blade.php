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
                <li class="breadcrumb-item active">Tickets</li>
            </ul>
        </div>

        <div class="row">

            <div class="col-12">
                <div class="tile" style="border-radius: 1.5rem;">
                    <div class="tile-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('dashboard.hotel.create') }}" class="btn btn-primary cu-rounded">
                                <i class="bi bi-plus"></i>Create Hotel
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="tile-body">
                    <div class="cities row row-cols-1 row-cols-xl-3 g-4">
                        {{-- foreach to fetch all Ticket --}}
                        @forelse($bookings as $group => $booking)
                            @php
                                $first = $booking->first();
                                $user = $first->order->user;
                                $hotel = $first->order->orderable;
                                $order = $first->order;
                                $totalBookings = $booking->count();
                                $totalPrice = $booking->sum('total_price');
                            @endphp
                            <div class="col-md-6 col-xl-4">
                                <div class="card booking-card shadow border-0 cu-rounded h-100 overflow-hidden">
                                    {{-- Hotel Cover --}}
                                    <img src="{{ $hotel->cover_url }}" class="card-img-top"
                                        style="height:200px; object-fit:cover;" alt="Cover Hotel">

                                    <div class="card-body py-3">

                                        {{-- Hotel Name & Owner --}}
                                        <h5 class="card-title mb-1">{{ $hotel?->name }}</h5>

                                        <div class="">
                                            <div class="position-relative">
                                                <div class="attendees users-stack position-relative mt-0 pt-0 bottom-0" style="left: 0">
                                                    @foreach ($first->hotel->attendees_images as $image)
                                                        <img style="width: 45px; height: 45px; object-fit: cover;" src="{{ asset($image) }}" alt="User1">
                                                    @endforeach
                                                </div>
                                            </div>

                                            {{-- Status Badge --}}
                                            {{-- @php
                                                $statusClass = match ($first->status) {
                                                    'confirmed' => 'success',
                                                    'pending' => 'warning',
                                                    'canceled' => 'danger',
                                                    default => 'secondary',
                                                };
                                            @endphp --}}
                                            {{-- <span class="badge cu-rounded bg-{{ $statusClass }} mb-3">{{ ucfirst($first->status) }}</span> --}}
                                        </div>

                                        <hr class="my-2">

                                        {{-- Order Info --}}
                                        <p class="mb-1"><i class="bi bi-hash text-primary"></i>
                                            <strong>Order:</strong> {{ $order->order_number }}
                                        </p>

                                        {{-- Booking Dates --}}
                                        <p class="mb-1"><i class="bi bi-calendar-check text-success"></i>
                                            Check-in: <strong>{{ $first->formatted_check_in }}</strong>
                                        </p>
                                        <p class="mb-1"><i class="bi bi-calendar-x text-danger"></i>
                                            Check-out: <strong>{{ $first->formatted_check_out }}</strong>
                                        </p>

                                        {{-- Guests & Price --}}
                                        <p class="mb-1"><i class="bi bi-people-fill text-info"></i>
                                            Guests: <strong>{{ $totalBookings }}</strong>
                                        </p>
                                        <p class="mb-3"><i class="bi bi-cash-coin text-warning"></i>
                                            Total:
                                            <strong>${{ $totalPrice }}</strong>
                                        </p>

                                        {{-- QR Code --}}
                                        <div class="text-center border-top">
                                            <img src="{{ asset('storage/uploads/images/tickets/ticket.png') }}"
                                                alt="QR Code" class="img-fluid" style="max-height: 75px;">
                                            <p class="text-muted small" style="margin-top: -20px;margin-bottom: 0;">
                                                {{ $order->order_number }}</p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">No bookings found.</p>
                        @endforelse
                    </div>
                    <div class="mt-5 float-end">
                        {{-- {{ $bookings->links() }} --}}
                    </div>

                </div>
            </div>

        </div>
    </main>

</x-dashboard.layouts>
