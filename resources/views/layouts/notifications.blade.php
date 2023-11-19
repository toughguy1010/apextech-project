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
        top: 54px;
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
        border-bottom: 1px solid #cfcfcf ;
        cursor: pointer;
        line-height: 19px;
        padding-right: 44px !important; 
    }

    .dropdown-item:first-child {
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
    }

    .dropdown-item:first-child:hover {
        border-top-left-radius: 10px !important;
        border-top-right-radius: 10px !important;
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
</style>
<span class="triangle"></span>
<span class="heading">Notifications</span>
@foreach ($notifications as $notification)
    <div class="dropdown-item unread" href="#">
        @if ($notification->notifications->type == 1)
            <?php
            $from_user = User::getUserNameByID($notification->notifications->from_user);
            $task_name = Task::getTaskNameByID($notification->notifications->task_id);
            ?>
            <strong>{{ $from_user }}</strong> đã báo cáo công việc {{ $task_name }}
        @endif
    </div>
@endforeach
