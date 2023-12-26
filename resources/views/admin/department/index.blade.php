@extends('layouts.app')
@section('content')
    <?php
    use App\Models\User;
    
    ?>
    <section id="list_user_section">
        <div class="message">
        </div>
        <div class="list_user_header">
            <div class="row align-items-center">
                <h4 class="col-6">
                    Danh sách phòng ban
                </h4>
                <div class="col-6 d-flex justify-content-end">
                    <div class="input-group " style="width:fit-content">
                        <form action="" class="d-flex ms-0">
                            <input class="form-control search-input " type="text" placeholder="Nhập tên phòng ban"
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
                        Tên phòng ban
                    </th>
                    <th>
                        Tên trưởng phòng
                    </th>
                    <th>
                        Mô tả
                    </th>

                    <th>
                        Số lượng
                    </th>
                    <th>

                    </th>

                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr id="department-{{ $department->id }}">
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->getLeaderName($department->leader_id) }}</td>
                            <td>{{ $department->description }}</td>
                            <td>{{ $department->countUsers() }}</td>
                            <td class="">
                                @php
                                    $employees = User::getUserEmployee();
                                @endphp
                                @if (Auth::user()->role == 2)
                                    <div type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal-{{ $department->id }}">
                                        Phân công nhân viên
                                    </div>
                                    <div class="modal fade" id="exampleModal-{{ $department->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" style="    max-width: 800px !important;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"
                                                        style="    flex: 0 0 50%;">Danh sách
                                                        nhân viên</h5>
                                                    <div action="" class="d-flex ms-0 form-search-emp">
                                                        <input class="form-control search-emp-input " type="text"
                                                            placeholder="Nhập tên phòng ban" name="search"
                                                            style="border-top-right-radius:0;border-bottom-right-radius:0">
                                                        <div type="submit" class="btn btn-primary search-emp-btn"
                                                            type="button" id="button-addon1"
                                                            style="height: 45px; padding: 10px 15px;border-top-left-radius:0;border-bottom-left-radius:0"
                                                            data-url="{{ url('admin/department/search') }}"
                                                            data-departmentID="{{ $department->id }}">
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
                                                                        <input
                                                                            class="form-check-input set-department-employee"
                                                                            type="checkbox" value="{{ $employee->id }}"
                                                                            name="employees_id[]" id="flexCheckChecked"
                                                                            {{ $employee->department_id == $department->id ? 'checked' : ' ' }}
                                                                            data-department = "{{ $department->id  }}"
                                                                            data-url = "{{ url('employee/department-manager/update-employee', $employee->id) }}">
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
                                @else
                                    @if (Auth::user()->position_id == 4)
                                        <a href="{{ url('ceo/department/upsert', $department->id) }}" class="me-4">
                                            <i class="fa-solid fa-user-pen"></i>
                                        </a>
                                    @else
                                        <a href="{{ url('admin/department/upsert', $department->id) }}" class="me-4">
                                            <i class="fa-solid fa-user-pen"></i>
                                        </a>
                                    @endif

                                    <a href="#" class="btn-delete"
                                        data-url="{{ url('admin/department/destroy', $department->id) }}">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                @endif



                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="message-report">
                <i class="fa-regular fa-bell me-2"></i>
            </div>

            <div class="pagination-wrap">
                {{ $departments->appends(['search' => $search])->links('layouts.pagination') }}

            </div>
        </div>
    </section>
    @vite(['resources/js/admin/department.js'])
@endsection
