<?php
use App\Models\Task;
use App\Models\Position;

$get_ceo = Position::getUsersByPositionCode('ceo');
$ceo_ids = $get_ceo->pluck('id')->toArray();
$ceo_id = $ceo_ids[0];

?>
<div class="modal fade" id="task-detail-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <div class="task-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ $task->name }}</h5>
                    <div class="task-status">
                        <span class="task-status-text">
                            {{ Task::getStatus($task->status) }}
                        </span>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding-bottom: 0">
                <div class="row">
                    <div class="col-8 main-task-col">

                        <div class="task-btn-group">
                            @if (Position::getPositionCodeByUser(Auth::user()) == 'employee')
                                <div class="btn btn-outline-primary btn-status"
                                    data-url="{{ url('employee/update-task-status', $task->id) }}"
                                    data-curStatus="{{ $task->status }}">
                                    {{ $task->status == 1 ? 'Bỏ tiến hành' : 'Bắt đầu tiến hành' }}
                                </div>
                                <div class="btn btn-success btn-report ms-3 "
                                    data-url="{{ url('employee/report-task-status', $task->id) }} "
                                    data-userID="{{ $current_task_assignees['userID'] }}">
                                    <i class="fa-regular fa-paper-plane me-1"></i>
                                    Báo cáo
                                </div>
                            @elseif(Position::getPositionCodeByUser(Auth::user()) == 'leader')
                                <select name="update-task-status" class="update-task-status "
                                    data-url="{{ url('leader/update-task-status', $task->id) }}">
                                    @if ($task->status != Task::NOT_START && $task->status != Task::INPROGRESS && $task->status != Task::TESTING)
                                    <option value="{{ $task->status }}"> {{ Task::getStatus($task->status) }}</option>
                                    @endif
                                    <option value="{{ Task::NOT_START }}"
                                        @if ($task->status == Task::NOT_START) selected @endif> Chưa bắt đầu</option>
                                    <option value="{{ Task::INPROGRESS }}"
                                        @if ($task->status == Task::INPROGRESS) selected @endif> Đang tiến hành</option>
                                    <option value="{{ Task::TESTING }}"
                                        @if ($task->status == Task::TESTING) selected @endif>
                                        Đang kiểm tra</option>
                                </select>
                                <div class="btn btn-success btn-report ms-3 mt-3 "
                                    data-url="{{ url('leader/report-task-status', $task->id) }} "
                                    data-ceoID="{{ $ceo_id }}" data-userID="{{ Auth::user()->id }}">
                                    <i class="fa-regular fa-paper-plane me-1"></i>
                                    Báo cáo
                                </div>
                            @elseif(Position::getPositionCodeByUser(Auth::user()) == 'ceo')
                                <div class="btn {{ $task->status != 3 ? 'btn-primary' : 'btn-danger' }} btn-confirm ms-3 mt-3 "
                                    data-url="{{ url('ceo/confirm-task-status', $task->id) }} "
                                    data-userID="{{ Auth::user()->id }}" data-status="{{ $task->status }}">


                                    {!! $task->status != 3
                                        ? '<i class="fa-solid fa-check me-1"></i> Xác nhận hoàn thành'
                                        : '<i class="fa-solid fa-exclamation me-1"></i> Đánh dấu chưa hoàn thành' !!}
                                </div>
                            @endif


                        </div>
                        <div class="task-description-wrap">
                            <div class="task-description-title">
                                <span>Mô tả</span>
                                <i class="fa-regular fa-pen-to-square text-primary ms-1"></i>
                            </div>
                            <p class="task-description-content">
                                {{ $task->description }}
                            </p>
                        </div>
                        <div class="task-content-wrap">
                            <div class="task-content-title">
                                <span>Nội dung công việc</span>
                                <i class="fa-solid fa-highlighter text-primary ms-1"></i>
                            </div>
                            <p class="task-content-content">
                                {{ $task->content }}
                            </p>
                        </div>

                    </div>
                    <div class="col-4  sub-task-col">
                        <div class="sub-task-header">
                            Thông tin công việc
                        </div>
                        <div class="sub-task-body">
                            <div class="sub-task-body-item">
                                <div class="task-body-item-label">
                                    <i class="fa-solid fa-signal"></i>
                                    <p>Trạng thái: </p>
                                </div>
                                <div class="taks-body-value task-status-text">
                                    {{ Task::getStatus($task->status) }}
                                </div>
                            </div>
                            <div class="sub-task-body-item">
                                <div class="task-body-item-label">
                                    <i class="fa-regular fa-calendar"></i>
                                    <p>Ngày bắt đầu: </p>
                                </div>
                                <div class="taks-body-value task-start-date">
                                    {{ $task->start_date }}
                                </div>
                            </div>
                            <div class="sub-task-body-item">
                                <div class="task-body-item-label">
                                    <i class="fa-regular fa-calendar-check"></i>
                                    <p>Ngày kết thúc: </p>
                                </div>
                                <div class="taks-body-value task-end-date">
                                    {{ $task->end_date }}
                                </div>
                            </div>
                            <div class="sub-task-body-item">
                                <div class="task-body-item-label">
                                    <i class="fa-solid fa-gauge"></i>
                                    <p>Mức độ ưu tiên: </p>
                                </div>
                                <div class="taks-body-value task-priority-text">
                                    {{ Task::getPriority($task->priority) }}

                                </div>
                            </div>

                            <div class="assigness-wrap">
                                <div class="people-label d-flex">
                                    <i class="fa-solid fa-users"></i>
                                    <p class="mb-1">Nhân viên thực hiện công việc: </p>
                                </div>
                                <div class="people-imgs task-assigess-list">
                                    @if (count($task->assignees) > 0)
                                        @foreach ($task->assignees as $assignee)
                                            <img src=" {{ $assignee->avatar }}" alt="">
                                        @endforeach
                                    @else
                                        <span>
                                            Chưa giao cho nhân viên nào
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="manager-wrap mt-4">
                                <div class="people-label d-flex">
                                    <i class="fa-solid fa-users"></i>
                                    <p class="mb-1">Người theo dõi công việc: </p>
                                </div>
                                <div class="people-imgs task-assigess-list">
                                    @if (count($task->managers) > 0)
                                        @foreach ($task->managers as $manager)
                                            <img src=" {{ $manager->avatar }}" alt="">
                                        @endforeach
                                    @else
                                        <span>
                                            Chưa giao cho người theo dõi nào
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="message-report">
    <i class="fa-regular fa-bell me-2"></i>
</div>
<div class="message-status">
    <i class="fa-regular fa-bell me-2"></i>
</div>
<div class="message-confirm">
    <i class="fa-regular fa-bell me-2"></i>
</div>

<script>
    $(function() {
        $("#task-detail-modal").modal('show')

    });

    $(".btn-status").on("click", function() {
        var currentStatus = $(this).data("curstatus")
        var url = $(this).data("url")
        var statusSending = currentStatus == 1 ? 0 : 1
        var button = $(this);
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                status: statusSending,
            },
            success: function(response) {
                button.data("curstatus", response.status);
                button.html(response.status == 1 ? 'Bỏ tiến hành' : "Bắt đầu tiến hành")
                $(".task-status-text").html(response.status == 1 ? 'Đang tiến hành' :
                    "Chưa tiến hành");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    })


    $(".btn-status").on("click", function() {
        var url = $(this).data("url")
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                status: statusSending,
            },
            success: function(response) {
                button.data("curstatus", response.status);
                button.html(response.status == 1 ? 'Bỏ tiến hành' : "Bắt đầu tiến hành")
                $(".task-status-text").html(response.status == 1 ? 'Đang tiến hành' :
                    "Chưa tiến hành");
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    })
    $(".btn-report").on("click", function() {
        var url = $(this).data("url")
        var fromUser = $(this).data("userid");
        var ceoId = $(this).data("ceoid")
        var button = $(this);
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                fromUser: fromUser,
                ceoId: ceoId,
            },
            success: function(response) {
                if (response.success == true) {
                    $(".message-report").html(response.message);
                    $(".message-report").addClass("active-message-report");
                    setTimeout(function() {
                        $(".message-report").fadeOut();
                    }, 3000);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    })

    $(".update-task-status").on("change", function() {
        var url = $(this).data("url")
        var status = $(this).val()
        $.ajax({
            url: url,
            type: "POST",
            dataType: "json",
            data: {
                status: status,
            },
            success: function(response) {
                $(".message-status").html(response.message)
                $(".message-status").addClass("active-message-status")
                setTimeout(function() {
                    $(".message-status").fadeOut();
                }, 3000)
                $(".task-status-text").html(response.status_name)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            },
        });
    })

    $(".btn-confirm").on("click", function() {
        var url = $(this).data("url")
        var curStatus = $(this).data("status")
        var fromUser = $(this).data("userid")
        btnConfirm = $(this)
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: {
                status: curStatus
            },
            success: function(response) {
                btnConfirm.data("status", response.status)
                if (response.status != 3) {
                    btnConfirm.html('<i class="fa-solid fa-check me-1"></i> Xác nhận hoàn thành');
                    btnConfirm.removeClass('btn-danger').addClass('btn-primary');
                } else {
                    btnConfirm.html(
                        '<i class="fa-solid fa-exclamation me-1"></i> Đánh dấu chưa hoàn thành');
                    btnConfirm.removeClass('btn-primary').addClass('btn-danger');
                }
                const notifiSatus = response.status
                $.ajax({
                    type: "post",
                    url: "/ceo/confirm-notification/" + {{ $task->id }},
                    datatype: "json",
                    data: {
                        notifiSatus: notifiSatus,
                        fromUser: fromUser
                    },
                    success: function(response) {
                        console.log(response)
                    }
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            },
        })
    })
</script>
