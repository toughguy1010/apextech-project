@extends('layouts.app')
@section('content')
    <section id="form_user_upsert" class="container-fluid">
        <div class="">
            <h4>
                {{ $id ? 'Cập nhật' : 'Tạo' }} công việc
            </h4>
            <form action="{{ url('admin/task/upsert', $id) }}" method="post" enctype="multipart/form-data" class="">
                @csrf
                @include('admin.noti')


                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Tiêu đề công việc</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $id ? $task->name : "" }}">

                    </div>
                    <div class="mb-3 col-6">
                        <label for="" class="form-label ">Mô tả công việc</label>
                        <input type="text" name="description" class="form-control" id="" value="{{ $id ? $task->description : "" }}">
                    </div>
                </div>

                

                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="" class="form-label ">Thời gian bắt đầu</label>
                        <input type="date" name="start_date" class="form-control" id="" value="{{ $id ? $task->start_date : "" }}">
                    </div>

                    <div class="mb-3 col-6">
                        <label for="" class="form-label ">Thời gian kết thúc</label>
                        <input type="date" name="end_date" class="form-control" id="" value="{{ $id ? $task->end_date : "" }}">
                    </div>
                </div>

                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <div for="name" class="form-label fw-bold">Nội dung công việc</div>
                        <textarea name="content" id="task_content"  rows="5" style="width: 100%">
                            {{ $id ? $task->content : "" }}
                        </textarea>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="" class="form-label required">Độ ưu tiên công việc</label>
                        <select class="form-select" name="priority" aria-label="Default select example">
                            <option value="">--- Độ ưu tiên ---</option>
                            <option value="0" {{ $id && $task->priority == 0 ? "selected" : "" }}>Thấp</option>
                            <option value="1"{{ $id && $task->priority == 1 ? "selected" : "" }}>Bình thường</option>
                            <option value="2" {{ $id && $task->priority == 2 ? "selected" : "" }}>Cao</option>
                            <option value="3" {{ $id && $task->priority == 3 ? "selected" : "" }}>Cấp bách</option>
                        </select>
                        @error('position_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">{{ $id ? 'Cập nhật' : 'Tạo' }} công việc</button>
                <a href="{{ url('admin/department') }}" class="btn ms-3 btn-danger">Quay lại</a>
            </form>
        </div>
        {{-- @vite(['resources/js/admin/department.js']) --}}
    </section>
@endsection
