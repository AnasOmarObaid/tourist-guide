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
                <li class="breadcrumb-item">Settings</li>
            </ul>
        </div>

        <div class="row mb-4">

            {{-- edit profile --}}
            <div class="col-12">
                <div class="cu-rounded">
                    <div class="tile-body">
                        <div class="row g-3">

                            <form action="{{ route('dashboard.setting.store') }}" method="POST">
                                @csrf

                                <div class="row mt-2">
                                    <div class="col-12 col-md-6">
                                        <div class="card cu-rounded">

                                            <div class="card-body py-4">

                                                {{-- app name --}}
                                                <div class="form-group mb-3">
                                                    <label>Application name</label>
                                                    <input type="text" name="app_name"
                                                        value="{{ old('app_name', setting('app_name')) }}"
                                                        class="form-control mt-1 @error('app_name') is-invalid @enderror"
                                                        placeholder="Application Name" required>

                                                    @error('app_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- web location --}}
                                                <div class="form-group mb-3">
                                                    <label>Web address</label>
                                                    <input type="email" value="{{ Request::server('SERVER_NAME') }}"
                                                        disabled
                                                        class="form-control mt-1 @error('web_location') is-invalid @enderror"
                                                        placeholder="Web address" required>

                                                    @error('web_location')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- app_email --}}
                                                <div class="form-group mb-3">
                                                    <label>Email address</label>
                                                    <input type="email" value="{{ auth()->user()->email }}" disabled
                                                        class="form-control mt-1 @error('app_email') is-invalid @enderror"
                                                        placeholder="Email address" required>

                                                    @error('app_email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- app_version --}}
                                                <div class="form-group mb-3">
                                                    <label>Application version</label>
                                                    <input type="text" name="app_version"
                                                        value="{{ old('app_version', setting('app_version')) }}"
                                                        class="form-control mt-1 @error('app_version') is-invalid @enderror"
                                                        placeholder="Application version" required>

                                                    @error('app_version')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- app_content --}}
                                                <div class="form-group mb-3">
                                                    <label>Website content</label>
                                                    <textarea name="app_content" required placeholder="Website content" class="form-control" mt-1 rows="4">{{ old('app_content', setting('app_content')) }}</textarea>
                                                    @error('app_content')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <hr class="mt-4">

                                                {{-- app_phone_number --}}
                                                <div class="form-group mb-3">
                                                    <label>Application phone number</label>
                                                    <input type="text" name="app_phone_number"
                                                        value="{{ old('app_phone_number', setting('app_phone_number')) }}"
                                                        class="form-control mt-1 @error('app_phone_number') is-invalid @enderror"
                                                        placeholder="Application phone number" required>

                                                    @error('app_phone_number')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>

                                    <div class="col-12 col-md-6">

                                        <div class="card cu-rounded">

                                            <div class="card-body py-4">

                                                {{-- Usage treaty --}}
                                                <div class="form-group mb-3">
                                                    <label>Usage treaty</label>
                                                    <textarea name="usage_treaty" required placeholder="Usage treaty" class="form-control mt-1" rows="8">{{ old('usage_treaty', setting('usage_treaty')) }}</textarea>

                                                    @error('usage_treaty')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- Usage policy --}}
                                                <div class="form-group mb-3">
                                                    <label>Usage policy</label>
                                                    <textarea name="usage_policy" required placeholder="Usage policy" class="form-control mt-1" rows="8">{{ old('usage_policy', setting('usage_policy')) }}</textarea>

                                                    @error('usage_policy')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                {{-- Laws review --}}
                                                <div class="form-group mb-3">
                                                    <label>Laws review</label>
                                                    <textarea name="laws_review" required placeholder="Laws review" class="form-control mt-1" rows="8">{{ old('laws_review', setting('laws_review')) }}</textarea>

                                                    @error('laws_review')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>


                                                {{-- submit --}}
                                                <div class="tile-footer text-center">
                                                    <button class="btn btn-outline-primary cu-rounded w-100" type="submit">
                                                        <i class="bi bi-check-circle-fill"></i>Save Settings
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

</x-dashboard.layouts>
