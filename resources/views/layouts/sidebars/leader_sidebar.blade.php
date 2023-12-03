<li class="sidebar__item ">
    <a href="{{ url('leader/list-employee', Auth::user()->id) }}" class="sidebar__link">
        <i class="fa-solid fa-user text-white"></i>
        <span class="text-white ms-2">Danh sách nhân viên</span>
    </a>

</li>
<li class="sidebar__item ">
    <a href="{{ url('leader/list-task-management', Auth::user()->id) }}" class="sidebar__link">
        <i class="fa-solid fa-list-check text-white"></i>
        <span class="text-white ms-2">Tiến trình công việc</span>
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
