<x-dashboard.layouts>

      @section('css')
            <link rel="stylesheet" href="{{ asset('dashboards/css/user.create.css') }}">
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
                        <li class="breadcrumb-item active"><a href="{{ route('dashboard.user.index') }}">Users</a></li>
                        <li class="breadcrumb-item">Edit User</li>
                  </ul>
            </div>
            <div class="row">

                  {{-- create user  --}}
                  <div class="row mb-4">
                        {{-- form --}}
                        <div class="col-12 col-lg-6">
                              <div class="tile">
                                    <div class="tile-body">
                                          <form class="form" method="POST" action="{{ route('dashboard.user.update', $user) }}"
                                                enctype="multipart/form-data">
                                                @method('PUT')
                                                @csrf

                                                {{-- image filed --}}
                                                <label class="control-label mb-2">Upload Image</label>
                                                <div class="form-image mb-3 d-flex"
                                                      onclick="document.getElementById('user_image').click()"
                                                      style="height: 180px;border: 1px solid;align-items: center;justify-content: space-around; cursor: pointer;">
                                                      <div class="icon">
                                                            <i class="bi bi-image fs-1"></i>
                                                      </div>
                                                </div>

                                                <input type="file" name="image" id="user_image" accept="image/*"
                                                      style="display: none;">

                                                {{-- Name field --}}
                                                <div class="mb-3">
                                                      <label class="form-label">Full Name</label>
                                                      <input class="form-control @error('full_name') is-invalid  @enderror"
                                                            type="text" id="full_name" name="full_name"
                                                            value="{{ old('full_name', $user->full_name) }}" placeholder="Full Name">
                                                      @error('full_name')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                {{-- Email field --}}
                                                <div class="mb-3">
                                                      <label class="form-label">Email</label>
                                                      <input class="form-control @error('email') is-invalid  @enderror"
                                                            type="email" id="email" name="email"
                                                            value="{{ old('email', $user->email) }}" placeholder="Email">
                                                      @error('email')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                {{-- phone number field --}}
                                                <div class="mb-3">
                                                      <label for="form-label">Phone Number</label>
                                                      <input class="form-control @error('phone') is-invalid  @enderror"
                                                            type="text" id="phone" name="phone"
                                                            value="{{ old('phone', $user->phone) }}" placeholder="Phone Number">
                                                      @error('phone')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                {{-- address field --}}
                                                <div class="mb-3">
                                                      <label for="form-label">Address</label>
                                                      <input class="form-control @error('address') is-invalid  @enderror"
                                                            type="text" id="address" name="address"
                                                            value="{{ old('address', $user->address) }}" placeholder="Address">
                                                      @error('address')
                                                            <small class="invalid-feedback"
                                                                  role="alert"><strong>{{ $message }}</strong></small>
                                                      @enderror
                                                </div>

                                                {{-- mark as a valid email check box --}}
                                                <div class="mb-3 form-check">
                                                      <input class="form-check-input" type="checkbox" id="validEmail"
                                                            name="email_verified_at" value="1" {{ old('email_verified_at', $user->email_verified_at) ? 'checked' : '' }}>
                                                      <label class="form-check-label" for="validEmail">
                                                            Mark as a valid email
                                                      </label>
                                                </div>

                                                <div class="tile-footer text-center">
                                                      <button class="btn btn-primary w-100 mb-0" type="submit"><i
                                                                  class="bi bi-check-circle-fill"></i>Edit User</button>
                                                </div>
                                          </form>
                                    </div>
                              </div>
                        </div>

                        {{-- User preview --}}
                        <div class="user col-12 col-lg-6">
                              <div class="col-12">
                                    <div class="page-content page-container" id="page-content">

                                          <div class="card user-card-full">
                                                <div class="row m-l-0 m-r-0">
                                                      <div class="col-sm-4 bg-c-lite-green user-profile">
                                                            <div class="card-block text-center text-white">
                                                                  <div class="m-b-25">
                                                                        <img src="{{ asset($user->getImagePath()) }}"
                                                                              id="previewImage"
                                                                              style="border-radius: 50%"
                                                                              width="150"
                                                                              height="150"
                                                                              alt="User-Profile-Image">
                                                                  </div>
                                                                  <h6 class="f-w-600" id="name_preview">{{ old('full_name', $user->full_name) }}</h6>
                                                                  <p>Regular User</p>
                                                            </div>
                                                      </div>
                                                      <div class="col-sm-8">
                                                            <div class="card-block">
                                                                  <h6 class="m-b-20 p-b-5 b-b-default f-w-600">
                                                                        Information</h6>
                                                                  <div class="row">
                                                                        <div class="col-sm-6">
                                                                              <p class="m-b-10 f-w-600">Email</p>
                                                                              <h6 class="text-muted f-w-400"
                                                                                    id="email_preview">{{ old('email', $user->email) }}</h6>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                              <p class="m-b-10 f-w-600">password</p>
                                                                              <h6 class="f-w-400 badge bg-danger text-white"
                                                                                    id="password_preview">Not allowed to preview</h6>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                              <p class="m-b-10 f-w-600">address</p>
                                                                              <h6 class="text-muted f-w-400"
                                                                                    id="address_preview">{{ old('address', $user->address) }}</h6>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                              <p class="m-b-10 f-w-600">Phone</p>
                                                                              <h6 class="text-muted f-w-400"
                                                                                    id="phone_preview">{{ old('phone', $user->phone) }}</h6>
                                                                        </div>
                                                                  </div>
                                                                  <hr>
                                                                  <div class="row">
                                                                        <div class="col-sm-6">
                                                                              <p class="m-b-10 f-w-600">Validate Email
                                                                              </p>
                                                                              <h6 class="f-w-400 badge {{ $user->email_verified_at ? 'bg-success' : 'bg-danger' }} " id="previewStatus">{{ $user->email_verified_at ? 'Verify email' : 'Not verify email' }}</h6>
                                                                        </div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
      </main>

      @section('scripts')
           <script src="{{ asset('dashboards/js/user.js') }}"></script>
      @endsection
</x-dashboard.layouts>
