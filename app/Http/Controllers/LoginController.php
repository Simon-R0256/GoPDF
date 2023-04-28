<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle an authentication request
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    //Funktion zur Authentifizierung des Logins
    public function authenticate(Request $request)
    {
        //Login-Daten werden gespeichert
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        //Built-in Function zur Authentifizierung
        if (Auth::attempt($credentials)) {
            //Session wird erstellt
            $request->session()->regenerate();
            //Startseite nach dem Login ist die Dokumentenverwaltung
            return redirect('documents');
        } else {
            return back()
                        ->with('email', $request->input("email"))
                        ->with('error', 'Falsche E-Mail-Adresse oder Passwort');                    
        }
    }
}
