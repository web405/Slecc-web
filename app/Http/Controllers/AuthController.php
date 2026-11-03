<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller {
 public function loginForm(){return view('admin.login');}
 public function login(Request $request){$credentials=$request->validate(['email'=>'required|email','password'=>'required|string']);if(Auth::attempt($credentials)){if(!Auth::user()->is_admin){Auth::logout();return back()->withErrors(['email'=>'This account has no admin access.']);}$request->session()->regenerate();return redirect()->route('admin.dashboard');}return back()->withErrors(['email'=>'Invalid email or password.'])->onlyInput('email');}
 public function logout(Request $request){Auth::logout();$request->session()->invalidate();$request->session()->regenerateToken();return redirect()->route('home');}
}
