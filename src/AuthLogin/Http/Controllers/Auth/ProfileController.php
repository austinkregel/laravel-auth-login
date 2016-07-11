<?php

namespace Kregel\AuthLogin\Http\Controllers\Auth;

use Kregel\AuthLogin\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function profile($id, $name = null)
    {
        $user_model = config('auth.providers.users.model');
        $user = $user_model::find($id);
        if(empty($user))
        {
            abort(404, 'No user found!');
        }
        if(empty($name))
        {
            return redirect(route('auth-login::profile', [$user->id, str_slug($user->name)]));
        }
        return view('auth-login::profile', compact('user'));
    }
}
