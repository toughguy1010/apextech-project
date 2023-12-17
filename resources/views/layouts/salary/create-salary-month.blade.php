@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                Tạo thống kê tháng lương người dùng
            </div>
            <div class="card-body">
                <form action="">
                    <div class="row">
                        <div class="col-6">
                            <label for="month">Chọn thời gian : </label>
                            <input type="month" name="" class="form-control" id="">
                        </div>
                        <div class="col-2">
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
