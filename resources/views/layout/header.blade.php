@php
    use App\Constants\AdminUserConstant;
@endphp

<div class="c-wrapper">
    <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
        <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar"
                data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button>
        <a class="c-header-brand d-sm-none" href="#">
            <img class="c-header-brand"
                 src="{{url('/assets/brand/coreui-base.svg')}}"
                 width="97"
                 height="46"
                 alt="CoreUI Logo">
        </a>
        <ul class="c-header-nav ml-auto mr-4">
            <li class="c-header-nav-item d-md-down-none mx-2">
                <a class="c-header-nav-link">{{$auth[AdminUserConstant::INPUT_NAME]}}</a>
            </li>
            <li class="c-header-nav-item dropdown">
                <a class="c-header-nav-link"
                   data-toggle="dropdown"
                   href="#"
                   role="button"
                   aria-haspopup="true"
                   aria-expanded="false"
                >
                    <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none"
                            type="button"
                            data-class="c-sidebar-lg-show"
                            responsive="true"
                    >
                        <span class="c-header-toggler-icon"></span>
                    </button>
                </a>
                <div class="dropdown-menu dropdown-menu-right pt-0">
                    <a class="dropdown-item" href="{{route('setting')}}">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-lock-locked') }}"></use>
                        </svg>
                        {{__('title.common.change_password')}}
                    </a>
                    <a class="dropdown-item" href="{{route('logout')}}">
                        <svg class="c-icon mr-2">
                            <use xlink:href="{{ url('/icons/sprites/free.svg#cil-account-logout') }}"></use>
                        </svg>
                        {{__('title.common.logout')}}
                    </a>
                </div>
            </li>
        </ul>
    </header>
