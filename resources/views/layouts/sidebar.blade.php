<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #2d84f4 ">
    <!-- Brand Logo -->
    <a href="/" class="brand-link" style="border-bottom:3px solid white">
        <img src="{{ asset('logo2.png') }}" alt="AdminLTE Logo"
            class="brand-image" style="
            width: 45px;
            margin-top: 2px;
            margin-left: 8px;
        ">
        <span class="brand-text font-weight-bold">BURGER</span>
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
                    {{-- <li class="nav-item">
                        <a href="/absen" class="nav-link text-light">
                            <i class="nav-icon fas fa-pen"></i>
                            <p>
                                Absen
                            </p>
                        </a>
                    </li> --}}
                {{-- @endif --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
