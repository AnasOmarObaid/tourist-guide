<x-dashboard.layouts>
      <main class="app-content">
            <div class="app-title">
                  <div>
                        <h1><i class="bi bi-speedometer"></i> Dashboard </h1>
                        <p>Enjoy a powerful and modern control panel for project management.</p>
                  </div>
                  <ul class="app-breadcrumb breadcrumb">
                        <li class="breadcrumb-item"><i class="bi bi-house-door fs-6"></i></li>
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                  </ul>
            </div>
            <div class="row">
                  <div class="col-md-6 col-lg-3">
                        <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
                              <div class="info">
                                    <h4>Users</h4>
                                    <p><b>{{ $usersCount }}</b></p>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                        <div class="widget-small info coloured-icon"><i class="icon bi bi-building fs-1"></i>
                              <div class="info">
                                    <h4>Cities</h4>
                                    <p><b>{{ $citiesCount }}</b></p>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                        <div class="widget-small warning coloured-icon"><i class="icon bi bi-receipt fs-1"></i>
                              <div class="info">
                                    <h4>Tickets</h4>
                                    <p><b>{{ $ticketsCount }}</b></p>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-6 col-lg-3">
                        <div class="widget-small danger coloured-icon"><i class="icon bi bi-bookmark-check fs-1"></i>
                              <div class="info">
                                    <h4>Bookings</h4>
                                    <p><b>{{ $bookingsCount }}</b></p>
                              </div>
                        </div>
                  </div>
            </div>
            <div class="row mt-3">
                  <div class="col-md-4 col-lg-4">
                        <div class="tile cu-rounded">
                              <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                          <h6 class="mb-0">Revenue Today</h6>
                                          <small class="text-muted">Paid orders</small>
                                    </div>
                                    <div class="text-success fw-bold fs-4">${{ number_format($revenueToday, 2) }}</div>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                        <div class="tile cu-rounded">
                              <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                          <h6 class="mb-0">Revenue This Month</h6>
                                          <small class="text-muted">Paid orders</small>
                                    </div>
                                    <div class="text-primary fw-bold fs-4">${{ number_format($revenueThisMonth, 2) }}</div>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-4 col-lg-4">
                        <div class="tile cu-rounded">
                              <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                          <h6 class="mb-0">Avg Order Value</h6>
                                          <small class="text-muted">All paid orders</small>
                                    </div>
                                    <div class="text-warning fw-bold fs-4">${{ number_format($avgOrderValue, 2) }}</div>
                              </div>
                        </div>
                  </div>
            </div>

            <div class="row mt-3">
                  <div class="col-md-6">
                        <div class="tile cu-rounded">
                              <h3 class="tile-title">Monthly Revenue (Tickets vs Bookings)</h3>
                              <div class="ratio ratio-16x9">
                                    <div id="revenueChart"></div>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-6">
                        <div class="tile cu-rounded">
                              <h3 class="tile-title">Orders (last 7 days)</h3>
                              <div class="ratio ratio-16x9">
                                    <div id="ordersChart"></div>
                              </div>
                        </div>
                  </div>
            </div>

            <div class="row mt-3">
                  <div class="col-md-6">
                        <div class="tile cu-rounded">
                              <h3 class="tile-title">Booking Status Distribution</h3>
                              <div class="ratio ratio-16x9">
                                    <div id="statusChart"></div>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-6">
                        <div class="tile cu-rounded">
                              <h3 class="tile-title">Top Cities</h3>
                              <div class="row">
                                    <div class="col-6">
                                          <h6>By Tickets</h6>
                                          <ul class="list-group list-group-flush">
                                                @foreach ($topCitiesTickets as $c)
                                                      <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ $c->name }}
                                                            <span class="badge bg-primary rounded-pill">{{ $c->count }}</span>
                                                      </li>
                                                @endforeach
                                          </ul>
                                    </div>
                                    <div class="col-6">
                                          <h6>By Bookings</h6>
                                          <ul class="list-group list-group-flush">
                                                @foreach ($topCitiesBookings as $c)
                                                      <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            {{ $c->name }}
                                                            <span class="badge bg-success rounded-pill">{{ $c->count }}</span>
                                                      </li>
                                                @endforeach
                                          </ul>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>

            <div class="row mt-3">
                  <div class="col-md-12">
                        <div class="tile cu-rounded">
                              <h3 class="tile-title">Latest 10 Bookings</h3>
                              <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                          <thead class="table-light">
                                                <tr>
                                                      <th>#</th>
                                                      <th>Order</th>
                                                      <th>User</th>
                                                      <th>Hotel</th>
                                                      <th>Dates</th>
                                                      <th class="text-end">Total</th>
                                                      <th>Status</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach ($latestBookings as $index => $b)
                                                      <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td><code>{{ $b->order->order_number }}</code></td>
                                                            <td>
                                                                  <div class="d-flex align-items-center">
                                                                        <img src="{{ asset($b->user->getImagePath()) }}" class="rounded-circle me-2" width="36" height="36" style="object-fit:cover" alt="user">
                                                                        <div>
                                                                              <div class="fw-semibold">{{ $b->user->full_name }}</div>
                                                                              <small class="text-muted">{{ $b->user->email }}</small>
                                                                        </div>
                                                                  </div>
                                                            </td>
                                                            <td>
                                                                  <div class="d-flex align-items-center">
                                                                        <img src="{{ $b->hotel->cover_url }}" class="rounded me-2" width="48" height="32" style="object-fit:cover" alt="hotel">
                                                                        <div>
                                                                              <div class="fw-semibold">{{ $b->hotel->name }}</div>
                                                                              <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $b->hotel->city->name }}</small>
                                                                        </div>
                                                                  </div>
                                                            </td>
                                                            <td>
                                                                  <small class="text-success d-block"><i class="bi bi-calendar-check"></i> {{ $b->formatted_check_in }}</small>
                                                                  <small class="text-danger"><i class="bi bi-calendar-x"></i> {{ $b->formatted_check_out }}</small>
                                                            </td>
                                                            <td class="text-end fw-bold">${{ number_format($b->order->total_price, 2) }}</td>
                                                            <td>
                                                                  <span class="badge {{ $b->status === 'confirmed' ? 'bg-success' : ($b->status === 'pending' ? 'bg-warning' : 'bg-danger') }}">{{ ucfirst($b->status) }}</span>
                                                            </td>
                                                      </tr>
                                                @endforeach
                                          </tbody>
                                    </table>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-12">
                        <div class="tile cu-rounded">
                              <h3 class="tile-title">Latest 10 Tickets</h3>
                              <div class="table-responsive">
                                    <table class="table table-striped table-hover align-middle">
                                          <thead class="table-light">
                                                <tr>
                                                      <th>#</th>
                                                      <th>Order</th>
                                                      <th>User</th>
                                                      <th>Event</th>
                                                      <th>When</th>
                                                      <th class="text-end">Total</th>
                                                      <th>Status</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach ($latestTickets as $index => $t)
                                                      <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td><code>{{ $t->order->order_number }}</code></td>
                                                            <td>
                                                                  <div class="d-flex align-items-center">
                                                                        <img src="{{ asset($t->user->getImagePath()) }}" class="rounded-circle me-2" width="36" height="36" style="object-fit:cover" alt="user">
                                                                        <div class="fw-semibold">{{ $t->user->full_name }}</div>
                                                                  </div>
                                                            </td>
                                                            <td>
                                                                  <div class="d-flex align-items-center">
                                                                        <img src="{{ $t->event->image_url }}" class="rounded me-2" width="48" height="32" style="object-fit:cover" alt="event">
                                                                        <div>
                                                                              <div class="fw-semibold">{{ $t->event->title }}</div>
                                                                              <small class="text-muted"><i class="bi bi-geo-alt"></i> {{ $t->event->city->name }}</small>
                                                                        </div>
                                                                  </div>
                                                            </td>
                                                            <td><small class="text-muted">{{ $t->formatted_created_at }}</small></td>
                                                            <td class="text-end fw-bold">${{ number_format($t->order->total_price, 2) }}</td>
                                                            <td>
                                                                  <span class="badge {{ $t->status === 'valid' ? 'bg-success' : ($t->status === 'used' ? 'bg-warning' : 'bg-danger') }}">{{ ucfirst($t->status) }}</span>
                                                            </td>
                                                      </tr>
                                                @endforeach
                                          </tbody>
                                    </table>
                              </div>
                        </div>
                  </div>
            </div>
      </main>

      @section('scripts')
            <!-- Page specific javascripts-->
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
            <script type="text/javascript">
                  const months = @json($months);
                  const ticketRevenue = @json($ticketRevenue);
                  const bookingRevenue = @json($bookingRevenue);

                  const bookingStatusCounts = @json($bookingStatusCounts);
                  const ordersDays = @json($ordersDays);
                  const ordersTickets = @json($ordersTickets);
                  const ordersBookings = @json($ordersBookings);

                  const revenueOption = {
                        tooltip: { trigger: 'axis' },
                        legend: { data: ['Tickets', 'Bookings'] },
                        xAxis: { type: 'category', data: months },
                        yAxis: { type: 'value', axisLabel: { formatter: '${value}' } },
                        series: [
                              { name: 'Tickets', type: 'line', smooth: true, data: ticketRevenue },
                              { name: 'Bookings', type: 'line', smooth: true, data: bookingRevenue }
                        ]
                  };

                  const statusData = Object.entries(bookingStatusCounts).map(([name, value]) => ({ name: name.charAt(0).toUpperCase() + name.slice(1), value }));
                  const statusOption = {
                        tooltip: { trigger: 'item' },
                        legend: { orient: 'vertical', left: 'left' },
                        series: [{
                              name: 'Bookings',
                              type: 'pie',
                              radius: '55%',
                              data: statusData,
                              emphasis: { itemStyle: { shadowBlur: 10, shadowOffsetX: 0, shadowColor: 'rgba(0,0,0,0.4)' } }
                        }]
                  };

                  const revenueEl = document.getElementById('revenueChart');
                  const revenueChart = echarts.init(revenueEl, null, { renderer: 'svg' });
                  revenueChart.setOption(revenueOption);
                  new ResizeObserver(() => revenueChart.resize()).observe(revenueEl);

                  const statusEl = document.getElementById('statusChart');
                  const statusChart = echarts.init(statusEl, null, { renderer: 'svg' });
                  statusChart.setOption(statusOption);
                  new ResizeObserver(() => statusChart.resize()).observe(statusEl);

                  // Orders stacked bar
                  const ordersOption = {
                        tooltip: { trigger: 'axis' },
                        legend: { data: ['Tickets', 'Bookings'] },
                        xAxis: { type: 'category', data: ordersDays },
                        yAxis: { type: 'value' },
                        series: [
                              { name: 'Tickets', type: 'bar', stack: 'total', data: ordersTickets },
                              { name: 'Bookings', type: 'bar', stack: 'total', data: ordersBookings }
                        ]
                  };
                  const ordersEl = document.getElementById('ordersChart');
                  const ordersChart = echarts.init(ordersEl, null, { renderer: 'svg' });
                  ordersChart.setOption(ordersOption);
                  new ResizeObserver(() => ordersChart.resize()).observe(ordersEl);
            </script>
            <!-- Google analytics script-->
            <script type="text/javascript">
                  if (document.location.hostname == 'pratikborsadiya.in') {
                        (function(i, s, o, g, r, a, m) {
                              i['GoogleAnalyticsObject'] = r;
                              i[r] = i[r] || function() {
                                    (i[r].q = i[r].q || []).push(arguments)
                              }, i[r].l = 1 * new Date();
                              a = s.createElement(o),
                                    m = s.getElementsByTagName(o)[0];
                              a.async = 1;
                              a.src = g;
                              m.parentNode.insertBefore(a, m)
                        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
                        ga('create', 'UA-72504830-1', 'auto');
                        ga('send', 'pageview');
                  }
            </script>
      @endsection
</x-dashboard.layouts>
