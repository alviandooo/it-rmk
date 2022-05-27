<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;
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
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function qrlogin($dataqr)
    {
        $temp = explode('-', $dataqr);
        $nip = $temp[0];

        $data = DB::table('users')->where('nip',$nip);
        if($data->count() != '0'){
            if($data->first()->status_aktif == '1'){
                Auth::loginUsingId($data->first()->id);
                return response()->json(['status'=>200]); 
                // return redirect()->route('home');
                // return "berhasil";
                // Auth::login($data->first());
            }else{
                return response()->json(['text'=>'User telah dinonaktifkan!', 'status'=>700]); 
            }
        }else{
            return response()->json(['text'=>'User belum terdaftar!', 'status'=>400]); 
        }

    }
}
