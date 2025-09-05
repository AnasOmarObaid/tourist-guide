<x-dashboard.auth.layouts>

      <section class="material-half-bg">
            <div class="cover"></div>
      </section>

      <section class="login-content">
            <div class="logo">
                  <h1>Tourist Guide</h1>
            </div>
            <div class="login-box">
                  <form method="POST" action="{{ route('dashboard.auth.login') }}" class="login-form" action="">
                        @csrf
                        <h3 class="login-head"><i class="bi bi-person me-2"></i>SIGN IN</h3>

                        {{-- email input --}}
                        <div class="mb-3">
                              <label class="form-label">EMAIL</label>
                              <input class="form-control @error('email') is-invalid @enderror" type="text"
                                    placeholder="Enter Email" name="email" value="{{ old('email') }}" autofocus>
                              @error('email')
                                    <small class="invalid-feedback"
                                          role="alert"><strong>{{ $message }}</strong></small>
                              @enderror

                        </div>

                        {{-- password input --}}
                        <div class="mb-3">
                              <label class="form-label">PASSWORD</label>
                              <input class="form-control @error('password') is-invalid @enderror" type="password"
                                    name="password" placeholder="Password">
                        </div>
                        @error('email')
                                    <small class="invalid-feedback"
                                          role="alert"><strong>{{ $message }}</strong></small>
                        @enderror

                        {{-- remember input --}}
                        <div class="mb-3">
                              <div class="utility">
                                    <div class="form-check">
                                          <label class="form-check-label">
                                                <input name="remember" id="remember" class="form-check-input"
                                                      type="checkbox"><span class="label-text">Stay Signed in</span>
                                          </label>
                                    </div>
                              </div>
                        </div>

                        {{-- submit button --}}
                        <div class="mb-3 btn-container d-grid">
                              <button class="btn btn-primary btn-block"><i
                                          class="bi bi-box-arrow-in-right me-2 fs-5"></i>SIGN IN</button>
                        </div>
                  </form>
            </div>
      </section>

</x-dashboard.auth.layouts>
