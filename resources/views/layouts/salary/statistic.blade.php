@extends('layouts.app')

@section('content')
    @include('admin.noti')
    <?php
    use App\Models\Salary;
    
    ?>
    <div class="container-fluid">
        <div class="time_log-wrap">
            <div class="time_log-header">
                <p>
                    Thống kê lương năm {{ $year }}
                </p>
            </div>
            <form action="">
                <div class="time_log-filter row justify-content-between">
                    <div class="filter-item col-3 ps-0">
                        <div class="label">Phòng ban: </div>
                        <select name="department" id="department" class="form-select" id="department">
                            <option value="">---Chọn phòng ban---</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ isset($_GET['department']) && $_GET['department'] == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-item col-3">
                        <div class="label">Chọn tháng: </div>
                        <select class="form-control search-input" name="selected_month" id ="selected_month">
                            <option value="">---Chọn tháng---</option>
                            <?php
                            $vietnameseMonths = [
                                1 => 'Tháng 1',
                                2 => 'Tháng 2',
                                3 => 'Tháng 3',
                                4 => 'Tháng 4',
                                5 => 'Tháng 5',
                                6 => 'Tháng 6',
                                7 => 'Tháng 7',
                                8 => 'Tháng 8',
                                9 => 'Tháng 9',
                                10 => 'Tháng 10',
                                11 => 'Tháng 11',
                                12 => 'Tháng 12',
                            ];
                            foreach ($vietnameseMonths as $monthNumber => $monthName) {
                                $selected = isset($_GET['selected_month']) && $_GET['selected_month'] == $monthNumber ? 'selected' : '';
                                echo "<option value=\"$monthNumber\" $selected>$monthName</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-3 filter-item">
                        <div class="label">Chọn năm: </div>
                        <select class="form-control search-input" name="selected_year" id ="selected_year">
                            <option value="">---Chọn năm---</option>
                            <?php
                            $currentYear = date('Y');
                            $startYear = $currentYear - 20;
                            $endYear = $currentYear;
                            
                            for ($year = $endYear; $year >= $startYear; $year--) {
                                $selected = isset($_GET['selected_year']) && $_GET['selected_year'] == $year ? 'selected' : '';
                                echo "<option value=\"$year\" $selected>$year</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="filter-btn col-3 d-flex align-item-center justify-content-end">
                        <button class="btn btn-primary me-3" style="height:40px; width:130px;  margin-top: 34px;">
                            Lọc
                        </button>
                        <div class="btn btn-success export-statistic" type="button" id="button-addon1"
                            style="height:40px; width: 130px; margin-top: 34px;" data-url="{{ url('salary/export-statistic-ajax') }}">
                            <i class="fa-regular fa-file-excel"></i>
                            Xuất excel
                        </div>
                    </div>
                </div>
            </form>
            <div class="time_log-body">
                <div class="time_log-table d-flex align-items-start">
                    <div class="list_users-table">
                        <div class="list_users-header">
                            Nhân viên
                        </div>
                        <div class="list_users-body">
                            @foreach ($users as $user)
                                <div class="list_users-item">
                                    {{ $user->name }}
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="list_user_body  table-responsive" style="overflow-x: auto;">
                        <table class="table " style="box-shadow: none">
                            <thead>
                                @foreach ($months as $month)
                                    <th style="white-space:nowrap" class="day">
                                        {{ $month['name'] }}
                                    </th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        @foreach ($months as $month)
                                            <td class="avg_timelogs">
                                                <?php
                                                $has_salary = Salary::hasSalaryRecords($user->id, $month['number'], $month['year']);
                                                if ($has_salary) {
                                                    $salary = Salary::getSalaryByUserId($user->id, $month['number'], $month['year'], null);
                                                
                                                    if ($salary->isNotEmpty()) {
                                                        $salary_number = $salary[0]->calculated_salary;
                                                        $salary_format = number_format($salary_number, 0, ',', '.');
                                                        ?>
                                                <div class="show-salary-detail"
                                                    data-url="{{ url('salary/detail-salary', $salary[0]->id) }}">
                                                    {{ $salary_format }}
                                                </div>
                                                <?php
                                                    } else {
                                                        echo 0;
                                                    }
                                                } else {
                                                    echo 0;
                                                }
                                                
                                                ?>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="detail-salary">

                </div>
                @vite(['resources/js/salary.js'])
            </div>
        </div>
    </div>
@endsection
