@extends('layouts.app')

@section('content')
    <?php
    use App\Models\Task;
    use App\Models\Position;
    use App\Models\Department;
    $role = 'assignees';
    $task_not_start = Task::countTasksByStatus(Task::NOT_START, Auth::user()->id, $role);
    $task_in_progress = Task::countTasksByStatus(Task::INPROGRESS, Auth::user()->id, $role);
    $task_complete = Task::countTasksByStatus(Task::COMPLETE, Auth::user()->id, $role);
    $show_task_total = count($tasks_total);
    $show_task_less = count($tasks);
    ?>
    <div class="container-fluid">
        <div class="row overview-task">
            <div class="col-3 overview-task-col">
                <div class="task-inprocess-wrap">
                    <div class="task-inprocess-header">
                        <i class="fa-solid fa-bars-staggered me-2"></i>
                        Các công việc đã hoàn thành
                    </div>
                    <div class="task-inprocess-total ">
                        <span class="done_task">{{ $task_complete }}</span>/ <span class="show_task_total">
                            {{ $show_task_total }} </span>
                    </div>
                </div>
                <div class="progress mt-3">
                    <div class="progress-bar" role="progressbar"
                        style="width: {{ $show_task_total != 0 ? ($task_complete / $show_task_total) * 100 : 0 }}%" aria-valuenow="25" aria-valuemin="0"
                        aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="overview-task-body row">
            <div class="list_user_body mt-5  col-8">
                <div class="list-overview-task d-flex justify-content-between align-items-baseline mt-3 mb-4">
                    <div class="task-user-total">
                        Tổng công việc : {{ $show_task_total }}

                    </div>
                    @if ($show_task_less < $show_task_total)
                        <div class="show-more">
                            <a href="{{ url('employee/task', Auth::user()->id) }}" style="color: black">Xem tất cả</a>
                            <span>Hiển thị {{ $show_task_less }}/{{ $show_task_total }} các công việc</span>
                        </div>
                    @endif

                </div>

                <div class="table-hidden">
                    <table class="table ">
                        <thead>
                            <th>
                                Tên công việc
                            </th>

                            <th>
                                Ngày bắt đầu
                            </th>

                            <th>
                                Trạng thái
                            </th>
                            <th>
                                Độ ưu tiên
                            </th>
                        </thead>
                        <tbody>
                            @foreach ($tasks as $task)
                                <tr id="task-{{ $task->id }}">
                                    <td>
                                        <div class="open-task-model" id="task-{{ $task->id }}"
                                            data-url="{{ url('employee/show-task-detail', $task->id) }}">
                                            {{ $task->name }}

                                        </div>
                                    </td>

                                    <td>
                                        {{ $task->start_date }}
                                    </td>

                                    <td>
                                        {{ Task::getStatus($task->status) }}
                                    </td>
                                    <td>
                                        {{ Task::getPriority($task->priority) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="message-status">
                    <i class="fa-regular fa-bell me-2"></i>
                </div>
                <div id="modal-show">

                </div>
            </div>
            <div class="overview-information col-3 mt-5" style="width:30%">
                <div class="overview-information-header">
                    <div class="overview-avatar">
                        <img src="{{ $user->avatar }}" alt="">
                    </div>
                    <div class="overview-name">
                        <a href="{{ route('personalInfo', ['id' => Auth::user()->id]) }}">
                            {{ $user->name }}
                        </a>
                    </div>
                </div>
                <div class="overview_information-body">
                    <div class="overview_information-wrap">
                        <div class="overview_information-email overview_information-item">
                            <i class="fa-regular fa-envelope"></i>
                            <a href="mailto:{{ $user->email }}"> {{ $user->email }}</a>
                        </div>
                        <div class="overview_information-phone overview_information-item">
                            <i class="fa-solid fa-phone"></i>
                            <span> {{ $user->phone_number }}</span>
                        </div>
                        <div class="overview_information-email overview_information-item">
                            <i class="fa-solid fa-venus-mars"></i>
                            <span>
                                @if ($user->gender == 1)
                                    Nam
                                @else
                                    Nữ
                                @endif
                            </span>
                        </div>
                        <div class="overview_information-block mt-3">
                            <span>Vị trí:</span>
                            <p class="mb-2">
                                {{ Position::getPositionNameByUser($user) }}
                            </p>
                        </div>
                        @if ($department)
                            <div class="overview_information-block">
                                <span>Phòng ban:</span>
                                <p>
                                    <a href="{{ url('employee/department', $user->id) }}" class="text-dark">
                                        {{ $department->name }}
                                    </a>
                                </p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
