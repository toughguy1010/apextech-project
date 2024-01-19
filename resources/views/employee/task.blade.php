@extends('layouts.app')
@section('content')
    <?php
    use App\Models\Task;
    ?>
    <section id="list_user_section">
        <div class="message">
        </div>
        <div class="list_user_header">
            <div class="row align-items-center">
                <h4 class="col-6">
                    Danh sách công việc
                </h4>
                
            </div>
        </div>
        <div class="list-task-status">
            <div class="list-status-header d-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="tw-w-5 tw-h-5 tw-text-neutral-500 tw-mr-1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                    </path>
                </svg>
                <span class="ms-2">
                    Tóm lược trạng thái công việc
                </span>
            </div>
            <div class="list-status-body">
                <?php
                $role = 'assignees';
                ?>
                <div class="task-status-item not-start">
                    <span>{{ Task::countTasksByStatus(Task::NOT_START, Auth::user()->id, $role) }}</span> Chưa bắt đầu
                </div>
                <div class="task-status-item inprogress">
                    <span>{{ Task::countTasksByStatus(Task::INPROGRESS, Auth::user()->id, $role) }}</span> Đang tiến hành
                </div>
                <div class="task-status-item testing">
                    <span>{{ Task::countTasksByStatus(Task::TESTING, Auth::user()->id, $role) }}</span> Đang kiểm tra
                </div>
                <div class="task-status-item complete">
                    <span>{{ Task::countTasksByStatus(Task::COMPLETE, Auth::user()->id, $role) }}</span> Hoàn thành
                </div>
                <div class="task-status-item complete">
                    <span>{{ Task::countTasksByStatus(Task::NOTCOMPLETE, Auth::user()->id, $role) }}</span> Chưa hoàn thành
                </div>
            </div>
        </div>
        <div class="list_user_body mt-5">
            <table class="table ">
                <thead>
                    <th style="border-top-left-radius: 10px;">
                        Tên công việc
                    </th>

                    <th>
                        Ngày bắt đầu
                    </th>
                    <th>
                        Ngày kết thúc
                    </th>
                    <th>
                        Trạng thái
                    </th>
                    <th>
                        Độ ưu tiên
                    </th>
                    <th>
                        Nhân viên được giao
                    </th>
                    <th>
                        Người theo dõi
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
                                {{ $task->end_date }}
                            </td>
                            <td>
                                <select name="update-task-status" class="update-task-status"
                                    data-url="{{ url('employee/update-task-status', $task->id) }}">
                                    @if ($task->status != Task::NOT_START && $task->status != Task::INPROGRESS)
                                        <option value="{{ $task->status }}"> {{ Task::getStatus($task->status) }}</option>
                                    @endif
                                    <option value="{{ Task::NOT_START }}"
                                        @if ($task->status == Task::NOT_START) selected @endif> Chưa bắt đầu</option>
                                    <option value="{{ Task::INPROGRESS }}"
                                        @if ($task->status == Task::INPROGRESS) selected @endif> Đang tiến hành</option>
                                </select>
                            </td>
                            <td>
                                {{ Task::getPriority($task->priority) }}
                            </td>
                            <th>
                                <div class="avt_user">

                                    @if (count($task->assignees) > 0)
                                        @foreach ($task->assignees as $assignee)
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

                            </th>
                            <th>
                                <div class="avt_user">
                                    @if (count($task->managers) > 0)
                                        @foreach ($task->managers as $manager)
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
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="message-status">
                <i class="fa-regular fa-bell me-2"></i>
            </div>
            <div id="modal-show">

            </div>
            <div class="pagination-wrap">
                {{-- {{ $tasks->appends(['search' => $search])->links('layouts.pagination') }} --}}

            </div>
        </div>
    </section>
    @vite(['resources/js/employee/task.js'])
    @vite(['resources/sass/employee.scss'])
@endsection
