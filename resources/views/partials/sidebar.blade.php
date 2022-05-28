<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link">
<!--       <img src="{{ asset('_images/site-logo.png') }}" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8"> -->
      <span class="brand-text font-weight-bold pl-2">IMN-Invoice</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
<!--       <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div> -->

      <!-- SidebarSearch Form -->
<!--       <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>  -->

      <!-- Sidebar Menu -->
      <nav class="my-3">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-header">INVOICING</li> -->
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link {{ (request()->segment(1) == 'dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          @if(auth()->user()->is_superadmin == 1)
          <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{ (request()->segment(1) == 'pengguna') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Pengguna
              </p>
            </a>
          </li>
          @endif
          <li class="nav-item">
            <a href="{{ route('clients.index') }}" class="nav-link {{ (request()->segment(1) == 'klien') ? 'active' : '' }}">
              <i class="nav-icon fas fa-handshake"></i>
              <p>
                Klien
              </p>
            </a>
          </li>

          <li class="nav-item {{ (request()->segment(1) == 'layanan') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ (request()->segment(1) == 'layanan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Layanan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('service_categories.index') }}" class="nav-link {{ (request()->segment(2) == 'kategori') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Kategori</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('services.index') }}" class="nav-link {{ ((request()->segment(1) == 'layanan') && (request()->segment(2) != 'kategori')) ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Layanan</p>
                </a>
              </li>
            </ul>
          </li>
          @if(auth()->user()->is_superadmin == 0)
          <li class="nav-item">
            <a href="{{ route('invoices.index') }}" class="nav-link {{ (request()->segment(1) == 'invoice') ? 'active' : '' }}">
              <i class="nav-icon fas fa-receipt"></i>
              <p>
                Invoice
              </p>
            </a>
          </li>
          @endif
          @if(auth()->user()->is_superadmin == 1)
          <li class="nav-item">
            <a href="{{ route('transactions.index') }}" class="nav-link {{ (request()->segment(1) == 'transaksi') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Transaksi
              </p>
            </a>
          </li>
          @endif
          <div class="border-top border-secondary my-3"></div>
          <li class="nav-item">
            <a href="{{ route('profile.edit') }}" class="nav-link {{ (request()->segment(1) == 'edit-profil') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-edit"></i>
              <p>
                Edit Profil
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Keluar
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
