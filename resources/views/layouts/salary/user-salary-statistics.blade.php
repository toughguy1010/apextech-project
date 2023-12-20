@extends('layouts.app')

@section('content')
    <?php
    use App\Models\User;
    ?>
    @include('admin.noti')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-chart-line me-2"></i>
                Thống kê tháng lương
            </div>
            <div class="card-body">
                <div class="col-12 d-flex justify-content-end  mt-2">
                    <div class="input-group " style="width:fit-content">
                        <form action="" class="d-flex ms-0">
                            <input class="form-control search-input " type="month" placeholder="Nhập tên tài khoản/ Email"
                                name="selected_month">
                            <button type="submit" class="btn btn-primary search-btn" type="button" id="button-addon1">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                    <div class="export-excel ms-4">
                        <form action="{{ url('salary/export', Auth::user()->id) }}" class="me-0" method="get">
                            <button type="submit" class="btn btn-success " type="button" id="button-addon1"
                                style="height: 45px">
                                <i class="fa-regular fa-file-excel"></i>
                                Xuất file excel
                            </button>
                        </form>
                    </div>
                </div>
                <div class="list_user_body mt-4">
                    <table class="table ">
                        <thead>
                            <th>
                                Tiêu đề
                            </th>
                            <th>
                                Lương tháng
                            </th>
                            <th>
                                Người tạo
                            </th>

                            <th>
                                Ngày tạo
                            </th>
                            <th>

                            </th>
                        </thead>
                        <tbody>
                            @foreach ($salaries as $salary)
                                <tr>
                                    <td style="font-size: 16px">
                                        <strong>
                                            Tiêu đề tháng lương
                                        </strong>
                                    </td>
                                    <td style="font-size: 16px">
                                        {{ $salary->month }} - {{ $salary->year }}
                                    </td>
                                    <td style="font-size: 16px">
                                        <?php
                                            $user = User::findOrFail($salary->create_by);
                                            if ($user) {
                                               ?>
                                        <div class="create-user">
                                            <img src="{{ $user->avatar }}" alt="">
                                            <span>{{ $user->name }}</span>
                                        </div>
                                        <?php
                                            }
                                        ?>
                                    </td>
                                    <td style="font-size: 16px">
                                        {{ $salary->created_at->setTimezone('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td>
                                        <a href="" class="show-salary-detail"
                                            data-url="{{ url('salary/detail-salary', $salary->id) }}">
                                            <i class="fa-solid fa-eye" style="font-size:16px"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrap">
                        {{-- {{ $users->links('layouts.pagination') }} --}}
                        {{ $salaries->links('layouts.pagination') }}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="detail-salary">

    </div>

    @include('layouts.salary.detail-salary')
    @vite(['resources/js/salary.js'])
@endsection
