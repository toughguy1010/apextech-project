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
                <div class="col-6 d-flex justify-content-end">
                    <div class="input-group " style="width:fit-content">
                        <form action="" class="d-flex ms-0">
                            <input class="form-control search-input " type="text" placeholder="Nhập tên công việc"
                                name="search">
                            <button type="submit" class="btn btn-primary search-btn" type="button" id="button-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>

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
                        Nguời theo dõi
                    </th>
                    <th>

                    </th>

                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr id="task-{{ $task->id }}">
                            <td>
                                {{ $task->name }}
                            </td>

                            <td>
                                {{ $task->start_date }}
                            </td>
                            <td>
                                {{ $task->end_date }}
                            </td>
                            <td>
                                {{ Task::getStatus($task->status) }}
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
                            </th>
                            <td class="">
                                <a href="{{ url('admin/task/upsert', $task->id) }}" class="me-4">
                                    <i class="fa-solid fa-user-pen"></i>
                                </a>
                                <a href="#" class="btn-delete" data-url="{{ url('admin/task/destroy', $task->id) }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrap">
                {{ $tasks->appends(['search' => $search])->links('layouts.pagination') }}

            </div>
        </div>
    </section>
    @vite(['resources/js/admin/task.js'])
@endsection
