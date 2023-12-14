<!-- Modal -->
<?php
use App\Models\User;

?>
<div class="modal fade" id="date_time-logs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="post" class="modal-content">
            <?php
            $date = $date_time_logs->date;
            $formatted_date = date('d-m Y', strtotime($date));
            ?>
            <div class="modal-header">
                <div class="fs-4" id="exampleModalLabel">
                    {{ User::getUserNameByID($date_time_logs->user_id) }} ({{ $formatted_date }})
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="date_time_logs_detail">
                    <div class="border-item work-hour">
                        Số giờ làm việc: <span>{{ $date_time_logs->hours_worked }} giờ</span>
                    </div>
                    <div class="border-item working-time">
                        Thời gian làm việc: 08:00 - 17:00
                    </div>
                    <div class="border-item working-time">
                        Nghỉ trưa: 12:00 - 13:00
                    </div>
                    <div class="border-item time-logs-diary">
                        <div class="time-diary-header">
                            Nhật ký đăng ký vào / đăng ký ra
                        </div>
                        <div  class="time-diary-body">
                            <div class="diary-checkin">
                                @if (Auth::user()->position_id == 2 || Auth::user()->position_id == 3)
                                    <i class="fa-solid fa-arrow-right-from-bracket text-success"></i>
                                    {{ $formatted_date }}
                                    {{ $date_time_logs->check_in }}
                                @else
                                    <input type="time" class="form-control" value="{{ $date_time_logs->check_in }}">
                                @endif

                            </div>
                            <div class="diary-checkout">
                                @if (Auth::user()->position_id == 2 || Auth::user()->position_id == 3)
                                    <i class="fa-solid fa-arrow-right-from-bracket text-warning"
                                        style="transform: rotate(180deg);"></i> {{ $formatted_date }}
                                    {{ $date_time_logs->check_out }}
                                @else
                                <input type="time" class="form-control" value="{{ $date_time_logs->check_out }}">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Lưu</button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var taskDetailModal = document.getElementById('date_time-logs');
        taskDetailModal.classList.add('show');
    });
</script>
