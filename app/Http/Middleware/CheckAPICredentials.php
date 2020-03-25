<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;
use Illuminate\Contracts\Auth\Factory as Auth;

class CheckAPICredentials extends CheckClientCredentials
{

    protected function validateCredentials($token)
    {
        $auth = app(Auth::class);
        if (!$token->user_id) {
            if (! $token || $token->client->firstParty()) {
                throw new AuthenticationException;
            }
        } else {
            if ($auth->guard('api')->guest()) {
                throw new AuthenticationException;
            }
        }
    }
}
