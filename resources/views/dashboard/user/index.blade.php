<x-dashboard.layouts>
      @section('css')
            <link href="https://cdn.datatables.net/v/bs5/dt-2.3.3/datatables.min.css" rel="stylesheet"
                  integrity="sha384-CoUEazvx+MklR7+tLlL048g8FXNPCgFr7HP39p0DQojPC16bnlchqDSzQK3Td1BU" crossorigin="anonymous">
            <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.bootstrap5.min.css">
            <link href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.3/af-2.7.0/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/b-print-3.2.4/datatables.min.css"
                  rel="stylesheet" integrity="sha384-LNyH/Z9Q461Cc4QrpeqQ9cAMcUPB0uiozvh36L5BLFXDF2I7A5ut9odNxBAhHbdf"
                  crossorigin="anonymous">
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
                        <li class="breadcrumb-item active">Users</li>
                  </ul>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="tile">
                        <div class="tile-body">
                                <div class="d-flex justify-content-between align-items-center">
                                     <div id="userTable_wrapperButton"> </div>
                                    <a href="{{ route('dashboard.user.create') }}" class="btn btn-primary cu-rounded"><i class="bi bi-plus fs-5"></i>Create User</a>
                                </div>
                        </div>
                    </div>
                </div>
                  <div class="col-12">
                        <div class="tile">
                              <div class="tile-body">
                                    <table id="userTable" class="table table-striped table-hover table-bordered">
                                          <thead>
                                                <tr>
                                                      <th>#</th>
                                                      <th class="no-sort">Profile</th>
                                                      <th>Name</th>
                                                      <th>Email</th>
                                                      <th>Address</th>
                                                      <th>Phone Number</th>
                                                      <th>Created at</th>
                                                      <th class="no-sort">Action</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach ($users as $index => $user)
                                                      <tr class="tr">
                                                            <td>{{ $index + 1 }}</td>
                                                            <td class="tr d-flex justify-content-center"><img class="table-user-image" width="50" height="50" src="{{ asset($user->getImagePath()) }}" alt="user image" width="45">
                                                            </td>
                                                            <td>{{ $user->full_name }}</td>
                                                            <td> {{ $user->email }}</td>
                                                            <td> {{ $user->address }}</td>
                                                            <td> {{ $user->phone }}</td>
                                                            <td> {{ $user->created_at->format('Y-m-d') }}</td>
                                                            <td>
                                                                  <a href="{{ route('dashboard.user.edit', $user->id) }}" data-toggle="tooltip"
                                                                        data-placement="bottom" title="Edit user"
                                                                        class="btn btn-outline-info btn-sm">
                                                                        <i
                                                                              class="bi bi-pencil-square"></i>
                                                                  </a>

                                                                  <a href="#" data-toggle="tooltip" data-placement="bottom"
                                                                        title="Show user"
                                                                        class="btn btn-outline-primary btn-sm view-user-btn"
                                                                        data-user-id="{{ $user->id }}"
                                                                        data-url="{{ route('dashboard.user.show', $user) }}">
                                                                        <i class="bi bi-eye-fill"></i>
                                                                  </a>

                                                                  <form action="{{ route('dashboard.user.destroy', $user) }}" method="post" class="d-inline-block">
                                                                         @csrf
                                                                         @method('DELETE')
                                                                        <button type="submit" data-toggle="tooltip"
                                                                              data-placement="bottom"
                                                                              title="Delete user"
                                                                              class="btn btn-outline-danger btn-sm btn-delete">
                                                                              <i class="bi bi-trash"></i>
                                                                        </button>
                                                                  </form>


                                                            </td>
                                                      </tr>
                                                @endforeach

                                          </tbody>
                                    </table>
                              </div>
                        </div>
                  </div>
            </div>

      <!-- Modal for User Preview -->
      <div class="modal modal-xl fade" id="userPreviewModal" tabindex="-1" aria-labelledby="userPreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userPreviewModalLabel">User Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="userPreviewContent">
                        <!-- Tickets and bookings will be loaded here -->
                    </div>
                </div>
            </div>
      </div>

      </main>

      @section('scripts')
            <script src="https://cdn.datatables.net/v/bs5/dt-2.3.3/datatables.min.js"
                  integrity="sha384-ojz3MK3bx1Hb+Bu7oACSEUC9lgGaVZwak7rlgV4yKmSv2BAcRldS4GUz7NqRuAnn" crossorigin="anonymous">
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.datatables.net/2.3.3/js/dataTables.js"></script>
            <script src="https://cdn.datatables.net/2.3.3/js/dataTables.bootstrap5.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.6/js/dataTables.responsive.js"></script>
            <script src="https://cdn.datatables.net/responsive/3.0.6/js/responsive.bootstrap5.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.js"
                  integrity="sha384-P2rohseTZr3+/y/u+6xaOAE3CIkcmmC0e7ZjhdkTilUMHfNHCerfVR9KICPeFMOP" crossorigin="anonymous">
            </script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"
                  integrity="sha384-/RlQG9uf0M2vcTw3CX7fbqgbj/h8wKxw7C3zu9/GxcBPRKOEcESxaxufwRXqzq6n" crossorigin="anonymous">
            </script>
            <script
                  src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.3.3/af-2.7.0/b-3.2.4/b-colvis-3.2.4/b-html5-3.2.4/b-print-3.2.4/datatables.js"
                  integrity="sha384-hD4H5eNTpwxgHNVQJOxRxoE8PyGs1b5T2mVaub4P9ult0pmm+MB6gip45K27gRQp" crossorigin="anonymous">
            </script>
            <script src="{{ asset('dashboards/js/user.js') }}"></script>
      @endsection

</x-dashboard.layouts>
