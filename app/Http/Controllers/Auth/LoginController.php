<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Position;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
    private $user;

    public function __construct(User $user)
    {
        $this->middleware('guest')->except('logout');
        $this->user = $user;
    }
    public function logout()
    {
        Auth::logout();

        return redirect('/login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
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
                    // Xử lý cho các vị trí khác (nếu cần)
                default:
                    return redirect(RouteServiceProvider::HOME);
                    break;
            }

        }else{

        }

        return back()->withErrors(['username' => 'Tên đăng nhập không hợp lệ']);
    }

}
