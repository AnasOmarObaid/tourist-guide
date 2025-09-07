<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="table-user-image app-sidebar__user-avatar"
                  src="{{ asset(Auth::user()->getImagePath()) }}" width="60" height="60" alt="User Image">
            <div>
                  <p class="app-sidebar__user-name">{{ auth()->user()->full_name }}</p>
                  <p class="app-sidebar__user-designation">Super admin</p>
            </div>
      </div>
      <ul class="app-menu">
            {{-- Dashboard Link --}}
            <li><a class="app-menu__item {{ request()->routeIs('dashboard.welcome') ? 'active' : '' }}"
                        href="{{ route('dashboard.welcome') }}"><i class="app-menu__icon bi bi-speedometer"></i><span
                              class="app-menu__label">Dashboard</span></a></li>

            {{-- users routes  --}}
            <li class="treeview {{ request()->routeIs('dashboard.user.*') ? 'is-expanded' : '' }}"><a
                        class="app-menu__item " href="#" data-toggle="treeview"><i
                              class="app-menu__icon bi bi-people-fill"></i><span class="app-menu__label">Users</span><i
                              class="treeview-indicator bi bi-chevron-right"></i></a>
                  <ul class="treeview-menu mt-1">
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.user.index') ? 'active' : '' }}"
                                    href="{{ route('dashboard.user.index') }}"><i class="icon bi bi-database"></i> View
                                    Users</a></li>
                        <li> <a class="treeview-item {{ request()->routeIs('dashboard.user.create') ? 'active' : '' }}"
                                    href="{{ route('dashboard.user.create') }}"><i class="icon bi bi-plus fs-5"></i>
                                    Create User</a></li>
                  </ul>
            </li>

            {{-- cities routes --}}
            <li class="treeview {{ request()->routeIs('dashboard.city.*') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                              class="app-menu__icon bi bi-house-fill"></i><span class="app-menu__label">Cities</span><i
                              class="treeview-indicator bi bi-chevron-right"></i></a>
                  <ul class="treeview-menu mt-1">
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.city.index') ? 'active' : '' }}" href="{{ route('dashboard.city.index') }}"><i class="icon bi bi-database"></i>
                                    View Cities</a></li>
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.city.create') ? 'active' : '' }}" href="{{ route('dashboard.city.create') }}"><i class="icon bi bi-house-add-fill"></i>
                                    Create City</a></li>
                  </ul>
            </li>

            {{-- Events routes --}}
            <li class="treeview {{ request()->routeIs('dashboard.event.*') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                              class="app-menu__icon bi bi-calendar-event-fill"></i><span class="app-menu__label">Events</span><i
                              class="treeview-indicator bi bi-chevron-right"></i></a>
                  <ul class="treeview-menu mt-1">
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.event.index') ? 'active' : '' }}" href="{{ route('dashboard.event.index') }}"><i class="icon bi bi-database"></i>
                                    View Events</a></li>
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.event.create') ? 'active' : '' }}" href="{{ route('dashboard.event.create') }}"><i class="icon bi bi-plus fs-5"></i>
                                    Create Event</a></li>
                  </ul>
            </li>

            {{-- tickets --}}
             <li><a class="app-menu__item {{ request()->routeIs('dashboard.ticket.index') ? 'active' : '' }}" href="{{ route('dashboard.ticket.index') }}"><i class="app-menu__icon bi bi-receipt"></i><span
                              class="app-menu__label">Tickets</span></a></li>

            {{-- Hotel routes --}}
            <li class="treeview {{ request()->routeIs('dashboard.hotel.*') ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                              class="app-menu__icon bi bi-buildings-fill"></i><span class="app-menu__label">Hotels</span><i
                              class="treeview-indicator bi bi-chevron-right"></i></a>
                  <ul class="treeview-menu mt-1">
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.hotel.index') ? 'active' : '' }}" href="{{ route('dashboard.hotel.index') }}"><i class="icon bi bi-database"></i>
                                     View Hotels</a></li>
                        <li><a class="treeview-item {{ request()->routeIs('dashboard.hotel.create') ? 'active' : '' }}" href="{{ route('dashboard.hotel.create') }}"><i class="icon bi bi-plus fs-5"></i>
                                    Create Hotel</a></li>
                  </ul>
            </li>

            {{-- bookings --}}
             <li><a class="app-menu__item {{ request()->routeIs('dashboard.booking.index') ? 'active' : '' }}" href="{{ route('dashboard.booking.index') }}"><i class="app-menu__icon bi bi-bookmark-fill"></i><span
                              class="app-menu__label">Bookings</span></a></li>

             {{-- settings --}}
             <li><a class="app-menu__item mt-1 {{ request()->routeIs('dashboard.setting.index') ? 'active' : '' }}" href="{{ route('dashboard.setting.index') }}"><i class="app-menu__icon bi bi-gear-fill"></i><span
                              class="app-menu__label">Settings</span></a></li>

            {{-- profile --}}
            <li><a class="app-menu__item mt-1 {{ request()->routeIs('dashboard.profile.edit') ? 'active' : '' }}" href="{{ route('dashboard.profile.edit') }}"><i class="app-menu__icon bi bi-person-circle"></i><span
                              class="app-menu__label">Profile</span></a></li>

            {{-- logout --}}
            <li>
                <form class='form' method="POST" action="{{ route('dashboard.auth.logout') }}">
                    @csrf
                    <button class="btn p-0 w-100" type='submit'>
                        <a class="app-menu__item ">
                            <i class="bi bi-box-arrow-right me-2 fs-5"></i>
                            Logout
                        </a>
                    </button>
                </form>
            </li>
      </ul>
</aside>



