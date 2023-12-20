@extends('layouts.app')

@section('content')
@include('admin.noti')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Tạo thống kê tháng lương người dùng
            </div>
            <div class="card-body">
                <form action="" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-6">
                            <label for="month">Chọn thời gian : </label>
                            <input type="month" name="selected_month" class="form-control" id="">
                        </div>
                        <div class="col-6">
                            <label for="">Tiêu đề : </label>
                            <input type="text" name="title" class="form-control" id="">
                        </div>
                        
                    </div>
                    <div class="row justify-content-end mt-4">
                        <div style="width: fit-content">
                            <button type="submit" class="btn btn-primary" name=""  id="">
                                Tạo
                            </button>
                        </div>
                         
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
