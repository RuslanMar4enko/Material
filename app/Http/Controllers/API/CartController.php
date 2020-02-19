<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
      return Cart::getContent();
    }

    public function create()
    {

    }
}
