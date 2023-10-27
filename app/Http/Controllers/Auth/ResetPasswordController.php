<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use App\Models\Position;
use Illuminate\Http\Request;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    
    protected $redirectTo = RouteServiceProvider::RESET;

    public function checkAfterReset()
    {
        $user = Auth::user();
        $position_code = Position::getPositionCodeByUser($user);
        switch ($position_code) {
            case 'admin':
                return redirect()->route('admin.home');
                break;
            case 'employee':
                return redirect()->route('employee.home');
                break;
            case 'manager':
                return redirect()->route('manager.home');
                break;
        }
    }

}
