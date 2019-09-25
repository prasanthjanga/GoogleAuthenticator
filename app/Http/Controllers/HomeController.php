<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\GoogleAuthenticatorController;
use Illuminate\Support\Facades\Auth;


use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('googleAuthenticator', ['except' => ['google_auth_first']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function google_auth_first(Request $request)
    {

        $google_aoth = new GoogleAuthenticatorController();
        
        if (!empty($request->all())) {
            $rules =  [
                'account_key'   => 'required',
                'otp'           => 'required|numeric',
            ];
            $messages = [];

            $this->validate($request, $rules, $messages);
            $google_aoth_qr = $google_aoth->google_aoth($request->account_key);

            if (!empty($google_aoth_qr) && 
                array_key_exists('one_code', $google_aoth_qr) &&
                $google_aoth_qr['one_code'] == $request->otp) {
                // echo $request->account_key;exit;
                    User::where('id', Auth::id())
                    ->where('google_auth_code', null)
                    ->update(['google_auth_code'=>$request->account_key]);
                    
                    session(['google_auth_flag' => true]); //TO CHECK USER ENTERED OTP OR NOT

                    return redirect('/');
            }
        }

        $user_account_key = User::where('id', Auth::id())
            ->select('google_auth_code')
            ->get()->toArray();
        
        $user_account_key = (!empty($user_account_key) && array_key_exists('google_auth_code',$user_account_key[0]))?$user_account_key[0]['google_auth_code']:null;
        

        $google_aoth_qr = $google_aoth->google_aoth($user_account_key);

        if (!empty($user_account_key)) {
            return view('google_authenticator.index',compact('google_aoth_qr'));
        }else{
            return view('google_authenticator.google_auth_first',compact('google_aoth_qr'));
        }
    }
}
