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