<li class="sidebar__item has-child">
    <div class="arrow">
    </div>
    <a href="#" class="sidebar__link">
        <i class="fa-solid fa-user text-white"></i>
        <span class="text-white ms-2">Quản lý tài khoản</span>
    </a>
    <ul class="siderbar__submenu">
        <li class="siderbar__submenu-item">
            <a href="{{ url('ceo/user/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Thêm tài khoản</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('ceo/user/') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Danh sách tài khoản</span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar__item has-child">
    <div class="arrow">
    </div>
    <a href="#" class="sidebar__link">
        <i class="fa-solid fa-person-shelter text-white"></i>

        <span class="text-white ms-2">Quản lý phòng ban</span>
    </a>
    <ul class="siderbar__submenu">
        <li class="siderbar__submenu-item">
            <a href="{{ url('ceo/department/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Thêm phòng ban</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('ceo/department/') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Danh sách phòng ban</span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar__item has-child">
    <div class="arrow">
    </div>
    <a href="#" class="sidebar__link">
        <i class="fa-solid fa-briefcase text-white"></i>
        <span class="text-white ms-2">Quản lý công việc</span>
    </a>
    <ul class="siderbar__submenu">
        <li class="siderbar__submenu-item">
            <a href="{{ url('ceo/task/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Thêm công việc</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('ceo/task/') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Danh sách công việc</span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar__item has-child">
    <div class="arrow">
    </div>
    <a href="#" class="sidebar__link">
        <i class="fa-solid fa-notes-medical text-white"></i>
        <span class="text-white ms-2">Quản lý phúc lợi</span>
    </a>
    <ul class="siderbar__submenu">
        <li class="siderbar__submenu-item">
            <a href="{{ url('ceo/benefit/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Thêm phúc lợi</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('ceo/benefit/') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Danh sách phúc lợi</span>
            </a>
        </li>
    </ul>
</li>
<li class="sidebar__item ">
    <a href="{{ url('ceo/task-management') }}" class="sidebar__link">
        <i class="fa-solid fa-list-check text-white"></i>
        <span class="text-white ms-2">Theo dõi công việc</span>
    </a>
</li>
<li class="sidebar__item ">
    <a href="{{ url('ceo/list-benefits') }}" class="sidebar__link">
        <i class="fa-solid fa-laptop-medical text-white"></i>
        <span class="text-white ms-2">Phúc lợi</span>
    </a>
</li>

<li class="sidebar__item ">
    <a href="{{ url('time') }}" class="sidebar__link">
        <i class="fa-solid fa-calendar-days text-white"></i>
        <span class="text-white ms-2">Danh sách chấm công</span>
    </a>
</li>

<li class="sidebar__item ">
    <a href="{{ url('salary/create-month-salary') }}" class="sidebar__link">
        <i class="fa-solid fa-wallet text-white"></i>
        <span class="text-white ms-2">Lương</span>
    </a>
</li>
<li class="sidebar__item ">
    <a href="{{ url('salary/statistic') }}" class="sidebar__link">
        <i class="fa-solid fa-chart-line text-white"></i>
        <span class="text-white ms-2">Thống kê lương</span>
    </a>
</li>