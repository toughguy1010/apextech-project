
<li class="sidebar__item ">
    <a href="{{ url('employee/department', Auth::user()->id) }}" class="sidebar__link">
        <i class="fa-solid fa-building-user text-white"></i>
        <span class="text-white ms-2">Thông tin phòng ban</span>
    </a>
</li>
<li class="sidebar__item ">
    <a href="{{ url('employee/task', Auth::user()->id) }}" class="sidebar__link">
        <i class="fa-solid fa-square-check text-white"></i>
        <span class="text-white ms-2">Công việc</span>
    </a>
</li>
<li class="sidebar__item ">
    <a href="{{ url('employee/list-benefits') }}" class="sidebar__link">
        <i class="fa-solid fa-laptop-medical text-white"></i>
        <span class="text-white ms-2">Phúc lợi</span>
    </a>
</li>
<li class="sidebar__item ">
    <a href="{{ url('time') }}" class="sidebar__link">
        <i class="fa-solid fa-calendar-days text-white"></i>
        <span class="text-white ms-2">Chấm công</span>
    </a>
</li>
<li class="sidebar__item has-child">
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