<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function login(Request $request) {
      $this->validate($request, [
        'email' => 'required|string',
        'password' => 'required',
      ]);

      $credentials = [
        'email' => $request->email,
        'password' => $request->password
      ];

      $authOK = Auth::guard('admin')->attempt($credentials, $request->remember);

      if($authOK) {
        return redirect()->intended(route('admin.dashboard'));
      }

      return redirect()->back()->withInputs($request->only('email','remember')); //back() -> o user volta pra pagian anterior onde estava q é a pagina do login
        //withInputs() -> leva com ele e mostra o email que inseriu e o remember checado.
    }

    public function index() {
      return view('auth.admin-login');
    }
}
