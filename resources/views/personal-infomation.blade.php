@extends('layouts.app')
@section('content')
<?php 
use App\Models\Position;

?>
<style>
    .un_selectable {
    pointer-events: none;
    opacity: .5;
   
}

</style>
    <section id="form_user_upsert" class="container-fluid">
        <div class="">
            <h4>
               Thông tin cá nhân
            </h4>
            <form action="{{ url('personal-info', $id) }}" method="post" enctype="multipart/form-data" class="">
                @csrf
                @include('admin.noti')
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Họ và tên</label>
                        <input type="text" name="name" class="form-control" id="name"
                            value="{{ $id ? $user->name : '' }}">
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
                        <input type="text" name="phone_number" class="form-control" id="phone_number"
                            value="{{ $id ? $user->phone_number : '' }}">
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
                                <img src="{{ $user->avatar }}" alt="">
                            @endif
                        </div>
                        <input type="hidden" name="avatar" id="avatar" value="{{ $id ? $user->avatar : '' }}" />

                        @error('avatar')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="gender" class="form-label ">Giới tính</label>
                        <select class="form-select" name="gender" aria-label="Default select example">
                            <option value="">--- Chọn giới tính ---</option>
                            <option value="1" {{ $id && $user->gender === 1 ? 'selected' : '' }}>Nam</option>
                            <option value="0" {{ $id && $user->gender === 0 ? 'selected' : '' }}>Nữ</option>
                        </select>

                    </div>
                    <div class="mb-3 col-6">
                        <?php
                        ?>
                        <label for="birthday" class="form-label ">Ngày sinh</label>
                        <input type="date" name="birthday" class="form-control" id="on_board"
                            value="{{ $id ? $user->birthday : '' }}">
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="education" class="form-label ">Trình độ học vấn</label>
                        <select class="form-select" name="education" aria-label="Default select example" >
                            <option value="1" {{ $id && $user->education === 1 ? 'selected' : '' }}>Đã tốt nghiệp
                            </option>
                            <option value="0" {{ $id && $user->education === 0 ? 'selected' : '' }}>Chưa tốt nghiệp</option>
                        </select>

                    </div>
                    <div class="mb-3 col-6">
                        <?php
                        ?>
                        <label for="marital_status" class="form-label ">Tình trạng hôn nhân</label>
                        <select class="form-select" name="marital_status" aria-label="Default select example" >
                            <option value="1" {{ $id && $user->marital_status === 1 ? 'selected' : '' }}>Đã kết hôn
                            </option>
                            <option value="0" {{ $id && $user->marital_status === 0 ? 'selected' : '' }}>Chưa kết hôn</option>

                        </select>

                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="status" class="form-label ">Trạng thái</label>
                        <select class="form-select un_selectable" name="status" aria-label="Default select example" >
                            <option value="1" {{ $id && $user->status === 1 ? 'selected' : '' }}>Đang làm việc
                            </option>
                            <option value="0" {{ $id && $user->status === 0 ? 'selected' : '' }}>Nghỉ việc</option>
                        </select>

                    </div>
                    <div class="mb-3 col-6">
                        <?php
                        ?>
                        <label for="email" class="form-label ">Chức vụ</label>
                        <select class="form-select un_selectable" name="position_id" aria-label="Default select example"  >
                            <option value="">--- Chọn chức vụ ---</option>
                            @foreach ($positions as $item)
                                <option value="<?= $item->id ?>" {{ $id && $user->position_id === $item->id ? 'selected' : '' }}>
                                    <?= $item->position_name ?></option>
                            @endforeach

                        </select>
                        
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="on_board" class="form-label ">Ngày bắt đầu làm việc</label>
                        <input type="date" name="on_board" class="form-control" id="on_board" readonly
                            value="{{ $id ? $user->on_board : '' }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="off_board" class="form-label ">Ngày kết thúc làm việc</label>
                        <input type="date" name="off_board" readonly class="form-control" id="off_board"
                            value="{{ $id ? $user->off_board : '' }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ $id ? 'Cập nhật' : 'Thêm' }} thông tin</button>
                <button type="submit" class="btn ms-3 btn-danger">Quay lại</button>
            </form>
        </div>
        <script>

        </script>
    </section>
@endsection
