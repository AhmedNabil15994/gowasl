<div class="page-sidebar-wrapper">

  <div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu  page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">

      <li class="sidebar-toggler-wrapper hide">
        <div class="sidebar-toggler">
          <span></span>
        </div>
      </li>
      <li class="nav-item {{ active_menu('home') }}">
        <a href="{{ url(route('dashboard.home')) }}" class="nav-link nav-toggle">
          <i class="icon-home"></i>
          <span class="title">{{ __('apps::dashboard.index.title') }}</span>
          <span class="selected"></span>
        </a>
      </li>

      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.control') }}</h3>
      </li>

        @canany(['show_roles','show_admins','show_users'])
            <li class="nav-item open  {{active_slide_menu(['roles','admins','users'])}}">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside._tabs.users')}}</span>
                    <span class="arrow {{active_slide_menu(['roles','admins','users'])}}"></span>
                    <span class="selected"></span>
                </a>
                <ul class="sub-menu" style="display: block;">
                    @can('show_roles')
                        <li class="nav-item {{ active_menu('roles') }}">
                            <a href="{{ url(route('dashboard.roles.index')) }}" class="nav-link nav-toggle">
                                <i class="icon-briefcase"></i>
                                <span class="title">{{ __('apps::dashboard._layout.aside.roles') }}</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    @endcan


                    @can('show_admins')
                        <li class="nav-item {{ active_menu('admins') }}">
                            <a href="{{ url(route('dashboard.admins.index')) }}" class="nav-link nav-toggle">
                                <i class="icon-users"></i>
                                <span class="title">{{ __('apps::dashboard._layout.aside.admins') }}</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    @endcan

                    @can('show_users')
                        <li class="nav-item {{ active_menu('show_users') }}">
                            <a href="{{ url(route('dashboard.users.index')) }}" class="nav-link nav-toggle">
                                <i class="icon-users"></i>
                                <span class="title">{{ __('apps::dashboard._layout.aside.users') }}</span>
                                <span class="selected"></span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcanany



      @can('show_channels')
        <li class="nav-item {{ active_menu('channels') }}">
            <a href="{{ url(route('dashboard.channels.index')) }}" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">{{ __('apps::dashboard._layout.aside.channels') }}</span>
                <span class="selected"></span>
            </a>
        </li>
      @endcan

      @can('show_bots')
        <li class="nav-item {{ active_menu('bots') }}">
            <a href="{{ url(route('dashboard.bots.index')) }}" class="nav-link nav-toggle">
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
{{--                @can('show_messages')--}}
{{--                    <li class="nav-item {{ active_menu('messages') }}">--}}
{{--                        <a href="{{ url(route('dashboard.messages.index')) }}" class="nav-link nav-toggle">--}}
{{--                            <i class="icon-settings"></i>--}}
{{--                            <span class="title">{{ __('apps::dashboard._layout.aside.messages') }}</span>--}}
{{--                            <span class="selected"></span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endcan--}}

                @can('show_bulk_messages')
                    <li class="nav-item {{ active_menu('bulk_messages') }}">
                        <a href="{{ url(route('dashboard.bulk_messages.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.bulk_messages') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endcan

                @can('show_decision_messages')
                    <li class="nav-item {{ active_menu('decision_messages') }}">
                        <a href="{{ url(route('dashboard.decision_messages.index')) }}" class="nav-link nav-toggle">
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
                        <a href="{{ url(route('dashboard.contacts.index')) }}" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.contacts') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endcan

                @can('show_numbers_groups')
                    <li class="nav-item {{ active_menu('numbers_groups') }}">
                        <a href="{{ url(route('dashboard.numbers_groups.index')) }}" class="nav-link nav-toggle">
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
            <a href="{{ url(route('dashboard.templates.index')) }}" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">{{ __('apps::dashboard._layout.aside.templates') }}</span>
                <span class="selected"></span>
            </a>
        </li>
      @endcan

      @can('show_packages')
        <li class="nav-item {{ active_menu('packages') }}">
            <a href="{{ url(route('dashboard.packages.index')) }}" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">{{ __('apps::dashboard._layout.aside.packages') }}</span>
                <span class="selected"></span>
            </a>
        </li>
      @endcan

      @can('show_addons')
        <li class="nav-item {{ active_menu('addons') }}">
            <a href="{{ url(route('dashboard.addons.index')) }}" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">{{ __('apps::dashboard._layout.aside.addons') }}</span>
                <span class="selected"></span>
            </a>
        </li>
      @endcan



        @can('show_coupons')
            <li class="nav-item {{ active_menu('coupons') }}">
                <a href="{{ route('dashboard.coupons.index') }}" class="nav-link nav-toggle">
                    <i class="fa fa-building"></i>
                    <span class="title">{{ __('apps::dashboard._layout.aside.coupons') }}</span>
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
                          <a href="{{ route('dashboard.orders.active_orders') }}" class="nav-link nav-toggle">
                              <i class="fa fa-building"></i>
                              <span class="title">{{ __('apps::dashboard._layout.aside.active_orders') }}</span>
                              <span class="selected"></span>
                          </a>
                      </li>
                  @endcan
                @can('show_orders')
                  <li class="nav-item {{ active_menu('failed_orders') }}">
                      <a href="{{ route('dashboard.orders.failed_orders') }}" class="nav-link nav-toggle">
                          <i class="fa fa-building"></i>
                          <span class="title">{{ __('apps::dashboard._layout.aside.failed_orders') }}</span>
                          <span class="selected"></span>
                      </a>
                  </li>
                @endcan
                @can('show_orders')
                    <li class="nav-item {{ active_menu('pending_orders') }}">
                        <a href="{{ route('dashboard.orders.pending_orders') }}" class="nav-link nav-toggle">
                            <i class="fa fa-building"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.pending_orders') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endcan

                @can('show_orders')
                    <li class="nav-item {{ active_menu('orders') }}">
                        <a href="{{ route('dashboard.orders.index') }}" class="nav-link nav-toggle">
                            <i class="fa fa-building"></i>
                            <span class="title">{{ __('apps::dashboard._layout.aside.all_orders') }}</span>
                            <span class="selected"></span>
                        </a>
                    </li>
                @endcan
                </ul>
            </li>
        @endcan

        @can('show_transactions')
            <li class="nav-item  {{ active_slide_menu('transactions') }}">
                <a href="{{ url(route('dashboard.transactions.index')) }}" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">{{ __('transaction::dashboard.transactions.index.title') }}</span>
                </a>
            </li>
        @endcan

      <li class="heading">
        <h3 class="uppercase">{{ __('apps::dashboard._layout.aside._tabs.other') }}</h3>
      </li>

      @can('show_pages')
      <li class="nav-item {{ active_menu('pages') }}">
        <a href="{{ url(route('dashboard.pages.index')) }}" class="nav-link nav-toggle">
          <i class="icon-docs"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.pages') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

    @can('show_faqs')
        <li class="nav-item {{ active_menu('faqs') }}">
            <a href="{{ url(route('dashboard.faqs.index')) }}" class="nav-link nav-toggle">
                <i class="icon-folder"></i>
                <span class="title">{{ __('apps::dashboard._layout.aside.faqs') }}</span>
                <span class="selected"></span>
            </a>
        </li>
    @endcan

      @canany(['show_countries','show_areas','show_cities','show_states'])
      <li class="nav-item  {{active_slide_menu(['countries','cities','states','areas'])}}">
        <a href="javascript:;" class="nav-link nav-toggle">
          <i class="icon-pointer"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
          <span class="arrow {{active_slide_menu(['countries','governorates','cities','regions'])}}"></span>
          <span class="selected"></span>
        </a>
        <ul class="sub-menu">

          @can('show_countries')
          <li class="nav-item {{ active_menu('countries') }}">
            <a href="{{ url(route('dashboard.countries.index')) }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.countries') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan

          @can('show_cities')
          <li class="nav-item {{ active_menu('cities') }}">
            <a href="{{ url(route('dashboard.cities.index')) }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.cities') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan

          @can('show_states')
          <li class="nav-item {{ active_menu('states') }}">
            <a href="{{ url(route('dashboard.states.index')) }}" class="nav-link nav-toggle">
              <i class="fa fa-building"></i>
              <span class="title">{{ __('apps::dashboard._layout.aside.state') }}</span>
              <span class="selected"></span>
            </a>
          </li>
          @endcan
        </ul>
      </li>
      @endcanAny

      @can('edit_settings')
      <li class="nav-item {{ active_menu('setting') }}">
        <a href="{{ url(route('dashboard.setting.index')) }}" class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.setting') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @can('show_logs')
      <li class="nav-item {{ active_menu('logs-s') }}">
        <a href="{{ url(route('dashboard.logs-s.index')) }}" class="nav-link nav-toggle">
          <i class="icon-folder"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.logs') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan

      @can('show_telescope')
      <li class="nav-item {{ active_menu('telescope') }}">
        <a href="{{ url(route('telescope')) }}" class="nav-link nav-toggle">
          <i class="icon-settings"></i>
          <span class="title">{{ __('apps::dashboard._layout.aside.telescope') }}</span>
          <span class="selected"></span>
        </a>
      </li>
      @endcan
    </ul>
  </div>

</div>
