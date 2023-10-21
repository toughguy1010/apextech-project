@extends('layouts.app')
@section('content')
    <section id="form_user_upsert" class="container-fluid">
        <div class="">
            <h4>
                {{ $id ? 'Cập nhật' : 'Thêm mới' }} tài khoản
            </h4>
            <form action="{{ url('admin/user/upsert', $id) }}" method="post" enctype="multipart/form-data" class="">
                @csrf
                @include('admin.noti')
                @if ($id === null)
                    <div class="row row-input">
                        <div class="mb-3 col-6">
                            <label for="username" class="form-label required">Tên đăng nhập</label>
                            <input type="text" name="username" class="form-control" id="username" disabled>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3 col-6">
                            <label for="password" class="form-label required">Mật khẩu</label>
                            <input type="password" name="password" class="form-control" id="password" disabled>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                @endif

                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Họ và tên</label>
                        <input type="text" name="name" class="form-control" id="name"  value="{{ $id ? $user->name : '' }}">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-6">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            aria-describedby="emailHelp" value="{{ $id ? $user->email : '' }}">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="phone_number" class="form-label required">Số điện thoại</label>
                        <input type="text" name="phone_number" class="form-control" id="phone_number" value="{{ $id ? $user->phone_number : '' }}">
                        @error('phone_number')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3 col-6 row">
                        <div class=" col-3">
                            <label for="img" class="form-label required"> Ảnh đại diện </label>

                            <input type="file" class="form-contro" name="file" id="upload"
                                data-url="{{ url('/upload ') }}" />
                        </div>


                        <div id="show_img" class="">
                            @if ($id != null)
                                <img src="{{ $user->avatar  }}" alt="">
                            @endif
                        </div>
                        <input type="hidden" name="avatar" id="avatar" value="{{ $id ? $user->avatar : '' }}"/>

                        @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="status" class="form-label ">Trạng thái</label>
                        <select class="form-select" name="status" aria-label="Default select example">
                            <option value="1" {{ $id && $user->status === 1 ? 'selected' : ''}}>Đang làm việc</option>
                            <option value="0" {{ $id && $user->status === 0 ? 'selected' : ''}} >Nghỉ việc</option>
                        </select>

                    </div>
                    <div class="mb-3 col-6">
                        <?php
                        ?>
                        <label for="email" class="form-label required">Vị trí</label>
                        <select class="form-select" name="position_id" aria-label="Default select example">
                            <option value="">--- Chọn vị trí ---</option>
                            @foreach ($positions as $item)
                                <option value="<?= $item->id ?>" {{ $id && $user->position_id === $item->id  ? 'selected' : ''}}><?= $item->position_name ?></option>
                            @endforeach

                        </select>

                        @error('position_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="on_board" class="form-label ">Ngày bắt đầu làm việc</label>
                        <input type="date" name="on_board" class="form-control" id="on_board" value="{{ $id ? $user->on_board : '' }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="off_board" class="form-label ">Ngày kết thúc làm việc</label>
                        <input type="date" name="off_board" class="form-control" id="off_board" value="{{ $id ? $user->off_board : '' }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ $id ? 'Cập nhật' : 'Thêm' }} tài khoản</button>
                <button type="submit" class="btn ms-3 btn-danger">Quay lại</button>
            </form>
        </div>
        @vite(['resources/js/admin/user.js'])
    </section>
@endsection
