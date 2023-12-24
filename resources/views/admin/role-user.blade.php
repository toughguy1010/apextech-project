<?php
use App\Models\Department;
use App\Models\Position;
?>
<table class="table ">
    <thead>
        <th>
            Chọn
        </th>
        <th>
            Tên người dùng
        </th>
        <th>
            Tài khoản
        </th>
        <th>
            Email - Số điện thoại
        </th>

        <th>
            Ngày bắt đầu
        </th>
        <th>
            Chức vụ
        </th>
        <th>
            Trạng thái
        </th>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <?php
            $department = Department::getDepartmentByUser($user->id);
            $department_role = $department->role;
            ?>
            <tr id="user-{{ $user->id }}">
                <td>
                    <input class="form-check-input chose-role" type="checkbox" value="" id="flexCheckDefault"
                        {{ $user->role ? 'checked' : '' }} data-role ="{{ $department_role }}"
                        data-url = "{{ url('admin/user/update-role', $user->id) }}">
                </td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td class="have-wrap">
                    {{ $user->email ?: 'Không có dữ liệu' }}
                    <br>
                    {{ $user->phone_number ?: 'Không có dữ liệu' }}
                </td>
                <td>{{ $user->on_board }}</td>
                <td>
                    <?php
                    $position = Position::getPositionNameByUser($user);
                    echo $position;
                    ?>
                </td>
                <td>
                    <div class="satus-active">
                        {{ $user->status == 1 ? 'Đang làm việc' : 'Đã nghỉ việc' }}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="message-report">
    <i class="fa-regular fa-bell me-2"></i>
</div>
<script>
    $(function() {
        $(".chose-role").on("change", function() {
            var isChecked = $(this).is(":checked");
            var url = $(this).data("url");
            var role = $(this).data("role");
            if (isChecked) {
                updateRole(url, role)
            } else {
                role = null;
                updateRole(url, role)

            }
        })

        function updateRole(url, role) {
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: {
                    role: role
                },
                success: function(response) {
                    $(".message-report").html(response.message);

                    if (response.status == 1) {
                        $(".message-report").removeClass("false-message-report")
                        $(".message-report").addClass("active-message-report");
                        setTimeout(function() {
                        $(".message-report").fadeOut();
                    }, 3000);
                    } else {
                        $(".message-report").removeClass("active-message-report")
                        $(".message-report").addClass("false-message-report");
                        setTimeout(function() {
                        $(".message-report").fadeOut();
                    }, 3000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log("Error:", textStatus, errorThrown);
                }
            })
        }
    });
</script>
