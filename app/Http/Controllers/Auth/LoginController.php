<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Define para onde redirecionar após o login
    protected $redirectTo = '/index';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
