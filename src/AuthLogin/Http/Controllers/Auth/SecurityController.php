<?php

namespace Kregel\AuthLogin\Http\Controllers\Auth;

use Hash;
use Illuminate\Http\Request;
use Kregel\AuthLogin\Http\Controllers\Controller;

class SecurityController extends Controller
{

    public function getSecurity()
    {
        return view('auth-login::security.password');
    }


    public function putSecurity(Request $request)
    {
        if(count(array_diff($request->all(), ['_token', '_method'] )) < 1){
            return redirect()->back()->withErrors('You don\'t have any thing for input.');
        }
        if (Hash::check($request->get('old_password'), auth()->user()->password) === true) {

            if ($request->get('password') === $request->get('confirm_password')) {
                auth()->user()->fill([
                    'password' => bcrypt($request->get('password'))
                ])->save();
                \Session::flash('message', 'Password changed!');
                return redirect()->back();
            } else {
                return redirect()->back()->withErrors('Your new password doesn\'t match the confirmed password');
            }

        } else {
            return redirect()->back()->withErrors('Your old password doesn\'t match the password we have on file')->withInput();
        }
    }
}

