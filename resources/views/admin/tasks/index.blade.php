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
                    {{-- <div class="export-excel ms-4">
                        <form action="{{url('admin/user/export') }}" class="me-0" method="get">
                            <button type="submit" class="btn btn-success " type="button" id="button-addon1"
                                style="height: 45px">
                                <i class="fa-regular fa-file-excel"></i>
                                Xuất file excel
                            </button>
                        </form>
                    </div> --}}
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
                        Mô tả công việc
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

                    </th>

                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr id="task-{{ $task->id }}">
                            <td>
                                {{ $task->name }}
                            </td>
                            <td>
                                {{ $task->description }}
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

                                    @if ( count($task->assignees) > 0)
                                        @foreach ($task->assignees as $assignee)
                                            <img src=" {{ $assignee->avatar }}" alt="">
                                        @endforeach
                                    @else
                                    <span>
                                        Chưa giao cho nhân viên nào
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
