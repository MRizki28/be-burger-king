<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- SidebarSearch Form -->
        <div class="form-inline mt-3 ">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar bg-light border-0" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar bg-light border-0">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="/" class="nav-link text-light">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- @if (auth()->user()->role == 1) --}}
                <li class="nav-item">
                    <a href="/jenisProduct" class="nav-link text-light">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            Jenis Produk
                        </p>
                    </a>
                </li>

                {{-- @else --}}
                <li class="nav-item">
                    <a href="/banner" class="nav-link text-light">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>
                            Banner
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/menu" class="nav-link text-light">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>
                            Menu
                        </p>
                    </a>
                </li>
                {{-- @endif --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
