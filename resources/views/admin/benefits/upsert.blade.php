@extends('layouts.app')
@section('content')
    <?php
    use App\Models\Position;
    
    ?>
    <section id="form_user_upsert" class="container-fluid">
        <div class="">
            <h4>
                Tạo phúc lợi
            </h4>
            <form action="{{ url('admin/benefit/upsert',$benefit->id) }}" method="post" enctype="multipart/form-data" class="">
                @csrf
                @include('admin.noti')
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Tên phúc lợi: </label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $id ? $benefit->name : " " }}">
                    </div>
                    <div class="mb-3 col-6">
                        <label for="" class="form-label ">Mô tả phúc lợi: </label>
                        <input type="text" name="description" class="form-control" id="" value="{{ $id ? $benefit->description : " " }}">
                    </div>
                </div>
                <div class="row row-input">
                    <div class="mb-3 col-6">
                        <label for="name" class="form-label required">Quy chế phúc lợi: </label>
                        <textarea name="policy" id="policy" class="form-control" cols="30" rows="10">
                            {{ $id ? $benefit->policy : " " }}
                        </textarea>
                        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
                        <script>
                            tinymce.init({
                                selector: 'textarea',
                                height: 500,
                                plugins: 'code',
                                toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | code',
                            });
                        </script>
                    </div>
                    <div class="mb-3 col-6">
                        <label for="" class="form-label "> Giá trị phúc lợi (nếu có): </label>
                        <input type="text" name="price" class="form-control" id="" value="{{ $id ? $benefit->price : " " }}" >
                    </div>
                </div>


                <button type="submit" class="btn btn-primary"> Tạo công việc</button>
                <a href="{{ url('admin/benefit') }}" class="btn ms-3 btn-danger">Quay lại</a>
            </form>
        </div>
        @vite(['resources/js/app.js'])
    </section>
@endsection
