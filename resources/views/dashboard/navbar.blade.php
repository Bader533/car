<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('homepage')}}" class="brand-link">
        <img src="{{asset('asset/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('asset/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('admin.edit',auth()->user()->id)}}" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Owners
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('owner.index')}}" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Owner</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('owner.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Owner</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            {{__('site.cars')}}
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('car.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('site.allCars')}}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('car.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>{{__('site.CreateCar')}}</p>
                            </a>
                        </li>

                    </ul>
                </li>
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Cars
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('carName.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Cars</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('carName.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Car</p>
                            </a>
                        </li>

                    </ul>
                </li> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            City
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('city.index')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Cities</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('city.create')}}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Create Cities</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item " style="text-align:center;">
                    <a href="{{route('logout')}}" class="nav-link  btn-lg ">
                        <p>LogOut</p>
                    </a>
                </li>
            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
