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
                        <li class="breadcrumb-item">Edit Profile</li>
                  </ul>
            </div>

            <div class="row mb-4">

                {{-- edit profile --}}
                <div class="col-12">
                    <div class=" cu-rounded">
                            <div class="tile-body">
                                <div class="row g-3">
                                    <div class="col-lg-8">
                                        <form class="form" method="POST" action="{{ route('dashboard.profile.update') }}" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="card shadow-sm cu-rounded mb-3">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="position-relative me-3">
                                                            <img id="profilePreview" src="{{ asset($user->getImagePath()) }}" class="rounded-circle border" width="96" height="96" style="object-fit: cover;" alt="Avatar">
                                                            <label for="image" class="btn btn-sm btn-primary position-absolute bottom-0 end-0 cu-rounded" style="transform: translate(25%, 25%);">
                                                                <i class="bi bi-camera"></i>
                                                            </label>
                                                            <input type="file" id="image" name="image" class="d-none" accept="image/*">
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">{{ $user->full_name }}</h5>
                                                            <small class="text-muted">Member since {{ $user->created_at->format('M Y') }}</small>
                                                        </div>
                                                    </div>

                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Full name</label>
                                                            <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $user->full_name) }}" required>
                                                            @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                                                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Phone</label>
                                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                                                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Address</label>
                                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}">
                                                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                        </div>

                                                    </div>

                                                    <div class="d-flex justify-content-end mt-3">
                                                        <button type="submit" class="btn btn-outline-primary cu-rounded">
                                                            <i class="bi bi-save me-1"></i> Save changes
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="card shadow-sm  cu-rounded">
                                            <div class="card-body">
                                                <h6 class="mb-3">Change password</h6>
                                                <form method="POST" action="{{ route('dashboard.profile.updatePassword') }}">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label">Current password</label>
                                                        <input type="password" name="current_password" class="form-control @error('password.current_password') is-invalid @enderror" required>
                                                        @error('password.current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">New password</label>
                                                        <input type="password" id="new_password" name="new_password" class="form-control" minlength="8" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Confirm new password</label>
                                                        <input type="password" id="new_password_confirmation" class="form-control" minlength="8" required>
                                                        <div id="pwMismatch" class="invalid-feedback d-none">Passwords do not match.</div>
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <button type="submit" id="passwordSubmit" class="btn btn-outline-secondary cu-rounded" disabled>
                                                            <i class="bi bi-shield-lock me-1"></i> Update password
                                                        </button>
                                                    </div>
                                                </form>
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
        <script src="{{ asset('dashboards/js/profile.js') }}"></script>
      @endsection

</x-dashboard.layouts>
