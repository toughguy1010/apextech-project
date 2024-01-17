@extends('layouts.app')
@section('content')
    <?php
    use App\Models\Position;
    
    ?>
    <section id="form_user_upsert" class="container-fluid">
        <div class="">
            <h4>
                {{ $id ? 'Cập nhật' : 'Tạo' }} công việc
            </h4>
            <form action="{{ url('admin/task/upsert', $id) }}" method="post" enctype="multipart/form-data" class="">
                @csrf
                @include('admin.noti')


                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Tiêu đề công việc</label>
                        <input type="text" name="name" class="form-control" id="name"
                            value="{{ $id ? $task->name : '' }}">

                    </div>
                    <div class="mb-3 col-6">
                        <label for="" class="form-label ">Mô tả công việc</label>
                        <input type="text" name="description" class="form-control" id=""
                            value="{{ $id ? $task->description : '' }}">
                    </div>
                </div>



                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="" class="form-label ">Thời gian bắt đầu</label>
                        <input type="date" name="start_date" class="form-control" id=""
                            value="{{ $id ? $task->start_date : '' }}">
                    </div>

                    <div class="mb-3 col-6">
                        <label for="" class="form-label ">Thời gian kết thúc</label>
                        <input type="date" name="end_date" class="form-control" id=""
                            value="{{ $id ? $task->end_date : '' }}">
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <div type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeModal">
                            Nhân viên được bàn giao
                        </div>

                        <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" style="    max-width: 800px !important;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel" style="flex: 0 0 50%;">Danh sách
                                            nhân viên</h5>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table" style="box-shadow: none">
                                            <thead>
                                                <th>Chọn</th>
                                                <th>Tên nhân viên</th>
                                                <th>Tên tài khoản</th>
                                                <th>Vị trí</th>
                                                <th>Phòng ban</th>
                                            </thead>
                                            <tbody id="employee-list">
                                                @foreach ($employees as $employee)
                                                    <tr class="">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $employee->id }}" name="employees_id[]"
                                                                id="flexCheckChecked"
                                                                @if ($id && $task->assignees->contains('id', $employee->id)) checked @endif>
                                                        </td>
                                                        <td>
                                                            {{ $employee->name }}
                                                        </td>
                                                        <td>
                                                            {{ $employee->username }}
                                                        </td>
                                                        <td>
                                                            {{ Position::getPositionNameByUser($employee) }}
                                                        </td>
                                                        <td>
                                                            {{ $employee->getDepartmentName() }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        ?>
                    </div>
                    @if ($task_managers !== null)
                        <div class="mb-3 col-6">
                            <div type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#taskManagementModal">
                                Người theo dõi
                            </div>

                            <div class="modal fade" id="taskManagementModal" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" style="    max-width: 800px !important;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel" style="flex: 0 0 50%;">Danh sách
                                                người dùng</h5>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table" style="box-shadow: none">
                                                <thead>
                                                    <th>Chọn</th>
                                                    <th>Tên người dùng</th>
                                                    <th>Tên tài khoản</th>
                                                    <th>Vị trí</th>
                                                    <th>Phòng ban</th>
                                                </thead>
                                                <tbody id="task-managers-list">
                                                    @foreach ($task_managers as $task_manager)
                                                        <tr class="">
                                                            <td>
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="{{ $task_manager->id }}" name="task_manager[]"
                                                                    @if ($id && $task->managers->contains('id', $task_manager->id)) checked @endif
                                                                    id="flexCheckChecked">
                                                            </td>
                                                            <td>
                                                                {{ $task_manager->name }}
                                                            </td>
                                                            <td>
                                                                {{ $task_manager->username }}
                                                            </td>
                                                            <td>
                                                                {{ Position::getPositionNameByUser($task_manager) }}
                                                            </td>
                                                            <td>
                                                                {{ $task_manager->getDepartmentName() }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            ?>
                        </div>
                    @endif

                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <div for="name" class="form-label fw-bold">Nội dung công việc</div>
                        <textarea name="content" id="task_content" rows="5" style="width: 100%">
                            {{ $id ? $task->content : '' }}
                        </textarea>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="" class="form-label required">Độ ưu tiên công việc</label>
                        <select class="form-select" name="priority" aria-label="Default select example">
                            <option value="">--- Độ ưu tiên ---</option>
                            <option value="0" {{ $id && $task->priority == 0 ? 'selected' : '' }}>Thấp</option>
                            <option value="1"{{ $id && $task->priority == 1 ? 'selected' : '' }}>Bình thường</option>
                            <option value="2" {{ $id && $task->priority == 2 ? 'selected' : '' }}>Cao</option>
                            <option value="3" {{ $id && $task->priority == 3 ? 'selected' : '' }}>Cấp bách</option>
                        </select>
                        @error('position_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <div for="name" class="form-label fw-bold">Tiến trình công việc</div>
                        @if ($id)
                            @foreach ($task->processes as $process)
                                <div class="task-process-item">
                                    <input type="text" name="proccess_detail[]" class="form-control"
                                        value="{{ $process->process_details }}">
                                    <div class="process-action">
                                        <div class="plus-process">
                                            <i class="fa-solid fa-plus"></i>
                                        </div>
                                        <div class="minus-process">
                                            <i class="fa-solid fa-minus"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="task-process-item">
                                <input type="text" name="proccess_detail[]" class="form-control" value="">
                                <div class="process-action">
                                    <div class="plus-process">
                                        <i class="fa-solid fa-plus"></i>
                                    </div>
                                    <div class="minus-process">
                                        <i class="fa-solid fa-minus"></i>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="right-btn">
                    <button type="submit" class="btn btn-primary">{{ $id ? 'Cập nhật' : 'Tạo' }} công việc</button>
                    <a href="{{ url('admin/task') }}" class="btn ms-3 btn-danger">Quay lại</a>
                </div>

            </form>
        </div>
        @vite(['resources/js/app.js'])
    </section>
@endsection
