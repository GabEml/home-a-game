<?php

namespace App\Responses;

use Illuminate\Http\Response;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new Response('', 201)
            : redirect(config('fortify.sessions'));
    }
}