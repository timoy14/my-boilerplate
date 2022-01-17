<div id="sidebar-wrapper">
    <div class="simplebar-scroll-content">
        <div class="simplebar-content">
            <div class="brand-logo">
                <a href="{{ route('home') }}">
                    <!-- <img src="{{ asset('images/defaults/logo.png') }}" class="logo-icon mt-4" alt="logo icon"> -->
                </a>
            </div>
            <ul class="sidebar-menu">
                <li class="sidebar-header">{{ __('lang.menu') }}</li>
                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="zmdi zmdi-chevron-right"></i>
                        <span>{{ __('lang.home') }}</span>
                        <i class="zmdi zmdi-menu pull-right mt-1"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="waves-effect">
                        <i class="zmdi zmdi-chevron-right"></i>
                        <span>{{ __('lang.users') }}</span>
                        <i class="zmdi zmdi-accounts pull-right mt-1"></i>
                    </a>
                    <ul class="sidebar-submenu menu-open">
                        <li>
                            <a href="{{ route('admin-users.admins.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.admins') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-users.staffs.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.admin_staff') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-users.customers.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.customers') }}
                            </a>
                        </li>
                      

                    </ul>
                </li>
            


                <li>
                    <a href="{{ route('admin.notifications.index') }}">
                        <i class="zmdi zmdi-chevron-right"></i> {{ __('lang.notifications') }}
                        <i class="zmdi zmdi-notifications pull-right mt-1"></i>
                    </a>
                </li>

            
                <li>
                    <a href="#" class="waves-effect">
                        <i class="zmdi zmdi-chevron-right"></i>
                        <span>{{ __('lang.settings') }}</span>
                        <i class="zmdi zmdi-settings pull-right mt-1"></i>
                    </a>
                    <ul class="sidebar-submenu menu-open">


                        <li>
                            <a href="{{ route('settings.about-us.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.about_us') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.contact-us.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.contact_us') }}

                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.terms-and-conditions.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.terms_and_conditions') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.cancellation-policy.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.cancellation_policy') }}
                            </a>
                        </li>


                        <li>
                            <a href="{{ route('settings.general-setting.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.general_setting') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('settings.cities.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.cities') }}
                            </a>
                        </li>
                   
                        
                    </ul>
                </li>
            

                {{-- @endif --}}
            </ul>
        </div>
    </div>
</div>
