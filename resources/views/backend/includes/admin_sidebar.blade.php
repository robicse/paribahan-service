<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #303641;  min-height: 600px!important;">
    <!-- Brand Logo -->
{{--<a href="#" class="brand-link">
    <img src="{{asset('backend/images/logo.png')}}" width="150" height="100" alt="Aamar Bazar" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    --}}{{--<span class="brand-text font-weight-light">Farazi Home Care</span>--}}{{--
</a>--}}
<!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-2 pl-2 mb-2 d-flex">
            <div class="">
                <img src="{{asset('frontend/logo_sazidmart.png')}}" class="" alt="User Image" width="100%">
            </div>
        </div>

    @if (Auth::check()  && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')  )
        <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}"
                           class="nav-link {{Request::is('admin/dashboard') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.vendors.index')}}" class="nav-link {{Request::is('admin/vendors*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Vendors</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.drivers.index')}}" class="nav-link {{Request::is('admin/drivers*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Drivers</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.customers.index')}}" class="nav-link {{Request::is('admin/customers*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Customers</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/brands*')
                        || Request::is('admin/categories*')
                        || Request::is('admin/subcategories*')
                        || Request::is('admin/vehicles*')
                        )
                    ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Vehicle Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.brands.index')}}"
                                   class="nav-link {{Request::is('admin/brands*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/brands*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Brands</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.categories.index')}}"
                                   class="nav-link {{Request::is('admin/categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Categories</p>
                                </a>
                            </li>
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.subcategories.index')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/subcategories*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/subcategories*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Subcategories</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.sub-subcategories.index')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/sub-subcategories*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/sub-subcategories*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Sub Subcategories</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                            <li class="nav-item">
                                <a href="{{route('admin.vehicles.index')}}"
                                   class="nav-link {{Request::is('admin/vehicles*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/vehicles*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Vehicles</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.vehicle-vendor-rent-list')}}" class="nav-link {{Request::is('admin/vehicle/vendor/rent/list') || Request::is('admin/vehicle/vendor/rent/create') || Request::is('admin/vehicle/vendor/rent/edit*')|| Request::is('admin/vehicle/vendor/rent/show*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Vehicle Rent From Vendor</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.vehicle-vendor-rent-due')}}" class="nav-link {{Request::is('admin/vehicle/vendor/rent/due') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Vendor Due</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.vehicle-driver-assigns.index')}}" class="nav-link {{Request::is('admin/vehicle-driver-assigns*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Vehicle Driver Assign</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.vehicle-customer-rent-list')}}" class="nav-link {{Request::is('admin/vehicle/customer/rent/list') || Request::is('admin/vehicle/customer/rent/create') || Request::is('admin/vehicle/customer/rent/edit*')|| Request::is('admin/vehicle/customer/rent/show*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Vehicle Rent To Customer</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.vehicle-customer-rent-due')}}" class="nav-link {{Request::is('admin/vehicle/customer/rent/due') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Customer Due</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.vehicle-cost.index')}}" class="nav-link {{Request::is('admin/vehicle-cost*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Vehicle Cost</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.overall-cost-categories.index')}}" class="nav-link {{Request::is('admin/overall-cost-categories*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Overall Cost Category</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.overall-cost.index')}}" class="nav-link {{Request::is('admin/overall-cost*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Overall Cost</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.driver-salary-list')}}" class="nav-link {{Request::is('admin/driver/salary*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Driver Salary</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.staff-salary-list')}}" class="nav-link {{Request::is('admin/staff/salary*') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Staff Salary</p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/report/payments*')
                        || Request::is('admin/report/vendor-balance-sheet')
                        || Request::is('admin/report/customer-balance-sheet')
                        || Request::is('admin/report/driver-balance-sheet')
                        || Request::is('admin/report/staff-balance-sheet')
                        || Request::is('admin/report/loss-profit')
                        )
                    ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Report
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{!! URL::to('/admin/report/vendor-balance-sheet') !!}"
                                   class="nav-link {{Request::is('admin/report/vendor-balance-sheet') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/report/vendor-balance-sheet') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Vendor Balance Sheet</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{!! URL::to('/admin/report/customer-balance-sheet') !!}"
                                   class="nav-link {{Request::is('admin/report/customer-balance-sheet') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/report/customer-balance-sheet') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Customer Balance Sheet</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{!! URL::to('/admin/report/driver-balance-sheet') !!}"
                                   class="nav-link {{Request::is('admin/report/driver-balance-sheet') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/report/driver-balance-sheet') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Driver Balance Sheet</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{!! URL::to('/admin/report/staff-balance-sheet') !!}"
                                   class="nav-link {{Request::is('admin/report/staff-balance-sheet') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/report/staff-balance-sheet') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Staff Balance Sheet</p>
                                </a>
                            </li>
                            <li class="nav-item">
{{--                                <a href="{{route('admin.report-payment')}}"--}}
                                <a href="{!! URL::to('/admin/report/payments') !!}"
                                   class="nav-link {{Request::is('admin/report/payments') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/report/payments') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Payments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{!! URL::to('/admin/report/loss-profit') !!}"
                                   class="nav-link {{Request::is('admin/report/loss-profit') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/report/loss-profit') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Loss/Profit</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <div class="user-panel">&nbsp;</div>
                    <li class="nav-item has-treeview {{(Request::is('admin/roles*') || Request::is('admin/staffs*')) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Role & permission
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.staffs.index')}}"
                                   class="nav-link {{Request::is('admin/staffs*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/staffs*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Staff Manage</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.roles.index')}}"
                                   class="nav-link {{Request::is('admin/role*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/roles*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Role Manage</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.profile.index')}}" class="nav-link {{Request::is('admin/profile') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>Admin Profile</p>
                        </a>
                    </li>

{{--                    <li class="nav-item has-treeview {{(Request::is('admin/frontend_settings*') ) || (Request::is('admin/logo*') ) ? 'menu-open' : ''}}">--}}
{{--                        <a href="#" class="nav-link">--}}
{{--                            <i class="nav-icon fas fa-desktop"></i>--}}
{{--                            <p>--}}
{{--                                Frontend Settings--}}
{{--                                <i class="right fa fa-angle-left"></i>--}}
{{--                            </p>--}}
{{--                        </a>--}}
{{--                        <ul class="nav nav-treeview">--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.home_settings.index')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/frontend_settings*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/frontend_settings*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Home</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.generalsettings.logo')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/logo') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/logo') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Logo Settings</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                    <li class="nav-item ">
                        <a href="{{route('admin.access-logs.index')}}" class="nav-link {{Request::is('admin/access-logs') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-cog"></i>
                            <p>Access Log</p>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.site.optimize')}}" class="nav-link {{Request::is('admin/site-optimize') ? 'active' : ''}}">
                            <i class="nav-icon fa fa-cog"></i>
                            <p>Site Optimize</p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        @endif
    </div>
    <!-- /.sidebar -->
</aside>


