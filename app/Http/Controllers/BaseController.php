<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class BaseController extends Controller
{
    protected function getCart()
    {
        return json_decode(Cookie::get('cart', '[]'), true);
    }
}
