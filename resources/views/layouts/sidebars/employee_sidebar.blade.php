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
<li class="sidebar__item ">
    <a href="{{ url('salary/user-salary-statistics', Auth::user()->id) }}" class="sidebar__link">
        <i class="fa-solid fa-square-poll-horizontal text-white"></i>
        <span class="text-white ms-2">Bảng lương</span>
    </a>
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
