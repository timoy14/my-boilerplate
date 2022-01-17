<header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top bg-white">
        <ul class="navbar-nav mr-auto align-items-center ">
            <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#"
                    aria-expanded="false">
                    <span class="user-profile"><img src="{{ asset('images/defaults/logomarks.png')}}" class="img-circle"
                            alt="user avatar"></span>
                </a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item user-details">
                        <a href="javaScript:void();">
                            <div class="media">
                                <div class="avatar"><img class="align-self-start mr-3"
                                        src="{{ asset('images/defaults/logo.png') }}" alt="user avatar"></div>
                                <div class="media-body">
                                    <h6 class="mt-2 user-title">{{ Auth::user()->name }}</h6>
                                    <p class="user-subtitle">{{ Auth::user()->phone }}</p>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="dropdown-divider"></li>
                    <a href="{{ route('language','ar') }}">
                        <li class="dropdown-item"><i class="flag-icon flag-icon-sa mr-2"></i>{{ __('lang.arabic') }}
                        </li>
                    </a>
                    <li class="dropdown-divider"></li>
                    <a href="{{ route('language','en') }}">
                        <li class="dropdown-item"><i
                                class="flag-icon flag-icon-us mr-2"></i></i>{{ __('lang.english') }}</li>
                    </a>
                    <li class="dropdown-divider"></li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <li class="dropdown-item"><i class="icon-power mr-2"></i>{{ __('lang.logout') }}</li>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </ul>
            </li>
        </ul>
        <ul class="navbar-nav  align-items-center right-nav-link">
            <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                    <i class="icon-menu menu-icon"></i>
                </a>
            </li>
        </ul>
    </nav>
</header>
