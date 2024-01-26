<?php
use App\Models\User;
use App\Models\Task;

?>
<style>
    .navbar-expand-md .navbar-nav .dropdown-menu {
        width: 280px;
        background-color: #f5f5f5 !important;
        padding: 0;
        left: -125px;
        top: 60px;
    }

    .dropdown-item.active,
    .dropdown-item:active {
        color: #000;
        text-decoration: none;
        background-color: unset;
    }

    .dropdown-item {
        white-space: unset;
        padding: 20px 15px;
        border-bottom: 1px solid #cfcfcf;
        cursor: pointer;
        line-height: 19px;
        padding-right: 44px !important;
    }

    /* .dropdown-item:first-child {
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
    }

    .dropdown-item:first-child:hover {
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
    } */
    .dropdown-noti-wrap {
        height: 440px;
        overflow-y: auto;
    }

    .dropdown-item:last-child {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        border-bottom: 0px solid #d5d5d5;

    }

    .dropdown-item:hover,
    .dropdown-item:focus {
        background-color: unset !important;
    }

    .triangle {
        position: absolute;
        top: -8px;
        left: 134px;
        height: 15px;
        width: 15px;
        border-radius: 6px 0px 0px 0px;
        transform: rotate(45deg);
        background: #ffffff;
    }

    .unread {
        color: #000;
        font-weight: 700;
        position: relative;
        background-color: #b1b1b1;
    }

    .unread::after {
        position: absolute;
        content: "";
        width: 12px;
        height: 12px;
        background-color: #00eb057a;
        top: 24px;
        right: 8px;
        border-radius: 50%;
    }

    .heading {
        font-size: 18px;
        font-weight: 600;
        color: #626262;
        background-color: #ffff;
        display: block;
        text-align: center;
        padding: 7px 0px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .noti-datetime {
        font-size: 11px;
        font-style: italic;
        color: #7a7a7a;
    }
</style>
<span class="triangle"></span>
<span class="heading">Thông báo</span>
<div class="dropdown-noti-wrap">
    @foreach ($notifications as $notification)
        <?php
        $is_read = $notification->is_readed == 1 ? '' : 'unread';
        $task_id = $notification->notifications->task_id;
        ?>
        <div class="dropdown-item {{ $is_read }} notification-item"
            data-url="{{ url('/leader/show-task-detail', $task_id) }}" data-id="{{ $notification->id }}">
            @php
                $from_user = User::getUserNameByID($notification->notifications->from_user);
                $task_name = Task::getTaskNameByID($notification->notifications->task_id);
                $originalDateTimeString = $notification->notifications->datetime;
                $originalDateTime = new DateTime($originalDateTimeString);
                $noti_datetime = $originalDateTime->format('H:i d-m-Y');
            @endphp

            @if ($notification->notifications->type == 1)
                <strong>{{ $from_user }}</strong> đã báo cáo công việc {{ $task_name }}
            @elseif($notification->notifications->type == 2)
                @php
                    $task = Task::findOrFail($notification->notifications->task_id);
                    $task_status = Task::getStatus($task->status);
                @endphp
                <strong>{{ $from_user }}</strong> đã xác nhận công việc {{ $task_name }}
                <span style="text-transform: lowercase">{{ $task_status }}</span>
            @endif

            <div class="noti-datetime">
                {{ $noti_datetime }}
            </div>
        </div>
    @endforeach
</div>



<script>
    var hostName = window.location.hostname;
    var portNumber = window.location.port;

    var hostWithPort = hostName + (portNumber ? ":" + portNumber : "");
    $(".notification-item").on("click", function(e) {
        var url = $(this).data("url");
        var notificationId = $(this).data("id")
        var notificationItem = $(this)
        $.ajax({
            type: "post",
            dataType: "html",
            url: url,
            success: function(response) {
                $("#modal-show").html(response)
                var isReadUrl = "/is-read-notification/" + notificationId;
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: isReadUrl,
                    success: function(response) {
                        console.log(response)
                        notificationItem.removeClass('unread')
                        $("#notification_item").removeClass('show')
                        var unreadNotificationCount = parseInt($("#unread_notification")
                            .text().trim());
                        if (unreadNotificationCount > 0) {
                            $("#unread_notification").text(unreadNotificationCount - 1);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("Error:", textStatus, errorThrown);
                    },
                })
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("Error:", textStatus, errorThrown);
            },
        })
    })
</script>
<script src="{{ asset('js/app.js') }}"></script>
