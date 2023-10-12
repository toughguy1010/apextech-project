<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Position;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        $position_code = Position::getPositionCodeByUser($user);
        var_dump($position_code);
        // Kiểm tra giá trị position_id của người dùng sau khi họ đăng nhập
        if ($user->position_id === 1 ) {
            return 111; // Điều hướng tới dashboard nếu position_id là 1 hoặc 2
        }
        if ( $user->position_id === 2) {
            return 2222; // Điều hướng tới dashboard nếu position_id là 1 hoặc 2
        }
       // Điều hướng mặc định nếu không phù hợp
    }
}
