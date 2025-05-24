<div class="page-sidebar-wrapper">

    <div class="page-sidebar navbar-collapse collapse">
        <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <li class="nav-item {{ active_menu('home') }}">
                <a href="{{ url(route('vendor.home')) }}" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">{{ __('apps::dashboard.index.title') }}</span>
                    <span class="selected"></span>
                </a>
            </li>

            <li class="heading">
                <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.control') }}</h3>
            </li>

            @can('show_channels')
                <li class="nav-item {{ active_menu('channels') }}">
                    <a href="{{ url(route('vendor.channels.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.channels') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan

            @can('show_bots')
                <li class="nav-item {{ active_menu('bots') }}">
                    <a href="{{ url(route('vendor.bots.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.bots') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan

            @canany(['show_messages','show_bulk_messages','show_decision_messages'])
                <li class="nav-item open  {{active_slide_menu(['show_messages','show_bulk_messages','show_decision_messages'])}}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.messages')}}</span>
                        <span class="arrow {{active_slide_menu(['messages','bulk_messages','decision_messages'])}}"></span>
                        <span class="selected"></span>
                    </a>
                    <ul class="sub-menu" style="display: block;">
{{--                        @can('show_messages')--}}
{{--                            <li class="nav-item {{ active_menu('messages') }}">--}}
{{--                                <a href="{{ url(route('vendor.messages.index')) }}" class="nav-link nav-toggle">--}}
{{--                                    <i class="icon-settings"></i>--}}
{{--                                    <span class="title">{{ __('apps::dashboard._layout.aside.messages') }}</span>--}}
{{--                                    <span class="selected"></span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}

                        @can('show_bulk_messages')
                            <li class="nav-item {{ active_menu('bulk_messages') }}">
                                <a href="{{ url(route('vendor.bulk_messages.index')) }}" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.bulk_messages') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan

                        @can('show_decision_messages')
                            <li class="nav-item {{ active_menu('decision_messages') }}">
                                <a href="{{ url(route('vendor.decision_messages.index')) }}" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.decision_messages') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @canany(['show_contacts','show_numbers_groups'])
                <li class="nav-item open  {{active_slide_menu(['show_contacts','show_numbers_groups'])}}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.contacts')}}</span>
                        <span class="arrow {{active_slide_menu(['contacts','numbers_groups'])}}"></span>
                        <span class="selected"></span>
                    </a>
                    <ul class="sub-menu" style="display: block;">
                        @can('show_contacts')
                            <li class="nav-item {{ active_menu('contacts') }}">
                                <a href="{{ url(route('vendor.contacts.index')) }}" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.contacts') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan

                        @can('show_numbers_groups')
                            <li class="nav-item {{ active_menu('numbers_groups') }}">
                                <a href="{{ url(route('vendor.numbers_groups.index')) }}" class="nav-link nav-toggle">
                                    <i class="icon-settings"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.numbers_groups') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany

            @can('show_templates')
                <li class="nav-item {{ active_menu('templates') }}">
                    <a href="{{ url(route('vendor.templates.index')) }}" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside.templates') }}</span>
                        <span class="selected"></span>
                    </a>
                </li>
            @endcan

            @can('show_orders')
                <li class="nav-item open  {{active_slide_menu(['orders','pending_orders'])}}">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-briefcase"></i>
                        <span class="title">{{ __('apps::dashboard._layout.aside._tabs.orders')}}</span>
                        <span class="arrow {{active_slide_menu(['orders'])}}"></span>
                        <span class="selected"></span>
                    </a>
                    <ul class="sub-menu" style="display: block;">
                        @can('show_orders')
                            <li class="nav-item {{ active_menu('active_orders') }}">
                                <a href="{{ route('vendor.orders.active_orders') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-building"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.active_orders') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan
                        @can('show_orders')
                            <li class="nav-item {{ active_menu('failed_orders') }}">
                                <a href="{{ route('vendor.orders.failed_orders') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-building"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.failed_orders') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan
                        @can('show_orders')
                            <li class="nav-item {{ active_menu('pending_orders') }}">
                                <a href="{{ route('vendor.orders.pending_orders') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-building"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.pending_orders') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan

                        @can('show_orders')
                            <li class="nav-item {{ active_menu('orders') }}">
                                <a href="{{ route('vendor.orders.index') }}" class="nav-link nav-toggle">
                                    <i class="fa fa-building"></i>
                                    <span class="title">{{ __('apps::dashboard._layout.aside.all_orders') }}</span>
                                    <span class="selected"></span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan

        </ul>
    </div>

</div>
