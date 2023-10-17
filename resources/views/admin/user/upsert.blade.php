@extends('layouts.app')
@section('content')
    <section id="form_user_upsert" class="container-fluid">
        <div class="">
            <h4>
                Thêm mới tài khoản
            </h4>
            <form action="" method="post" enctype="multipart/form-data" class="">
                @csrf
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="username" class="form-label required">Tên đăng nhập</label>
                        <input type="text" name="username" class="form-control" id="username">

                    </div>
                    <div class="mb-3 col-6">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Họ và tên</label>
                        <input type="text" name="name" class="form-control" id="name">

                    </div>
                    <div class="mb-3 col-6">
                        <label for="email" class="form-label required">Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            aria-describedby="emailHelp">
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="phone_number" class="form-label required">Số điện thoại</label>
                        <input type="text" name="phone_number" class="form-control" id="phone_number">

                    </div>
                    <div class="mb-3 col-6 row">
                        <div class=" col-3">
                            <label for="img" class="form-label required"> Ảnh đại diện </label>

                            <input type="file" class="form-contro" name="file" id="upload"
                                data-url="{{ url('/upload ') }}" />
                        </div>
                       

                        <div id="show_img" class="">

                        </div>
                        <input type="hidden" name="thumb" id="thumb" />
                    </div>
                </div>

                <div class="mb-3 form-check ">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        @vite(['resources/js/admin/user.js'])
    </section>
@endsection
