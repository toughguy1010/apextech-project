<li class="sidebar__item has-child">
    <div class="arrow">
    </div>
    <a href="#" class="sidebar__link">
        <i class="fa-solid fa-user text-white"></i>
        <span class="text-white ms-2">Quản lý tài khoản</span>
    </a>
    <ul class="siderbar__submenu">
        <li class="siderbar__submenu-item">
            <a href="{{ url('admin/user/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Thêm tài khoản</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('admin/user/') }}" class="submenu__link">
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
            <a href="{{ url('admin/department/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>

                <span class="text-white">Thêm phòng ban</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('admin/department/') }}" class="submenu__link">
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
            <a href="{{ url('admin/task/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Thêm công việc</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('admin/task/') }}" class="submenu__link">
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
            <a href="{{ url('admin/benefit/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Thêm phúc lợi</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('admin/benefit/') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Danh sách phúc lợi</span>
            </a>
        </li>
    </ul>
</li>

<li class="sidebar__item ">
    <a href="{{ url('time') }}" class="sidebar__link">
        <i class="fa-solid fa-calendar-days text-white"></i>
        <span class="text-white ms-2">Danh sách chấm công</span>
    </a>
</li>


<li class="sidebar__item ">
    <a href="{{ url('admin/user/role') }}" class="sidebar__link">
        <i class="fa-solid fa-circle-plus text-white"></i>
        <span class="text-white ms-2">Phân quyền</span>
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