<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct() {
      $this->middleware('auth:admin'); //passar o parametro admin para o middleware auth.
    }
    public function index() {
      return view('admin');
    }
}
