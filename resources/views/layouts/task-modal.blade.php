<?php
use App\Models\Task;
use App\Models\TaskComments;
use App\Models\Position;
use App\Models\User;

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
                    <h5 class="modal-title" id="staticBackdropLabel">{{ $task->name }}
                        <p class="task-description-content">
                            {{ $task->description }}
                        </p>
                    </h5>
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
                    <div class="col-8 main-task-col pb-3">

                        <div class="task-btn-group mt-3">
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
                                @if ($task->task_creater == Auth::user()->id)
                                    <div class="btn {{ $task->status != 3 ? 'btn-primary' : 'btn-danger' }} btn-confirm  mt-3 "
                                        data-url="{{ url('ceo/confirm-task-status', $task->id) }} "
                                        data-userID="{{ Auth::user()->id }}" data-status="{{ $task->status }}">
                                        {!! $task->status != 3
                                            ? '<i class="fa-solid fa-check me-1"></i> Xác nhận hoàn thành'
                                            : '<i class="fa-solid fa-exclamation me-1"></i> Đánh dấu chưa hoàn thành' !!}
                                    </div>
                                @else
                                    <select name="update-task-status" class="update-task-status "
                                        data-url="{{ url('leader/update-task-status', $task->id) }}">
                                        @if ($task->status != Task::NOT_START && $task->status != Task::INPROGRESS && $task->status != Task::TESTING)
                                            <option value="{{ $task->status }}"> {{ Task::getStatus($task->status) }}
                                            </option>
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
                                @endif
                            @elseif(Position::getPositionCodeByUser(Auth::user()) == 'ceo')
                                <div class="btn {{ $task->status != 3 ? 'btn-primary' : 'btn-danger' }} btn-confirm  mt-3 "
                                    data-url="{{ url('ceo/confirm-task-status', $task->id) }} "
                                    data-userID="{{ Auth::user()->id }}" data-status="{{ $task->status }}">
                                    {!! $task->status != 3
                                        ? '<i class="fa-solid fa-check me-1"></i> Xác nhận hoàn thành'
                                        : '<i class="fa-solid fa-exclamation me-1"></i> Đánh dấu chưa hoàn thành' !!}
                                </div>
                            @elseif(Position::getPositionCodeByUser(Auth::user()) == 'admin')
                                <div class="btn {{ $task->status != 3 ? 'btn-primary' : 'btn-danger' }} btn-confirm  mt-3 "
                                    data-url="{{ url('ceo/confirm-task-status', $task->id) }} "
                                    data-userID="{{ Auth::user()->id }}" data-status="{{ $task->status }}">
                                    {!! $task->status != 3
                                        ? '<i class="fa-solid fa-check me-1"></i> Xác nhận hoàn thành'
                                        : '<i class="fa-solid fa-exclamation me-1"></i> Đánh dấu chưa hoàn thành' !!}
                                </div>
                            @endif


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
                        <div class="task-content-wrap task-proccess-wrap">
                            <div class="task-proccess-title">
                                <span>Tiến trình công việc</span>

                            </div>
                            <div class="task-proccess-list">
                                <?php
                                $total = 0;
                                $complete_tasks = 0;
                                
                                ?>
                                @foreach ($task->processes as $index => $processes)
                                    <div class="process-item">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input process_status" type="checkbox"
                                                value="" id="flexCheckDefault" name=""
                                                {{ $processes->process_status == 1 ? 'checked' : '' }}
                                                data-url ="{{ url('change-proccess-status', $processes->id) }}"
                                                data-user="{{ Auth::user()->id }}">
                                            <div class="process-detail ms-2">
                                                <?php echo $processes->process_details; ?>
                                            </div>
                                        </div>
                                        <div class="user-complete">
                                            <?php
                                            if ($processes->process_status == 1) {
                                                $user_complete = User::getUserNameByID($processes->user_complete);
                                                echo 'Đã được hoàn thành bởi  <strong>' . $user_complete . '</strong>';
                                            } else {
                                                echo 'Chưa được hoàn thành';
                                            }
                                            ?>
                                        </div>

                                    </div>
                                    <?php
                                    if ($processes->process_status == 1) {
                                        $complete_tasks++;
                                    }
                                    $total++;
                                    ?>
                                @endforeach
                            </div>
                            <div class="task-total">
                                <span class="change-process-status">{{ $complete_tasks }}</span> /
                                {{ $total }}
                                <i class="fa-solid fa-bars-progress ms-1 text-primary"></i>
                            </div>
                        </div>

                        <div class="task-content-wrap">
                            <div class="task-content-title mb-2">
                                <span>Bình luận</span>
                                <i class="fa-solid fa-highlighter text-primary ms-1"></i>
                            </div>
                            <textarea name="comment" id="comment" class="form-control tinymce" cols="30" rows="5">
                            </textarea>
                            <div class="btn btn-primary mt-3 add-comment" style="margin-left: 378px"
                                data-url="{{ url('/task-comment/add-comment') }}" data-task="{{ $task->id }}"
                                data-user="{{ Auth::user()->id }}">
                                Thêm bình luận
                            </div>
                            <?php
                            
                            $task_comments = TaskComments::getCommentsByTaskId($task->id);
                            
                            ?>
                            <div
                                class="list-task-comment <?= $task_comments != null ? 'list-task-comment-active' : '' ?>">
                                @if ($task_comments != null)
                                    <?php
                                foreach ($task_comments as $comment) {
                                
                                    if($comment->user_id != null)
                                    {
                                        $user_comment = User::findOrFail($comment->user_id);
                                        ?>
                                    <div class="task-comment-item">
                                        <img src="{{ $user_comment->avatar }}" alt="" class="avt">
                                        <div class="task-comment-info">
                                            <div class="task-comment-username">
                                                {{ $user_comment->name }}
                                            </div>
                                            <div class="task-comment-content">
                                                {{ $comment->comment }}
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                }
                                ?>
                                @endif
                            </div>

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
                                            {{-- <img src=" {{ $assignee->avatar }}" alt=""> --}}
                                            <div class="tooltip-wrap">
                                                <img src=" {{ $assignee->avatar }}" alt=""
                                                    data-info=" {{ $assignee->name }}" class="show_avt_name">
                                                <div class="avt_name"></div>
                                            </div>
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
                                            {{-- <img src=" {{ $manager->avatar }}" alt=""> --}}
                                            <div class="tooltip-wrap">
                                                <img src=" {{ $manager->avatar }}" alt=""
                                                    data-info=" {{ $manager->name }}" class="show_avt_name">
                                                <div class="avt_name"></div>
                                            </div>
                                        @endforeach
                                    @else
                                        <span>
                                            Chưa giao cho người theo dõi nào
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="manager-wrap mt-4">
                            <div class="people-label d-flex">
                                <i class="fa-solid fa-users"></i>
                                <p class="mb-1">Người tạo công việc: </p>
                            </div>
                            <div class="people-imgs task-assigess-list">
                                @if ($task->task_creater)
                                    @php
                                        $task_creater = User::findOrFail($task->task_creater);
                                    @endphp
                                    <div class="tooltip-wrap">
                                        <img src="{{ $task_creater->avatar }} " alt=""
                                            data-info=" {{ $task_creater->name }}" class="show_avt_name">
                                        <div class="avt_name"></div>
                                    </div>
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
<div class="message-report">
    <i class="fa-regular fa-bell me-2"></i>
</div>
<div class="message-status">
    <i class="fa-regular fa-bell me-2"></i>
</div>
<div class="message-confirm">
    <i class="fa-regular fa-bell me-2"></i>
</div>
<div class="message-progess">
    <i class="fa-regular fa-bell me-2"></i>
</div>
<script>
    $(function() {
        $("#task-detail-modal").modal('show')

    });

    $(".show_avt_name").hover(
        function() {
            // Hover-in event
            var info = $(this).data("info");
            $(this).next(".avt_name").stop(true, true).text(info).fadeIn(200);
        },
        function() {
            // Hover-out event
            $(this).next(".avt_name").stop(true, true).fadeOut(200);
        }
    );

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
                    $(".message-report").removeClass("false-message-report")
                    $(".message-report").addClass("active-message-report");
                    setTimeout(function() {
                        $(".message-report").removeClass("active-message-report")
                    }, 2000);
                } else {
                    $(".message-report").html(response.message);
                    $(".message-report").removeClass("active-message-report")
                    $(".message-report").addClass("false-message-report");
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
                }, 2000)
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
                    $(".message-report").html(response.message);
                    $(".message-report").addClass("active-message-report");
                    setTimeout(function() {
                        $(".message-report").fadeOut();
                    }, 3000);

                    $(".task-status-text").html('Hoàn thành')
                } else {
                    btnConfirm.html(
                        '<i class="fa-solid fa-exclamation me-1"></i> Đánh dấu chưa hoàn thành');
                    btnConfirm.removeClass('btn-primary').addClass('btn-danger');
                    $(".message-report").html(response.message);
                    $(".message-report").addClass("active-message-report");
                    setTimeout(function() {
                        $(".message-report").fadeOut();
                    }, 3000);
                    $(".task-status-text").html('Chưa hoàn thành')

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
    var changeProcessStatusHtml = $('.change-process-status');

    $(".process_status").on("change", function() {
        var url = $(this).data("url");
        var userComplete = $(this).data("user")
        var status;
        var processItem = $(this).closest('.process-item');
        var userCompleteHtml = processItem.find('.user-complete');
        if ($(this).is(':checked')) {
            status = 1
        } else {
            status = 0
        }
        $.ajax({
            url: url,
            datatype: "json",
            type: "post",
            data: {
                userComplete: userComplete,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    $(".message-progess").html(response.message)
                    $(".message-progess").addClass("active-message-progess")
                    setTimeout(function() {
                        $(".message-progess").removeClass("active-message-progess")
                    }, 2000)
                    if (response.status == 1) {
                        userCompleteHtml.html(" Đã được hoàn thành bởi <strong> " + response
                            .user_name + "</strong> ")
                        updateTaskCount(1);
                    } else {
                        userCompleteHtml.html(" Chưa được hoàn thành ")
                        updateTaskCount(-1);
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            },

        })
    })

    function updateTaskCount(change) {
        var currentCount = parseInt(changeProcessStatusHtml.text());
        var newCount = currentCount + change;
        changeProcessStatusHtml.text(newCount);
    }
    $(".add-comment").on("click", function() {
        var url = $(this).data("url")
        var comment = $("#comment").val();
        var userId = $(this).data("user")
        var taskId = $(this).data("task")
        var commentContainer = $(".list-task-comment");
        if (commentContainer.length === 0) {
            commentContainer = $("<div class='list-task-comment'></div>");
            // Append the container to wherever it should be in your HTML
            // For example: $("body").append(commentContainer);
        }
        $.ajax({
            url: url,
            dataType: "json",
            type: "post",
            data: {
                userId: userId,
                comment: comment,
                taskId: taskId,
            },
            success: function(response) {
                if (response.success) {
                    var newCommentItem = `
                        <div class="task-comment-item">
                            <img src="${response.user_avatar}" alt="" class="avt">
                            <div class="task-comment-info">
                                <div class="task-comment-username">
                                    ${response.user_name}
                                </div>
                                <div class="task-comment-content">
                                    ${response.comment}
                                </div>
                            </div>
                        </div>
                    `;
                    commentContainer.append(newCommentItem);
                    $("#comment").val("");
                    commentContainer.addClass('list-task-comment-active')
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown)
            },
        })
    })

    $(".task-comment-content").each(function() {
        var commentContent = $(this).html();

        if (commentContent.includes('\n')) {
            var formattedContent = commentContent.replace(/(\r\n|\r|\n)/g, '<br>');
            $(this).html(formattedContent);
        }
    });
</script>
