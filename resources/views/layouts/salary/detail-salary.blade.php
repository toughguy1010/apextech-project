<?php
use App\Models\Salary;
use App\Models\User;

?>
<div class="modal fade" id="detail_salary" tabindex="-1" aria-labelledby="detail_salary" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 600px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detail_salary d-flex flex-column">
                    {{ $salary->title }}
                    <span style="font-size: 13px; color:#565656;font-weight: 400; display:block">
                        Chi tiết lương tháng: {{ $salary->month }} -
                        {{ $salary->year }}</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 20px !important">
                <div class="date_time_logs_detail">
                    <div class="border-item work-hour">
                        Số giờ làm việc thực tế của tháng: {{ $salary->hours_worked }} giờ
                    </div>
                    <div class="border-item work-hour">
                        Số giờ làm việc tiêu chuẩn của tháng: {{ $salary->standard_hour }} giờ
                    </div>
                    <div class="border-item working-time">
                        Lương cơ bản: {{ number_format($user->base_salary, 0, ',', '.') }} VNĐ
                    </div>
                    <div class="border-item working-time">
                        Lương thực nhận tháng {{ $salary->month }}/{{ $salary->year }} :
                        {{ number_format($salary->calculated_salary, 0, ',', '.') }} VNĐ
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
