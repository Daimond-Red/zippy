
<ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
    <li class="m-menu__item  dashboard-menu" aria-haspopup="true" >
        <a  href="{{ route('admin.dashboard') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-line-graph"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Dashboard
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item  customer-menu" aria-haspopup="true" >
        <a  href="{{ route('admin.customers.index') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-users"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Customers
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item  vendor-menu" aria-haspopup="true" >
        <a  href="{{ route('admin.vendors.index') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-truck"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Vendors
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item  notification-menu" aria-haspopup="true" >
        <a  href="{{ route('admin.appNotifications.index') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-alert-1"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Notifications
                    </span>
                </span>
            </span>
        </a>
    </li>

   
    <li class="m-menu__item  driver-notification-menu" aria-haspopup="true" >
        <a  href="{{ route('admin.driverNotifications.index') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-alert-1"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Driver Notifications
                    </span>
                </span>
            </span>
        </a>
    </li>
    {{-- <li class="m-menu__item area-menu" aria-haspopup="true" >
        <a  href="{{ route('admin.areas.index') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-map-location"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Areas
                    </span>
                </span>
            </span>
        </a>
    </li> --}}
    <li class="m-menu__item page-menu" aria-haspopup="true" >
        <a  href="{{ route('admin.pages.index') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-list-1"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Pages
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item m-menu__item--submenu booking-menu" aria-haspopup="true" data-menu-submenu-toggle="hover">
        <a href="#" class="m-menu__link m-menu__toggle">
            <i class="m-menu__link-icon flaticon-route"></i>
            <span class="m-menu__link-text">Bookings</span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu" style="">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">
                <li class="m-menu__item pendingbooking-menu" aria-haspopup="true">
                    <a href="{{ route('admin.bookings.pending') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Business Inquiries
                            <span class="m-badge m-badge--danger">
                                {{ \App\Booking::where('status', \App\Booking::PENDING)->count() }}
                            </span>
                        </span>
                    </a>
                </li>
                <li class="m-menu__item bookinglist-menu" aria-haspopup="true">
                    <a href="{{ route('admin.bookings.index') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Live Trip</span>
                    </a>
                </li>
                <li class="m-menu__item cancelledlist-menu" aria-haspopup="true">
                    <a href="{{ route('admin.bookings.cancelled') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Cancelled Bookings</span>
                    </a>
                </li>
                <li class="m-menu__item completelist-menu" aria-haspopup="true">
                    <a href="{{ route('admin.bookings.completed') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Completed Bookings</span>
                    </a>
                </li>
                <li class="m-menu__item expired-menu" aria-haspopup="true">
                    <a href="{{ route('admin.bookings.expired') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Expired Bookings</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="m-menu__item m-menu__item--submenu master-menu" aria-haspopup="true" data-menu-submenu-toggle="hover">
        <a href="#" class="m-menu__link m-menu__toggle">
            <i class="m-menu__link-icon flaticon-settings"></i>
            <span class="m-menu__link-text">Master</span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
        <div class="m-menu__submenu" style="">
            <span class="m-menu__arrow"></span>
            <ul class="m-menu__subnav">
                <li class="m-menu__item cargotype-menu" aria-haspopup="true">
                    <a href="{{ route('admin.cargos.index') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Type of cargos</span>
                    </a>
                </li>
                <li class="m-menu__item vehicletype-menu" aria-haspopup="true">
                    <a href="{{ route('admin.vehicletypes.index') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Type of vehicles</span>
                    </a>
                </li>
                <li class="m-menu__item vehiclecategory-menu" aria-haspopup="true">
                    <a href="{{ route('admin.vehiclecategories.index') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Vehicle categories</span>
                    </a>
                </li>
                <li class="m-menu__item paymenttypes-menu" aria-haspopup="true">
                    <a href="{{ route('admin.paymentTypes.index') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Payment Types</span>
                    </a>
                </li>
                <li class="m-menu__item dashboardText-menu" aria-haspopup="true">
                    <a href="{{ route('admin.dashboardText') }}" class="m-menu__link ">
                        <i class="m-menu__link-bullet m-menu__link-bullet--dot"><span></span></i>
                        <span class="m-menu__link-text">Dashboard Text</span>
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="m-menu__item  configuration-menu" aria-haspopup="true" >
        <a  href="{{ route('config.push') }}" class="m-menu__link ">
            <i class="m-menu__link-icon flaticon-settings"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        Configurations
                    </span>
                </span>
            </span>
        </a>
    </li>
    <li class="m-menu__item  configuration-menu" aria-haspopup="true" >
        <a  href="javascript:void(0);" class="m-menu__link " onclick="MyWindow=window.open('http://zippy.co.in/dcs-cargo-form.php','MyWindow',width=600,height=300); return false;">
            <i class="m-menu__link-icon flaticon-settings"></i>
            <span class="m-menu__link-title">
                <span class="m-menu__link-wrap">
                    <span class="m-menu__link-text">
                        E-Consignment
                    </span>
                </span>
            </span>
        </a>
    </li>
</ul>
