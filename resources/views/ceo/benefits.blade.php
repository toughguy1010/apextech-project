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
                <h4 class="col-6 benefits-list-title">
                    Danh sách phúc lợi
                <br>
                    <span>phúc lợi hiện có: <strong>{{ count($benefits) }}</strong></span>
                </h4>
                <div class="col-6 d-flex justify-content-end">
                    <div class="input-group " style="width:fit-content">
                        <form action="" class="d-flex ms-0">
                            <input class="form-control search-input " type="text" placeholder="Nhập tên phúc lợi"
                                name="search">
                            <button type="submit" class="btn btn-primary search-btn" type="button" id="button-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="list_user_body mt-5">
            <table class="table table-benefit">
                <thead>
                    <th style="border-top-left-radius: 10px; width: 15%;">
                        Tên phúc lợi
                    </th>
                    <th>
                        Quy chế phúc lợi
                    </th>
                    <th>
                        Tệp đính kèm phúc lợi
                    </th>
                </thead>
                <tbody>
                    @foreach ($benefits as $benefit)
                        <tr id="benefit-{{ $benefit->id }}">
                            <td style="width: 25%;">
                                <div class="benefit-name">
                                    <p>
                                        {{ $benefit->name }}
                                    </p>
                                    <span>
                                        {{ $benefit->description }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                {!! $benefit->policy !!}
                            </td>
                            <td style="width: 20%">
                                @if ($benefit->file_path)
                                    @php
                                        // Lấy tên tệp tin từ đường dẫn đầy đủ
                                        $filename = pathinfo($benefit->file_path, PATHINFO_FILENAME);
                                    @endphp

                                    <a href="{{ url('admin/benefit/download', $benefit->id) }}" class=" d-flex " download>
                                        <i class="fa-solid fa-download me-2"></i> {{ $filename }}
                                    </a>
                                @else
                                    Không có tệp đính kèm
                                @endif
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
