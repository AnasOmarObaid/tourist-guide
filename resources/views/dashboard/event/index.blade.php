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
                        <li class="breadcrumb-item active">Events</li>
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

</x-dashboard.layouts>
