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
                        <li class="breadcrumb-item active"><a href="{{ route('dashboard.event.index') }}">Events</a>
                        </li>
                        <li class="breadcrumb-item">Create Event</li>
                  </ul>

            </div>

            {{-- create event  --}}
            <div class="row mb-4">

                  <div class="col-12 col-lg-6">
                        <div class="tile cu-rounded">
                              <div class="tile-body">
                                    <form class="form" method="POST" action="{{ route('dashboard.event.store') }}"
                                          enctype="multipart/form-data">
                                          @method('POST')
                                          @csrf

                                          {{-- image filed --}}
                                          <label class="control-label mb-2">Upload Image</label>
                                          <div class="form-image mb-3 d-flex @error('image') border-color-red @enderror"
                                                onclick="document.getElementById('event_image').click()"
                                                style="height: 180px;border: 1px solid;align-items: center;justify-content: space-around; cursor: pointer;">
                                                <div class="icon"><i class="bi bi-image fs-1"></i></div>
                                          </div>
                                          <input type="file" name="image" id="event_image" accept="image/*"
                                                style="display: none;">

                                          {{-- price filed --}}
                                          <div class="mb-3">
                                                <label class="form-label">Price</label>
                                                <input class="form-control @error('price') is-invalid  @enderror"
                                                      type="number" id="price" name="price" step="0.01"
                                                      value="{{ old('price') }}" placeholder="Price">
                                                @error('price')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- title field --}}
                                          <div class="mb-3">
                                                <label class="form-label">Title</label>
                                                <input class="form-control @error('title') is-invalid  @enderror"
                                                      type="text" id="title" name="title"
                                                      value="{{ old('title') }}" placeholder="Title">
                                                @error('title')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- City filed --}}
                                          <div class="mb-3">
                                                <label class="form-label">City</label>
                                                <select class="form-select @error('city_id') is-invalid  @enderror"
                                                      name="city_id" id="city_id">
                                                      <option value=""></option>
                                                      @foreach ($cities as $city)
                                                            <option value="{{ $city->id }}"
                                                                  {{ old('city_id') == $city->id ? 'selected' : '' }}>
                                                                  {{ $city->name }}
                                                            </option>
                                                      @endforeach
                                                </select>
                                                @error('city_id')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- venue field and organizer --}}
                                          <div class="mb-3 row">
                                                <div class="col">
                                                      <label class="form-label">Venue</label>
                                                      <input class="form-control @error('venue') is-invalid  @enderror"
                                                            type="text" id="venue" name="venue"
                                                            value="{{ old('venue') }}" placeholder="Venue">
                                                      @error('venue')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                <div class="col">
                                                      <label class="form-label">Organizer</label>
                                                      <input class="form-control @error('organizer') is-invalid  @enderror"
                                                            type="text" id="organizer" name="organizer"
                                                            value="{{ old('organizer') }}" placeholder="Organizer">
                                                      @error('venue')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>
                                          </div>

                                          {{-- description field --}}
                                          <div class="mb-3">
                                                <label for="form-label">Description</label>
                                                <textarea class="form-control @error('description') is-invalid  @enderror" id="description" name="description"
                                                      placeholder="Description" rows="5">{{ old('description') }}</textarea>
                                                @error('description')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- start at and end at date --}}
                                          <div class="mb-3 row">
                                                <div class="col">
                                                      <label for="form-label">Start at</label>
                                                      <input class="form-control @error('start_at') is-invalid  @enderror"
                                                            type="datetime" id="start_at" name="start_at"
                                                            value="{{ old('start_at') }}" placeholder="Start At">
                                                      @error('start_at')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>
                                                <div class="col">
                                                      <label for="form-label">End At</label>
                                                      <input class="form-control @error('end_at') is-invalid  @enderror"
                                                            type="datetime" id="end_at" name="end_at"
                                                            value="{{ old('end_at') }}" placeholder="End At">
                                                      @error('end_at')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>
                                          </div>

                                          {{-- lat & lng filed in same row --}}
                                          <div class="mt-3 mb-3 row">
                                                <div class="col">
                                                      <label for="form-label">Latitude</label>
                                                      <input class="form-control @error('lat') is-invalid  @enderror"
                                                            type="text" id="latitude" name="lat"
                                                            value="{{ old('lat') }}" placeholder="Latitude">
                                                      @error('lat')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>
                                                <div class="col">
                                                      <label for="form-label">Longitude</label>
                                                      <input class="form-control @error('lng') is-invalid  @enderror"
                                                            type="text" id="longitude" name="lng"
                                                            value="{{ old('lng') }}" placeholder="Longitude">
                                                      @error('lng')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>
                                          </div>

                                          {{-- set tags for event --}}
                                          <div class="mb-3">
                                                <label class="form-label">Tags</label>
                                                <select name="tags[]" class="form-select" id="tags_id" multiple>
                                                      <option value="">Select Tags</option>
                                                      @foreach ($tags as $tag)
                                                            <option value="{{ $tag->id }}"
                                                                  {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                                                                  {{ $tag->name }}
                                                            </option>
                                                      @endforeach
                                                </select>
                                                @error('tags')
                                                      <small class="invalid-feedback"
                                                            role="alert"><strong>{{ $message }}</strong></small>
                                                @enderror
                                          </div>

                                          {{-- mark as a available or not --}}
                                          <div class="mb-3 form-check">
                                                <input class="form-check-input" type="checkbox" id="status"
                                                      name="status" value="1" checked>
                                                <label class="form-check-label" for="status">
                                                      Mark as a available event
                                                </label>
                                          </div>

                                          {{--  submit --}}
                                          <div class="tile-footer text-center">
                                                <button class="btn btn-primary w-100 mb-0"
                                                      style="border-radius: 1.5rem;" type="submit">
                                                      <i class="bi bi-check-circle-fill"></i>Create Event
                                                </button>
                                          </div>

                                    </form>
                              </div>
                        </div>
                  </div>

                  {{-- Event preview --}}
                  <div class="col">
                        {{-- event card --}}
                        <div class="card event-card">
                              <div class="event-image">
                                    <img id="previewImage" src="{{ asset('https://placehold.co/350x350/') }}"
                                          alt="Event">
                                    <div class="attendees users-stack">
                                          <img src="https://i.pravatar.cc/40?img=1" alt="User1">
                                          <img src="https://i.pravatar.cc/40?img=2" alt="User2">
                                          <img src="https://i.pravatar.cc/40?img=3" alt="User3">
                                    </div>
                              </div>

                              <div class="event-body">
                                    <div class="d-flex justify-content-between align-items-baseline">
                                          <div class="price-tag" id="price_preview">${{ old('price') }}</div>
                                          <p class="status-badge status-badge-success" id="status_preview">
                                                {{ old('status', 'Active') ? 'Active' : '' }}</p>
                                    </div>
                                    <h5 class="card-title" id="title_preview">{{ old('title') }}</h5>
                                    <p class="text-muted mb-1"><i class="bi bi-geo-alt-fill text-danger"></i> <span
                                                id="city_preview"></span> <span id="venue_preview"></span></p>
                                    <p class="text-secondary" id="description_preview">{{ old('description') }}</p>
                                    <div>
                                          <div id="tags_preview">
                                                {{-- <span class="tag-badge" >{{ $tag }}</span> --}}
                                          </div>

                                          <div class="details mt-3"><span>👤</span>
                                                <span id="organizer_preview">{{ old('organizer') }}</span>
                                          </div>
                                          <div class="details text-success mt-3"><span>📅</span> Start:
                                                <span id="start_at_preview"> {{ old('start_at') }}</span>
                                          </div>
                                          <div class="details text-danger"><span>📅</span> End:
                                                <span id="end_at_preview">{{ old('end_at') }}</span>
                                          </div>
                                    </div>

                              </div>

                        </div>
                  </div>

            </div>
      </main>

      @section('scripts')
            <script src="{{ asset('dashboards/js/city.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

            {{-- data time  --}}
            <script>
                  $("#start_at").flatpickr({
                        enableTime: true,
                        minDate: "today",
                  });

                  $("#end_at").flatpickr({
                        enableTime: true,
                        minDate: "today",
                  });
            </script>

            {{-- select2 --}}
            <script>
                  $(document).ready(function() {
                        $('#city_id').select2({
                              placeholder: 'Select a city'
                        });
                  });

                  $(document).ready(function() {
                        $('#tags_id').select2({
                              placeholder: 'Select tags'
                        });
                  });
            </script>

            {{-- live preview --}}
            <script>
                  $(document).ready(function() {
                        // live image preview
                        $('#event_image').on('change', function(e) {
                              const file = e.target.files[0];
                              if (file) {
                                    const reader = new FileReader();
                                    reader.onload = function(e) {
                                          $('#previewImage').attr('src', e.target.result);
                                    };
                                    reader.readAsDataURL(file);
                              }
                        });

                        // live title preview
                        $("#title").on('input', function() {
                              $('#title_preview').text($(this).val() || "");
                        });

                        // live description preview
                        $("#description").on('input', function() {
                              $('#description_preview').text($(this).val() || "");
                        });

                        // live start_at preview
                        $("#start_at").on('input', function() {
                              $('#start_at_preview').text($(this).val() || "");
                        });

                        // live end_at preview
                        $("#end_at").on('input', function() {
                              $('#end_at_preview').text($(this).val() || "");
                        });

                        // live city preview
                        $("#city_id").on('change', function() {
                              $('#city_preview').text($(this).find("option:selected").text() || "");
                        });

                        // live venue preview
                        $("#venue").on('input', function() {
                              $('#venue_preview').text($(this).val() || "");
                        });

                        // live price preview
                        $("#price").on('input', function() {
                              $('#price_preview').text("$" + $(this).val() || "");
                        });

                        // live organizer preview
                        $("#organizer").on('input', function() {
                              $('#organizer_preview').text($(this).val() || "");
                        });

                        // live tags preview, append tags when select in multi tag
                        $("#tags_id").on('change', function() {
                              $('#tags_preview').empty();
                              $(this).find("option:selected").each(function() {
                                    $('#tags_preview').append(
                                          `<span class="tag-badge">${$(this).text()}</span>`
                                          );
                              });
                        });

                        // Status checkbox
                        $('input[name="status"]').on('change', function() {

                              // Toggle the checkbox value
                              $(this).data('value', $(this).is(':checked') ? '1' : '0');

                              // Update the preview status class to set or remove bg-success or bg-danger
                              if ($(this).data('value') == '1') {
                                    $('#status_preview').text("Active");
                                    $('#status_preview').removeClass('status-badge-danger').addClass(
                                          'status-badge-success');
                              } else {
                                    $('#status_preview').text("Cancelled");
                                    $('#status_preview').removeClass('status-badge-success').addClass(
                                          'status-badge-danger');
                              }

                        });
                  });
            </script>
      @endsection
</x-dashboard.layouts>
