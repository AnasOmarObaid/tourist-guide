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
                                          <a href="{{ route('dashboard.event.create') }}"
                                                class="btn btn-primary cu-rounded">
                                                <i class="bi bi-plus"></i>Create Event
                                          </a>
                                    </div>
                              </div>
                        </div>
                  </div>

                  <div class="col-12">
                        <div class="tile cu-rounded border shadow-sm w-100">
                              <div class="tile-body">
                                    <div class="filter-card">
                                          <span id="ticketResultsCount" class="badge bg-light border align-self-center text-success">Showing 0 of 0</span>
                                          <div class="row g-2 mt-2">

                                                <div class="col-12 col-lg-8">
                                                      <div class="position-relative">
                                                            <span class="position-absolute top-50 translate-middle-y ms-3 text-muted"><i class="bi bi-search"></i></span>
                                                            <input type="text" id="ticketSearch" class="form-control ps-5 rounded-pill" placeholder="Search by event or user..." aria-label="Search tickets">
                                                      </div>
                                                </div>

                                                <div class="col-12 col-lg-4">
                                                      <div class="d-flex flex-wrap align-items-center gap-2 float-lg-end">
                                                            <div class="btn-group" role="group" aria-label="Status filter">
                                                                  <input type="radio" class="btn-check cu-rounded" name="ticketStatusFilter" id="statusAllTicket" value="all" autocomplete="off" checked>
                                                                  <label class="btn btn-outline-secondary" for="statusAllTicket"><i class="bi bi-ui-checks-grid me-1"></i>All</label>

                                                                  <input type="radio" class="btn-check cu-rounded" name="ticketStatusFilter" id="statusValid" value="valid" autocomplete="off">
                                                                  <label class="btn btn-outline-success mr-2" for="statusValid"><i class="bi bi-check-circle me-1"></i>Valid</label>

                                                                  <input type="radio" class="btn-check" name="ticketStatusFilter" id="statusUsed" value="used" autocomplete="off">
                                                                  <label class="btn btn-outline-warning" for="statusUsed"><i class="bi bi-check2-square me-1"></i>Used</label>

                                                                  <input type="radio" class="btn-check" name="ticketStatusFilter" id="statusCanceled" value="canceled" autocomplete="off">
                                                                  <label class="btn btn-outline-danger" for="statusCanceled"><i class="bi bi-x-circle me-1"></i>Canceled</label>
                                                            </div>
                                                            <button type="button" id="resetTicketFilters" class="btn btn-outline-secondary cu-rounded">
                                                                  <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                                                            </button>
                                                      </div>
                                                </div>

                                          </div>

                                          <div id="ticketActiveFilters" class="mt-2"></div>
                                    </div>
                              </div>
                        </div>
                  </div>

                  <div class="col-12">
                        <div class="tile-body">
                              <div id="ticketNoResults" class="d-none">
                                    <div class="alert alert-light border d-flex justify-content-between align-items-center cu-rounded">
                                          <div><i class="bi bi-exclamation-circle text-warning me-2"></i>No tickets match your filters.</div>
                                          <button type="button" class="btn btn-sm btn-outline-secondary" id="clearTicketFiltersBtn"><i class="bi bi-x-circle me-1"></i> Clear</button>
                                    </div>
                              </div>
                              <div class="tickets row row-cols-1 row-cols-xl-3 g-4">
                                    {{-- foreach to fetch all Ticket --}}
                                    @foreach ($tickets as $ticket)
                                          <div class="col-lg-4 col-md-12 h-100 tr" data-event-name="{{ $ticket->event->title }}" data-user-name="{{ $ticket->user->full_name }}" data-ticket-status="{{ $ticket->status }}">
                                                <div
                                                      class="card ticket-card shadow-lg border-0 cu-rounded overflow-hidden">
                                                      {{-- event image--}}
                                                      <div class="ticket-header position-relative">
                                                            <img src="{{ $ticket->event->image_url }}"
                                                                  class="img-fluid w-100"
                                                                  style="height: 350px; object-fit: cover;"
                                                                  alt="Event">
                                                            <div class="overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-25">
                                                            </div>
                                                            <div
                                                                  class="ticket-title position-absolute bottom-0 start-0 p-3 text-white">
                                                                  <small class="mb-0 d-block">{{ $ticket->event->title }}</small>
                                                                  <small><i class="bi bi-geo-alt-fill text-danger"></i> {{ $ticket->event->city->name }}, {{ $ticket->event->venue }}</small>
                                                            </div>
                                                      </div>

                                                      {{-- Ticket body--}}
                                                      <div class="card-body p-4">
                                                            <div
                                                                  class="d-flex justify-content-between align-items-center mb-3">
                                                                  <div>
                                                                        <small class="fw-bold mb-1">Ticket Holder
                                                                        </small>
                                                                        <div class="d-flex align-items-center">
                                                                              <img src="{{ asset($ticket->user->getImagePath()) }}"
                                                                                    class="cu-rounded border me-2"
                                                                                    style="width: 45px; height: 45px; object-fit: cover;"
                                                                                    alt="User">
                                                                              <span class="fw-semibold">{{ $ticket->user->full_name }}</span>
                                                                        </div>
                                                                  </div>
                                                                  <span
                                                                        class="badge {{ $ticket->status == 'valid' ? 'bg-success' : ($ticket->status == 'used' ? 'bg-warning' : 'bg-danger') }} px-3 py-2 cu-rounded">{{ ucfirst($ticket->status) }}</span>
                                                            </div>

                                                            <div class="row text-muted mb-3">
                                                                  <div class="col-6">
                                                                        <small>Order Number</small>
                                                                        <p class="fw-bold mb-0 text-success">
                                                                              {{ $ticket->order->order_number }}</p>
                                                                  </div>
                                                                  <div class="col-6 text-end">
                                                                        <small>Date</small>
                                                                        <p class="fw-bold mb-0">{{ $ticket->formatted_created_at }}</p>
                                                                  </div>
                                                            </div>

                                                            {{-- Barcode / QR --}}
                                                            <div class="text-center border-top">
                                                                  <img src="{{ asset('storage/uploads/images/tickets/ticket.png') }}"
                                                                        alt="QR Code" class="img-fluid"
                                                                        style="max-height: 75px;">
                                                                  <p class="text-muted small" style="margin-top: -20px;margin-bottom: 0;">
                                                                        {{ $ticket->barcode }}</p>
                                                            </div>
                                                      </div>
                                                </div>

                                          </div>
                                    @endforeach
                              </div>
                             <div class="mt-5 float-end">
                                {{ $tickets->links() }}
                             </div>

                        </div>
                  </div>

            </div>
      </main>

      @section('scripts')
            <script src="{{ asset('dashboards/js/ticket.js') }}"></script>
      @endsection

</x-dashboard.layouts>
