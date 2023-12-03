<div class="sidebar-wrap col-2 pe-0 background-default">
    <div class="sidebar-header  ">
        <?php
use App\Models\Position;

        $role;
        $user = Auth::user();
        $position_code = Position::getPositionCodeByUser($user);
        switch ($position_code) {
            case 'admin':
                $role = 'admin';
                break;
            case 'employee':
                $role = 'employee';
                break;
            case 'leader':
                $role = 'leader';
                break;
            case 'ceo':
                $role = 'ceo';
                break;
            // Xử lý cho các vị trí khác (nếu cần)
            // default:
            //     return redirect(RouteServiceProvider::HOME);
            //     break;
        }
        ?>
        <a class="navbar-brand" href="{{ url('/',$role) }}">
            <div class="logo logo-text">
                ApexTech Inc.
            </div>
        </a>
    </div>
    <?php
    $user = Auth::user();
    ?>
    <div class="sidebar-body">
        <ul class="sidebar__menu">
            {{-- <li class="sidebar__item">
                <a href="#" class="sidebar__link">
                    <i class="fa-solid fa-house text-white"></i>
                    <span class="text-white ms-2">Item 1</span>
                </a>
            </li> --}}
            {{-- admin --}}

            @if ($user !== null && $user->position_id == 1)
                @include('layouts.sidebars.admin_sidebar')
            @endif
            @if ($user !== null && $user->position_id == 2)
                @include('layouts.sidebars.employee_sidebar')
            @endif
            @if ($user !== null && $user->position_id == 3)
                @include('layouts.sidebars.leader_sidebar')
            @endif
            @if ($user !== null && $user->position_id == 4)
                @include('layouts.sidebars.ceo_sidebar')
            @endif

            {{-- <li class="sidebar__item has-child">
                <div class="arrow">

                </div>
                <a href="#" class="sidebar__link">
                    <i class="fa-solid fa-house text-white"></i>
                    <span class="text-white ms-2">Item 3</span>
                </a>
                <ul class="siderbar__submenu">
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li>
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li>
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar__item has-child">
                <div class="arrow">

                </div>
                <a href="#" class="sidebar__link">
                    <i class="fa-solid fa-house text-white"></i>
                    <span class="text-white ms-2">Item 4</span>
                </a>
                <ul class="siderbar__submenu">
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li>
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li>
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sidebar__item has-child">
                <div class="arrow">

                </div>
                <a href="#" class="sidebar__link">
                    <i class="fa-solid fa-house text-white"></i>
                    <span class="text-white ms-2">Item 2</span>
                </a>
                <ul class="siderbar__submenu">
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li>
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li>
                    <li class="siderbar__submenu-item">
                        <a href="#" class="submenu__link">
                            <i class="fa-regular fa-circle text-white"></i>
                            <span class="text-white">Menu child item 1</span>
                        </a>
                    </li> --}}
        </ul>
        </li>

        </ul>
    </div>
</div>
