@extends('layouts.app')
@section('content')
    <?php
    use App\Models\Position;
    
    ?>
    <section id="form_user_upsert" class="container-fluid">
        <div class="">
            <h4>
                {{ $id ? 'Cập nhật' : 'Thêm mới' }} phúc lợi
            </h4>
            <form action="{{ url('admin/benefit/upsert', $id) }}" method="post" enctype="multipart/form-data" class="">
                @csrf
                @include('admin.noti')
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Tên phúc lợi: </label>
                        <input type="text" name="name" class="form-control" id="name"
                            value="{{ $id ? $benefit->name : ' ' }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="" class="form-label ">Mô tả phúc lợi: </label>
                        <input type="text" name="description" class="form-control" id=""
                            value="{{ $id ? $benefit->description : ' ' }}">
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Quy chế phúc lợi: </label>
                        <textarea name="policy" id="policy" class="form-control tinymce" cols="30" rows="10">
                            {{ $id ? $benefit->policy : ' ' }}
                        </textarea>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="file" class="form-label">Tệp tin đính kèm:</label>
                        <input type="file" name="file" class="form-control" id="file">
                        @if (isset($benefit) && $benefit->file_path)
                        <label for="name" class="form-label mt-3 mb-1">Tên file hiện tại: </label>
                            <div class="benefit-document">
                                <i class="fa-regular fa-file"></i>
                                @php
                                    // Lấy tên tệp tin từ đường dẫn đầy đủ
                                    $filename = pathinfo($benefit->file_path, PATHINFO_FILENAME);
                                @endphp
                             
                                <a href="{{ url('admin/benefit/download', $benefit->id) }}" class=""
                                download>   {{ $filename }}</a>
                            </div>
                            {{-- <a href="{{ url('admin/benefit/download', $benefit->id) }}" class="btn btn-sm btn-primary"
                                download>Tải xuống</a> --}}
                            </p>
                        @endif
                    </div>

                </div>

                {{-- <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="" class="form-label "> Giá trị phúc lợi (nếu có): </label>
                        <input type="text" name="price" class="form-control" id=""
                            value="{{ $id ? $benefit->price : ' ' }}">
                    </div>
                </div> --}}
                <div class="right-btn">
                    <button type="submit" class="btn btn-primary"> Tạo phúc lợi</button>
                @if (Auth::user()->position_id == 4)
                <a href="{{ url('ceo/benefit') }}" class="btn ms-3 btn-danger">Quay lại</a>
                @else
                <a href="{{ url('admin/benefit') }}" class="btn ms-3 btn-danger">Quay lại</a>

                @endif
                </div>
                
            </form>
        </div>
        @vite(['resources/js/app.js'])
    </section>
@endsection
