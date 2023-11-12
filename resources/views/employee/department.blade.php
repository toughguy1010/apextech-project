@extends('layouts.app')
@section('content')
    <?php
    use App\Models\Position;
    ?>
    <section id="list_user_section">
        @if (isset($message))
            <p>{{ $message }}</p>
        @endif

        @if (isset($department))
        <div class="list_user_header">
            <div class="row align-items-center">

                <h4 class="col-6">
                    Danh sách nhân viên
                    <span style="text-transform:lowercase">
                        {{ $department->name }}

                    </span>
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
                    <div class="export-excel ms-4">
                        <form action="{{ url('leader/export', $department->id) }}" class="me-0" method="get">
                            <button type="submit" class="btn btn-success " type="button" id="button-addon1"
                                style="height: 45px">
                                <i class="fa-regular fa-file-excel"></i>
                                Xuất file excel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <span class="text-gray" style="color: $purple;">
            Số lượng nhân viên : {{ $department->countUsers() }}
        </span>
        <div class="list_user_body mt-5">
            @if (isset($users) && count($users) > 0)
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
                    @foreach ($users as $user)
                        <tr id="user-{{ $user->id }}">
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td class="have-wrap">
                                {{ $user->email ?: 'Không có dữ liệu' }}
                                <br>
                                {{ $user->phone_number ?: 'Không có dữ liệu' }}
                            </td>
                            <td>{{ $user->on_board }}</td>
                            <td>
                                <?php
                                $position = Position::getPositionNameByUser($user);
                                echo $position;
                                ?>
                            </td>
                            <td>
                                <div class="satus-active">
                                    {{ $user->status == 1 ? 'Đang làm việc' : 'Đã nghỉ việc' }}
                                </div>
                            </td>
                            <td class="">

                                {{-- <a href="#" class="btn-delete" data-url="{{ url('leader/remove-employee', $user->id) }}">
                                    <i class="fa-solid fa-user-minus"></i>
                                </a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrap">
                {{-- {{ $users->links('layouts.pagination') }} --}}
                {{ $users->appends(['search' => $search])->links('layouts.pagination') }}

            </div>
            @endif
        </div> 
        @endif
        
    </section>
    @vite(['resources/js/leader/leader.js'])
@endsection
