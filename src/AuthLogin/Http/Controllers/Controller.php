<?php

namespace Kregel\AuthLogin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected function fireEvent ($event, $reason, $request, $failed) {
        $eventful = config('kregel.auth-login.events.'.$event);
        if($eventful instanceof \Closure)
            $eventful($request, $reason, $failed);
    }
}
