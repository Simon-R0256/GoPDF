<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    /**
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    //Funktion die einen Logout durchführt
    public function logout(Request $request)                                        
    {
        //Session Buffer wird gelöscht
        Session::flush();
        //Authentifizierung wird aufgehoben
        Auth::logout();

        //invalidiert die User-Session
        $request->session()->invalidate();
        //regeneriert den CSRF Token
        $request->session()->regenerateToken();

        //Redirect auf die Login-Seite
        return redirect('/');
    }
}
