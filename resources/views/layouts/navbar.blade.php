<?php
use App\Models\ReceiverNotification;

?>
<nav id="app-navbar" class="navbar navbar-expand-md navbar-light background-default shadow-sm ">
    <div class="container">

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link white-text" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link white-text" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="notification" class="nav-link text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false"
                            data-url="{{ url('get-notification', Auth::user()->id) }}">
                            <i class="fa-regular fa-bell"></i>
                            @if (ReceiverNotification::countUnreadNotifications(Auth::user()->id) > 0)
                            <div id="unread_notification">
                                {{  ReceiverNotification::countUnreadNotifications(Auth::user()->id) }}
                            </div>   
                            @endif
                        </a>

                        <div id="notification_item" class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="{{ Auth::user()->avatar }}" alt="" class="avt ms-2 me-2">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('personalInfo', ['id' => Auth::user()->id]) }}">
                                {{ __('Thông tin cá nhân') }}
                            </a>
                            <a class="btn dropdown-item " href="{{ url('change-password', Auth::user()->id) }}">
                                {{ __('Đổi mật khẩu') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Đăng xuất') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
