<?php

namespace App\Exports;

use App\Models\Position;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Collection;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    public function collection()
    {
        //
        return User::query()->select(
            'id',
            'name',
            'username',
            'email',
            'phone_number',
            'status',
            'position_id',
            'on_board',
            'off_board',
            'note',
        )->get();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Họ và tên',
            'Tên đăng nhập',
            'Email',
            'Số điện thoại',
            'Trạng thái',
            'Chức vụ',
            'Ngày bắt đầu',
            'Ngày nghỉ việc',
            'Ghi chú',
        ];
    }
    public function map($user): array
    {
        $status = $user->status == 1 ? 'Đang làm việc' : 'Đã nghỉ việc';
        $position = Position::getPositionNameByUser($user);
        
        return [
            $user->id,
            $user->name,
            $user->username,
            $user->email,
            $user->phone_number,
            $status,
            $position ,
            $user->on_board,
            $user->off_board,
            $user->note,
        ];
    }
}
