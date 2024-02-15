<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthendicationController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function login()
    {
        return view('login.login');
    }

    public function admin_login(Request $request)
    {

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        // Attempt to authenticate using the 'web' guard (admin_users provider)
        if (Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            $user = User::where('email', $email)->first();
            Auth::guard('web')->login($user);
            $this->showSweetAlert('success', 'Admin Login Successfully', 'Successfully Logined');
            return redirect('/dashboard');
        } else {
            return back()->withErrors(['login' => 'Invalid credentials. Please try again.']);
        }
    }
  // Helper method to show SweetAlert notification
  private function showSweetAlert($type, $title, $message, $timer = 3000)
  {
      $alert = [
          'type' => $type,
          'title' => $title,
          'text' => $message,
          'timer' => $timer,
          'timerProgressBar' => true,
      ];

      Session::flash('sweet_alert', $alert);
  }

  public function admin_logout()
  {
      auth()->guard('web')->logout();

      $this->showSweetAlert('success', 'Admin Logout Successful', 'Successfully Logout');
      return redirect('/');
  }
}
