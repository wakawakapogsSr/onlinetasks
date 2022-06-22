<?php

namespace App\Http\Controllers\open_user_reg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Auth;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthenticationController extends Controller
{
  protected $repository;

  public function __construct(User $user)
  {
      $this->model = new UserRepository($user);
  }

  public function register()
  {
    return view('open_user_reg.register');
  }

  public function register_post(Request $request)
  {
    $this->validate($request, [
        'name' => 'required|max:120',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed'
    ]);

    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'company' => $request->company
    ]);

    $user->assignRole(Role::find(3));

    return redirect()->back()->with('message', 'ACCOUNT REGISTER SUCCESSFULLY!');
  }

  public function login()
  {
    return view('open_user_reg.login');
  }
}
