<div class="app-sidebar__overlay" data-toggle="sidebar"></div>

<aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar"
                  src="https://randomuser.me/api/portraits/men/1.jpg" alt="User Image">
            <div>
                  <p class="app-sidebar__user-name">Name here</p>
                  <p class="app-sidebar__user-designation">Role here</p>
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

            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i
                              class="app-menu__icon bi bi-file-earmark"></i><span class="app-menu__label">Pages</span><i
                              class="treeview-indicator bi bi-chevron-right"></i></a>
                  <ul class="treeview-menu">
                        <li><a class="treeview-item" href="blank-page.html"><i class="icon bi bi-circle-fill"></i> Blank
                                    Page</a></li>
                        <li><a class="treeview-item" href="page-login.html"><i class="icon bi bi-circle-fill"></i> Login
                                    Page</a></li>
                        <li><a class="treeview-item" href="page-lockscreen.html"><i class="icon bi bi-circle-fill"></i>
                                    Lockscreen Page</a></li>
                        <li><a class="treeview-item" href="page-user.html"><i class="icon bi bi-circle-fill"></i> User
                                    Page</a></li>
                        <li><a class="treeview-item" href="page-invoice.html"><i class="icon bi bi-circle-fill"></i>
                                    Invoice Page</a></li>
                        <li><a class="treeview-item" href="page-mailbox.html"><i class="icon bi bi-circle-fill"></i>
                                    Mailbox</a></li>
                        <li><a class="treeview-item" href="page-error.html"><i class="icon bi bi-circle-fill"></i> Error
                                    Page</a></li>
                  </ul>
            </li>
            <li><a class="app-menu__item" href="docs.html"><i class="app-menu__icon bi bi-code-square"></i><span
                              class="app-menu__label">Docs</span></a></li>
      </ul>
</aside>



