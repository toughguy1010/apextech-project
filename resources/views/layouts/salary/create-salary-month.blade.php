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
                        <div class="col-3">
                            <label for="month">Chọn Tháng : </label>
                            <select class="form-control search-input" name="selected_month">
                                <?php
                                $vietnameseMonths = array(
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
                                    12 => 'Tháng 12'
                                );
                        
                                foreach ($vietnameseMonths as $monthNumber => $monthName) {
                                    echo "<option value=\"$monthNumber\">$monthName</option>";
                                }
                                ?>
                            </select>
                        </div>  
                        <div class="col-3">
                            <label for="year">Chọn Năm : </label>
                            <select class="form-control search-input" name="selected_year">
                                <?php
                                $currentYear = date('Y');
                                $startYear = $currentYear - 20;
                                $endYear = $currentYear;
                                
                                for ($year = $endYear; $year >= $startYear; $year--) {
                                    echo "<option value=\"$year\">$year</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="">Tiêu đề : </label>
                            <input type="text" name="title" class="form-control" id="">
                        </div>

                    </div>
                    <div class="row justify-content-end mt-4">
                        <div style="width: fit-content">
                            <button type="submit" class="btn btn-primary" name="" id="">
                                Tạo
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function getYear() {
            // Get the selected year from the input
            var selectedYear = document.getElementById('selected_year').value;

            // Display the selected year
            alert('Selected Year: ' + selectedYear);
        }
    </script>
@endsection
