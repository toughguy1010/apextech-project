<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
class StatisticExport implements FromView
{
    protected $users;
    protected $months;

    public function __construct($users, $months)
    {
        $this->users = $users;
        $this->months = $months;
    }

    public function view(): View
    {
        return view('layouts.salary.test-export', [
            'users' =>  $this->users,
            'months' => $this->months
        ]);
    }

}
