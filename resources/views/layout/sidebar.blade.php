    <div class="c-sidebar-brand">
        <a href="{{route('dashboard')}}">
            <h3 class="c-sidebar-brand-full" style="margin-bottom: 0;">{{__('title.common.logo')}}</h3>
        </a>
    </div>
    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle">
                <i class="c-sidebar-nav-icon"></i>
                {{__('title.common.sidebar.coupon.text')}}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link _sidebar_sub" href="{{route('coupon.list')}}">
                        ・{{__('title.common.sidebar.coupon.list')}}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link _sidebar_sub" href="{{route('coupon.coupon_management.list')}}">
                        ・{{__('title.common.sidebar.coupon.coupon_management')}}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link _sidebar_sub" href="">
                        ・{{__('title.common.sidebar.coupon.usage_list')}}
                    </a>
                </li>
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link _sidebar_sub"
                       href="{{route('coupon.couppon_setting')}}">
                        ・{{__('title.common.sidebar.coupon.coupon_setting')}}
                    </a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-dropdown {{Request::is('admin/user/kddi') || Request::is('admin/user/business') ? 'c-show' : Request::is('admin/user/business')}}">
            <a class="c-sidebar-nav-dropdown-toggle">
                <i class="c-sidebar-nav-icon"></i>
                {{__('title.common.sidebar.user.text')}}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link _sidebar_sub {{Request::is('admin/user/kddi') || Request::is('admin/user/business') ? 'c-active' : Request::is('admin/user/business')}}"
                       href="{{route('admin_user.list')}}">
                        ・{{__('title.common.sidebar.user.list')}}
                    </a>
                </li>
            </ul>
        </li>
        <li class="c-sidebar-nav-dropdown">
            <a class="c-sidebar-nav-dropdown-toggle">
                <i class="c-sidebar-nav-icon"></i>
                {{__('title.common.sidebar.department.text')}}
            </a>
            <ul class="c-sidebar-nav-dropdown-items">
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link _sidebar_sub"
                       href="{{route('department.list')}}">
                        ・{{__('title.common.sidebar.department.list')}}
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <button class="c-sidebar-minimizer c-class-toggler"
            type="button"
            data-target="_parent"
            data-class="c-sidebar-minimized">
    </button>
</div>
