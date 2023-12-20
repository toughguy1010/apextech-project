<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Salary;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalaryUserSatistics implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $user_id;
    public function __construct($user_id)
    {
        $this->user_id = $user_id;
    }
    public function collection()
    {
        //
        
        $salaries = Salary::getSalaryByUserId( $this->user_id,null,null,null);
        return $salaries;
    }
    public function headings(): array
    {
        return [
            'ID',
            'Tiêu đề',
            'ID người dùng',
            'Tháng',
            'Năm',
            'Số giờ thực tế',
            'Số giờ tiêu chuẩn',
            'Số lương thực nhật',
            'Id người tạo',
        ];
    }
    public function map($salaries): array
    {
        return [
            $salaries->id,
            $salaries->title,
            $salaries->user_id,
            $salaries->month,
            $salaries->year,
            $salaries->hours_worked,
            $salaries->standard_hour,
            $salaries->calculated_salary,
            $salaries->create_by,
        ];
    }
}
