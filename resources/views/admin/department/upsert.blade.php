@extends('layouts.app')
@section('content')
    <section id="form_user_upsert" class="container-fluid">
        <div class="">
            <h4>
                {{ $id ? 'Cập nhật' : 'Thêm mới' }} phòng ban
            </h4>
            <form action="{{ url('admin/department/upsert', $id) }}" method="post" enctype="multipart/form-data"
                class="">
                @csrf
                @include('admin.noti')


                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Tên phòng ban</label>
                        <input type="text" name="name" class="form-control" id="name"
                            value="{{ $id ? $department->name : '' }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-6">
                        <label for="email" class="form-label ">Mô tả phòng ban</label>
                        <input type="text" name="description" class="form-control" id="email"
                            value="{{ $id ? $department->description : '' }}">
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <?php
                        ?>
                        <label for="email" class="form-label ">Trưởng phòng</label>
                        <select class="form-select" name="leader_id" aria-label="Default select example">
                            <option value="">--- Chọn trưởng phòng ---</option>
                            @foreach ($leaders as $item)
                                <option value="<?= $item->id ?>"
                                    {{ $id && $department->leader_id == $item->id ? 'selected' : '' }}>
                                    <?= $item->name ?>
                                </option>
                            @endforeach
                        </select>
                        @error('leader_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-6">
                        <?php
                        ?>
                        <label for="email" class="form-label ">Phân quyền</label>
                        <select class="form-select" name="role" aria-label="Default select example">
                            <option value="">--- Chọn quyền ---</option>
                            @foreach ($roles as $role)
                                <option value="<?= $role->id ?>"
                                    {{ $id && $department->role == $role->id ? 'selected' : '' }}>
                                    <?= $role->name ?>
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <div type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Phân công nhân viên
                        </div>

                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog" style="    max-width: 800px !important;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel" style="    flex: 0 0 50%;">Danh sách
                                            nhân viên</h5>
                                        <div action="" class="d-flex ms-0 form-search-emp">
                                            <input class="form-control search-emp-input " type="text"
                                                placeholder="Nhập tên phòng ban" name="search"
                                                style="border-top-right-radius:0;border-bottom-right-radius:0">
                                            <div type="submit" class="btn btn-primary search-emp-btn" type="button"
                                                id="button-addon1"
                                                style="height: 45px; padding: 10px 15px;border-top-left-radius:0;border-bottom-left-radius:0"
                                                data-url="{{ url('admin/department/search') }}"
                                                data-departmentID="{{ $id }}">
                                                <i class="fa-solid fa-magnifying-glass"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table" style="box-shadow: none">
                                            <thead>
                                                <th>Chọn</th>
                                                <th>Tên nhân viên</th>
                                                <th>Tên tài khoản</th>
                                                <th>Phòng ban</th>
                                            </thead>
                                            <tbody id="employee-list">
                                                @foreach ($employees as $employee)
                                                    <tr class="">
                                                        <td>
                                                            <input class="form-check-input" type="checkbox"
                                                                value="{{ $employee->id }}" name="employees_id[]"
                                                                id="flexCheckChecked"
                                                                {{ $id && $employee->department_id == $id ? 'checked' : ' ' }}
                                                                data-department = "{{ $employee->department_id == null || $employee->department_id == $id ? 1 : 0 }}">
                                                        </td>
                                                        <td>
                                                            {{ $employee->name }}
                                                        </td>
                                                        <td>
                                                            {{ $employee->username }}
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

                        @error('leader_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="right-btn">
                    <button type="submit" class="btn btn-primary save-update">{{ $id ? 'Cập nhật' : 'Thêm' }} phòng
                        ban</button>
                    <a href="{{ url('admin/department') }}" class="btn ms-3 btn-danger">Quay lại</a>
                </div>
               
            </form>
        </div>
        @vite(['resources/js/admin/department.js'])
    </section>
@endsection
