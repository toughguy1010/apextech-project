<?php
use App\Models\Salary;

?>

<table class="table " style="box-shadow: none">
    <thead>
        <tr>
            <th style="white-space:nowrap">Nhân viên/Tháng</th>
            @foreach ($months as $month)
                <th style="white-space:nowrap" class="day">
                    {{ $month['name'] }}
                </th>
            @endforeach
        </tr>

    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
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
                        <div class="show-salary-detail">
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
