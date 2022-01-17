<div id="sidebar-wrapper">
    <div class="simplebar-scroll-content">
        <div class="simplebar-content">
            <div class="brand-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/defaults/logo.png') }}" class="logo-icon mt-4" alt="logo icon">
                </a>
            </div>
            <ul class="sidebar-menu">
                <li class="sidebar-header">{{ __('lang.menu') }}</li>
                <li>
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="fa fa-angle-right"></i>
                        <span>{{ __('lang.home') }}</span>
                        <i class="zmdi zmdi-menu pull-right mt-1"></i>
                    </a>
                </li>
                @if(Auth::user()->isAdminStaffAllowed("users"))
                <li>
                    <a href="#" class="waves-effect">
                        <i class="fa fa-angle-right"></i>
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
                        <li>
                            <a href="{{ route('admin-users.drivers.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.drivers') }}
                            </a>
                        </li>

                    </ul>
                </li>
                @endif
                @if(Auth::user()->isAdminStaffAllowed("pharmacies"))
                <li>
                    <a href="{{ route('admin.pharmacies.index') }}">
                        <i class="fa fa-angle-right"></i> {{ __('lang.pharmacies') }}
                        <i class="zmdi zmdi-hospital pull-right mt-1"></i>
                    </a>
                </li>
                @endif
                @if(Auth::user()->isAdminStaffAllowed("orders"))
                <li>
                    <a href="{{ route('admin.orders.index') }}">
                        <i class="fa fa-angle-right"></i> {{ __('lang.orders') }}
                        <i class="zmdi zmdi-shopping-cart pull-right mt-1"></i>
                    </a>
                </li>
                @endif
                
                @if(Auth::user()->isAdminStaffAllowed("discounts"))
                <li>
                    <a href="{{ route('admin.discounts.index') }}">
                        <i class="fa fa-angle-right"></i> {{ __('lang.discounts') }}
                        <i class="zmdi zmdi-money-off pull-right mt-1"></i>
                    </a>
                </li>
                @endif
                
                
                @if(Auth::user()->isAdminStaffAllowed("notifications"))
                <li>
                    <a href="{{ route('admin.notifications.index') }}">
                        <i class="fa fa-angle-right"></i> {{ __('lang.notifications') }}
                        <i class="zmdi zmdi-notifications pull-right mt-1"></i>
                    </a>
                </li>
                @endif
                
                
                @if(Auth::user()->isAdminStaffAllowed("payments"))
                <li>
                    <a href="{{ route('admin.payments.index') }}">
                        <i class="fa fa-angle-right"></i> {{ ucwords( __('lang.payments') )}}
                        <i class="zmdi zmdi-money pull-right mt-1"></i>
                    </a>
                </li>
                @endif
                
                @if(Auth::user()->isAdminStaffAllowed("products"))
                <li>
                    <!-- <a href="{{ route('admin-products.products.index') }}">
                        <i class="fa fa-angle-right"></i>
                        <span>{{ __('lang.products') }}</span>
                        <i class="zmdi zmdi-settings pull-right mt-1"></i>
                    </a> -->
                    <a href="#" class="waves-effect">
                        <i class="fa fa-angle-right"></i>
                        <span>{{ __('lang.products') }}</span>
                        <i class="zmdi zmdi-collection-item pull-right mt-1"></i>
                    </a>
                    <ul class="sidebar-submenu menu-open">
                        <li>
                            <a href="{{ route('admin-products.products.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.products') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-products.products-upload.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.products_upload') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-products.products-requests.index') }}">
                                <i class="zmdi zmdi-star"></i> {{ __('lang.product_requests') }}
                            </a>
                        </li>
                        
                    </ul>
                </li>
                @endif
                @if(Auth::user()->isAdminStaffAllowed("settings"))
                <li>
                    <a href="#" class="waves-effect">
                        <i class="fa fa-angle-right"></i>
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
                @endif
                <!-- <li>
                <a href="#" class="waves-effect">
                    <i class="fa fa-angle-right"></i>
                    <span>{{ __('lang.messages') }}</span>
                    <i class="zmdi zmdi-accounts pull-right mt-1"></i>
                </a>
            </li>
            <li>
                <a href="#" class="waves-effect">
                    <i class="fa fa-angle-right"></i>
                    <span>{{ __('lang.payments') }}</span>
                    <i class="zmdi zmdi-accounts pull-right mt-1"></i>
                </a>
            </li>
            <li>
                <a href="#" class="waves-effect">
                    <i class="fa fa-angle-right"></i>
                    <span>{{ __('lang.reports') }}</span>
                    <i class="zmdi zmdi-accounts pull-right mt-1"></i>
                </a>
            </li>
            <li>
                <a href="#" class="waves-effect">
                    <i class="fa fa-angle-right"></i>
                    <span>{{ __('lang.Notification') }}</span>
                    <i class="zmdi zmdi-accounts pull-right mt-1"></i>
                </a>
            </li> -->

                {{-- @endif --}}
            </ul>
        </div>
    </div>
</div>
