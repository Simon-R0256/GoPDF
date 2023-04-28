<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Password_resets;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{


    /*Prüft ob die übergebene Mail im System ist, generiert ein Mail-Token und 
    schickt mit der built-in Function Mail eine Nachricht an die entsprechende E-Mail*/
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        /*Email Token
        $username wird für das Begrüßen in der Mail verwendet
        Datenbankeintrag
        */
        $token = Str::random(64);
        $username = Str::before($request->input('email'), '@');
        Password_Resets::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        /*Mail built in function die mit send() eine message an die angegebene Mail verschickt
        */
        Mail::send('email.forgetPassword', ['token' => $token,'username'=>$username], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });
        //zurück zum Login
        return back();
    }


    //Ändert das Passwort des Nutzers
    public function submitResetPasswordForm(Request $request)
    {
        //Validierungsfunktion
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = Password_resets::where('token', $request->token)->first();
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        //Passwortupdate
        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        //Löschen des Resetlogs
        Password_resets::where('email',$request->email)->delete();
        return redirect('/');
    }
}
