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
                        <div class="tile cu-rounded">
                              <div class="tile-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                          <a href="{{ route('dashboard.city.create') }}"
                                                class="btn btn-primary cu-rounded">
                                                <i class="bi bi-plus"></i>Create City
                                          </a>
                                    </div>
                              </div>
                        </div>
                  </div>
                  <div class="col-12">
                        <div class="">
                              <div class="tile-body">
                                    <div class="cities row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 cu-rounded">

                                          {{-- foreach to fetch all cities --}}
                                          @foreach ($cities as $city)
                                                <div class="tr">
                                                      {{-- city card --}}
                                                      <div class="card h-100 cu-rounded" id="city-{{ $city->id }}">
                                                            <div class="card-img-container cu-rounded">
                                                                  <img src="{{ $city->image_url }}"
                                                                        class="card-img-top cu-rounded"
                                                                        alt="Random" />
                                                            </div>
                                                            <div class="card-body">
                                                                  <div class="info d-flex justify-content-between mb-1"
                                                                        style="align-items: baseline;">
                                                                        <h5 class="card-title">
                                                                              {{ $city->name }},{{ $city->country }}
                                                                        </h5>
                                                                        <small
                                                                              class="card-title">{{ $city->formatted_created_at }}</small>
                                                                  </div>
                                                                  @if ($city->status)
                                                                        <span class="badge bg-success cu-rounded">Active</span>
                                                                  @else
                                                                        <span class="badge bg-danger cu-rounded">Inactive</span>
                                                                  @endif
                                                                  <p class="card-text mt-2">Hotel (3)</p>
                                                                  <div class="card-tail mt-3">
                                                                        <a href="#"
                                                                              class="btn btn-primary d-block w-100 cu-rounded"><i
                                                                                    class="bi bi-diagram-3 fs-5"></i>Manage
                                                                              City</a>
                                                                        <div
                                                                              class="manages-btn mt-3 d-flex justify-content-center">

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
      </main>

</x-dashboard.layouts>
