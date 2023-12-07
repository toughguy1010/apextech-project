@extends('layouts.app')
@section('content')
    <?php
    use App\Models\Position;
    ?>
    <section id="list_user_section">
        <div class="message">
        </div>
        <div class="list_user_header">
            <div class="row align-items-center">
                <h4 class="col-6">
                    {{ $department->name }}
                </h4>
                <div class="col-6 d-flex justify-content-end">
                    <div class="input-group " style="width:fit-content">
                        <form action="" class="d-flex ms-0">
                            <input class="form-control search-input " type="text" placeholder="Nhập tên tài khoản/ Email"
                                name="search">
                            <button type="submit" class="btn btn-primary search-btn" type="button" id="button-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                    {{-- <div class="export-excel ms-4">
                        <form action="{{url('leader/export',$department->id) }}" class="me-0" method="get">
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
        <span class="text-gray" style="color: $purple;">
            Trưởng phòng : {{ $leader->name }}
        </span>
        @if (count($employees) > 1)
            <div class="list_user_body mt-5">
                <table class="table ">
                    <thead>
                        <th style="border-top-left-radius: 10px;">
                            Tên người dùng
                        </th>
                        <th>
                            Tài khoản
                        </th>
                        <th>
                            Email - Số điện thoại
                        </th>

                        <th>
                            Ngày bắt đầu
                        </th>
                        <th>
                            Chức vụ
                        </th>
                        <th>
                            Trạng thái
                        </th>
                        <th>

                        </th>

                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr id="user-{{ $employee->id }}">
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->username }}</td>
                                <td class="have-wrap">
                                    {{ $employee->email ?: 'Không có dữ liệu' }}
                                    <br>
                                    {{ $employee->phone_number ?: 'Không có dữ liệu' }}
                                </td>
                                <td>{{ $employee->on_board }}</td>
                                <td>
                                    <?php
                                    $position = Position::getPositionNameByUser($employee);
                                    echo $position;
                                    ?>
                                </td>
                                <td>
                                    <div class="satus-active">
                                        {{ $employee->status == 1 ? 'Đang làm việc' : 'Đã nghỉ việc' }}
                                    </div>
                                </td>
                                <td class="">

                                    <a href="#" class="btn-delete"
                                        data-url="{{ url('leader/remove-employee', $employee->id) }}">
                                        <i class="fa-solid fa-user-minus"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-wrap">
                    {{-- {{ $users->links('layouts.pagination') }} --}}
                    {{ $employees->appends(['search' => $search])->links('layouts.pagination') }}

                </div>
            </div>
        @else
        <div class="mt-4 text-center ceo-message">
            Không có nhân viên
        </div>
        @endif

    </section>
    @vite(['resources/js/leader/leader.js'])
@endsection
