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
                    Danh sách tài khoản
                </h4>
                <div class="col-6 d-flex justify-content-end">
                    {{-- <form action="" id="myForm">
                        <div class="me-4" style="width: 150px">
                            <?php 
                                $positions = Position::all();
                            ?>
                            <select class="form-select" name="position_id" aria-label="Default select example" onchange="submitForm()">
                                <option value="">--- Chọn vị trí ---</option>
                                @foreach ($positions as $item)
                                    <option value="<?= $item->id ?>" {{ isset($_GET['position_id']) && $_GET['position_id'] == $item->id ? 'selected' : '' }} ><?= $item->position_name ?></option>
                                @endforeach
    
                            </select>
                            <script>
                                function submitForm() {
                                    document.getElementById("myForm").submit();
                                }
                                </script>
                        </div>
                    </form> --}}
                
                    
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
                        <form action="{{url('admin/user/export') }}" class="me-0" method="get">
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
                    @foreach ($users as $user)
                        <tr id="user-{{ $user->id}}">
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
                                <a href="{{ url('admin/user/upsert', $user->id) }}" class="me-4">
                                    <i class="fa-solid fa-user-pen"></i>
                                </a>
                                <a href="#" class="btn-delete" data-url="{{ url('admin/user/destroy', $user->id) }}">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrap">
                {{-- {{ $users->links('layouts.pagination') }} --}}
                {{ $users->appends(['search' => $search ])->links('layouts.pagination') }}

            </div>
        </div>
    </section>
    @vite(['resources/js/admin/user.js'])
@endsection
