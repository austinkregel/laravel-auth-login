Click here to reset your password: <a href="{{ $link = route('auth-login::reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
