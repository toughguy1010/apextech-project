@extends('layouts.app')

@section('content')
    <?php
    use App\Models\TimeLog;
    use Carbon\Carbon;
    ?>
    <div class="container-fluid">
        <div class="time_log-wrap">
            <div class="time_log-header">
                <p>
                    Bảng chấm công
                </p>
            </div>
            <form action="">
                <div class="time_log-filter row">
                    <div class="filter-item col-3 ps-0">
                        <div class="label">Phòng ban</div>
                        <select name="department" id="" class="form-select">
                            <option value="">---Chọn phòng ban---</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ isset($_GET['department']) && $_GET['department'] == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-item col-3">
                        <div class="label">Vị trí</div>
                        <select name="position" id="" class="form-select">
                            <option value="">---Chọn vị trí---</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}"
                                    {{ isset($_GET['position']) && $_GET['position'] == $position->id ? 'selected' : '' }}>
                                    {{ $position->position_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-item col-3 pe-0">
                        <div class="label">Sắp xếp</div>
                        <select name="orderby" id="" class="form-select">
                            <option value="">---Mặc định---</option>
                            <option value="asc"
                                {{ isset($_GET['orderby']) && $_GET['orderby'] == 'asc' ? 'selected' : '' }}>Từ trên xuống
                                dưới</option>
                            <option value="desc"
                                {{ isset($_GET['orderby']) && $_GET['orderby'] == 'desc' ? 'selected' : '' }}>Từ dưới lên
                                trên</option>
                        </select>
                    </div>
                    <div class="filter-btn col-3 d-flex align-item-center justify-content-end">
                        <button class="btn btn-primary" style="height:40px; width:120px;  margin-top: 34px;">
                            Lọc
                        </button>
                    </div>
                </div>
            </form>
            <div class="time_log-body">
                <div class="time_log-action d-flex justify-content-between align-items-baseline  mt-4 mb-4">
                    <p>
                        <strong style="font-size: 18px"> <?= $currentMonth . ' ' . $currentYear ?> </strong>
                    </p>
                    <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#time_logs_modal">
                        Đăng ký vào / Đăng ký ra
                    </button>
                </div>
                <div class="time_log-table d-flex align-items-start">
                    <div class="list_users-table">
                        <div class="list_users-header">
                            Nhân viên
                        </div>
                        <div class="list_users-body">
                            @foreach ($users as $user)
                                <div class="list_users-item {{ $user->id == Auth::user()->id ? 'current-user' : '' }}">
                                    {{ $user->name }}
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="list_user_body  table-responsive" style="overflow-x: auto;">
                        <table class="table " style="box-shadow: none">
                            <thead>
                                @foreach ($days as $day)
                                    <th class="day">
                                        <span>
                                            {{ $day['weekday'] }}
                                            ({{ sprintf('%02d', $day['day']) }}/{{ $day['month'] }})
                                        </span>

                                    </th>
                                @endforeach

                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr class="">
                                        <?php
                                        $currentDateTime = Carbon::now();
                                        $currentDateTime->setTimezone('Asia/Ho_Chi_Minh');
                                        $formattedDateTime = $currentDateTime->format('Y-m-d');
                                        
                                        $date = Carbon::parse($day['date']);
                                        $isWeekend = $date->isWeekend();
                                        ?>
                                        @foreach ($days as $day)
                                        <td class="avg_timelogs {{ $user->id == Auth::user()->id ? 'current-user' : '' }} {{ $day['date'] == $formattedDateTime && $user->id == Auth::user()->id ? 'current-date_time' : '' }}">
                                            <?php
                                                $date = Carbon::parse($day['date']);
                                                $isWeekend = $date->isWeekend();
                                    
                                                if (!$isWeekend) {
                                                    $time_logs = TimeLog::getHoursWorked($user->id, $day['date']);
                                                    if ($time_logs) {
                                            ?>
                                                        <div class="show_time-logs" data-userID="{{ $user->id }}"
                                                            data-date="{{ $day['date'] }}"
                                                            data-url="{{ url('time/date-time-log') }}">
                                                            {{ $time_logs }}
                                                        </div>
                                            <?php
                                                    } else {
                                                        echo "0";
                                                    }
                                                } else {
                                                    echo "Ngày nghỉ";
                                                }
                                            ?>
                                        </td>
                                    @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
                @if (count($users) == 0)
                    Không có dữ liệu người dùng
                @endif
            </div>
        </div>
    </div>
    <div class="time_log-detail">

    </div>
    @vite(['resources/js/time_logs.js'])
    @include('layouts.time_logs.time_logs_modal')
@endsection
