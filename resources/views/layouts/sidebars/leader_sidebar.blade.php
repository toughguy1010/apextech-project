<li class="sidebar__item ">
    <a href="{{ url('leader/list-employee', Auth::user()->id) }}" class="sidebar__link">
        <i class="fa-solid fa-user text-white"></i>
        <span class="text-white ms-2">Danh sách nhân viên</span>
    </a>

</li>
<li class="sidebar__item ">
    <a href="{{ url('leader/list-task-management', Auth::user()->id) }}" class="sidebar__link">
        <i class="fa-solid fa-list-check text-white"></i>
        <span class="text-white ms-2">Theo dõi công việc</span>
    </a>
</li>
<li class="sidebar__item ">
    <a href="{{ url('leader/list-benefits') }}" class="sidebar__link">
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
        <i class="fa-solid fa-briefcase text-white"></i>
        <span class="text-white ms-2">Quản lý công việc</span>
    </a>
    <ul class="siderbar__submenu">
        <li class="siderbar__submenu-item">
            <a href="{{ url('leader/task/upsert') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Thêm công việc</span>
            </a>
        </li>
        <li class="siderbar__submenu-item">
            <a href="{{ url('leader/task/') }}" class="submenu__link">
                <i class="fa-regular fa-circle text-white"></i>
                <span class="text-white">Danh sách công việc</span>
            </a>
        </li>
    </ul>
</li>
@if (Auth::user()->role == 1)
    <li class="sidebar__item has-child">
        <div class="arrow">
        </div>
        <a href="#" class="sidebar__link">
            <i class="fa-solid fa-user text-white"></i>
            <span class="text-white ms-2">Quản lý tài khoản</span>
        </a>
        <ul class="siderbar__submenu">
            <li class="siderbar__submenu-item">
                <a href="{{ url('employee/user/upsert') }}" class="submenu__link">
                    <i class="fa-regular fa-circle text-white"></i>
                    <span class="text-white">Thêm tài khoản</span>
                </a>
            </li>
            <li class="siderbar__submenu-item">
                <a href="{{ url('employee/user/') }}" class="submenu__link">
                    <i class="fa-regular fa-circle text-white"></i>
                    <span class="text-white">Danh sách tài khoản</span>
                </a>
            </li>
        </ul>
    </li>
@elseif(Auth::user()->role == 2)
    <li class="siderbar__submenu-item">
        <a href="{{ url('employee/department-manager/list') }}" class="sidebar__link">
            <i class="fa-solid fa-person-shelter text-white"></i>
            <span class="text-white ms-2">Quản lý phòng ban </span>
        </a>
    </li>
@elseif(Auth::user()->role == 3)
<li class="sidebar__item ">
    <a href="{{ url('salary/create-month-salary') }}" class="sidebar__link">
        <i class="fa-solid fa-wallet text-white"></i>
        <span class="text-white ms-2">Tạo bảng lương</span>
    </a>
</li>
    <li class="sidebar__item ">
        <a href="{{ url('salary/statistic') }}" class="sidebar__link">
            <i class="fa-solid fa-chart-line text-white"></i>
            <span class="text-white ms-2">Thống kê lương</span>
        </a>
    </li>
@endif