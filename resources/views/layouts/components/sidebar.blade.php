@section('sidebar')
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-red elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
      <img src="{{ asset('assets/dist/img/Telkom_small.png') }}" alt="Telkom Indonesia Logo" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light">Telkom Indonesia</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->

      @guest
        @if (Route::has('login'))
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
              <a href="{{ route('login') }}">
                <img src="{{ asset('assets/dist/icon/open-iconic-master/svg/account-login.svg') }}" class="img-square elevation-0" alt="login-ico">
                {{ __('Login') }}
              </a>
            </div>
          </div>
        @endif
      @else
        <div class="user-panel mt-3 pb-3 mb-3 d-flex" data-toggle="dropdown">
          <div class="image">
            <img src="{{ asset('assets/dist/icon/open-iconic-master/svg/person.svg') }}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ Auth::user()->username }}</a>
          </div>
        </div>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
      @endguest

      <!-- Sidebar Menu -->
      <nav class="mt-2" id="sidenavAccordion">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item {{ ($nav_item === "dashboard_item") ? 'menu-open' : '' }}">
          {{-- <li class="nav-item"> --}}
            <a href="/" class="nav-link {{ ($nav_link === "dashboard_link") ? 'active' : '' }}">
            {{-- <a href="/" class="nav-link"> --}}
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @guest
          
          @else
          <li class="nav-item {{ ($nav_item === "input_item") ? 'menu-open' : '' }}">
            {{-- <li class="nav-item"> --}}
              <a href="/input" class="nav-link {{ ($nav_link === "input_link") ? 'active' : '' }}">
              {{-- <a href="/input" class="nav-link"> --}}
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Buat Tiket
                </p>
              </a>
          </li>
          @endguest
          <li class="nav-item {{ ($nav_item === "perform_item") ? 'menu-open' : '' }}">
          {{-- <li class="nav-item"> --}}
            <a href="#" class="nav-link {{ ($nav_link === "perform_link") ? 'active' : '' }}">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Performa Teknisi
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @foreach ($sidebar_dist as $item)
              <li class="nav-item">
                <a href="/performa/{{ $item->kode }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ $item->nama }}</p>
                </a>
              </li>
              @endforeach
            </ul>
          </li>
          <li class="nav-item menu {{ ($nav_item === "customer_item") ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ ($nav_link === "customer_link") ? 'active' : '' }}">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Data Customer
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              @foreach ($sidebar_cust as $item)
              <li class="nav-item">
                <a href="/customer/{{ $item->kode }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{ $item->nama }}</p>
                </a>
              </li>
              @endforeach
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
@endsection