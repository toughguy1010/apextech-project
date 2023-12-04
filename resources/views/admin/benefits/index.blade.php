@extends('layouts.app')
@section('content')
    <?php
    use App\Models\Task;
    ?>
    <section id="list_user_section">
        <div class="message">
        </div>
        <div class="list_user_header">
            <div class="row align-items-center">
                <h4 class="col-6">
                    Danh sách công việc
                </h4>
                <div class="col-6 d-flex justify-content-end">
                    <div class="input-group " style="width:fit-content">
                        <form action="" class="d-flex ms-0">
                            <input class="form-control search-input " type="text" placeholder="Nhập tên công việc"
                                name="search">
                            <button type="submit" class="btn btn-primary search-btn" type="button" id="button-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                    {{-- <div class="export-excel ms-4">
                        <form action="{{url('admin/user/export') }}" class="me-0" method="get">
                            <button type="submit" class="btn btn-success " type="button" id="button-addon1"
                                style="height: 45px">
                                <i class="fa-regular fa-file-excel"></i>
                                Xuất file excel
                            </button>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="list_user_body mt-5">
            <table class="table table-benefit">
                <thead>
                    <th style="border-top-left-radius: 10px;">
                        Tên phúc lợi
                    </th>
                    <th>
                        Mô tả phúc lợi
                    </th>
                    <th>
                        Quy chế phúc lợi
                    </th>
                    <th>
                        Giá trị phúc lợi
                    </th>
                    <th>

                    </th>
                </thead>
                <tbody>
                    @foreach ($benefits as $benefit)
                        <tr>
                            <td>
                                {{ $benefit->name }}
                            </td>
                            <td>
                                {{ $benefit->description }}
                            </td>
                            <td>
                                {!! $benefit->policy !!}
                            </td>
                            <td>
                                {{ $benefit->price }}
                            </td>
                            <td>
                                <a href="{{ url('admin/benefit/upsert', $benefit->id) }}" class="me-4">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="{{ url('admin/benefit/destroy', $benefit->id) }}" class="me-4">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-wrap">
                {{ $benefits->appends(['search' => $search])->links('layouts.pagination') }}

            </div>
        </div>
    </section>
    @vite(['resources/js/admin/benefit.js'])
@endsection
