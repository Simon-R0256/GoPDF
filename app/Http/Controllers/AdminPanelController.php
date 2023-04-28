<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminPanelController extends Controller
{

    //Funktion zur Erstellung von API Keys
    //Der Key ist ein md5 Hash einer randomisierten Zahl verknüpft mit der aktuellen Zeit
    function key_create(Request $daten)
    {
         $daten->validate([                                                                          
            'date' => 'required|date_format:Y-m-d',
        ]);

        $key = md5(time() . rand());
        Key::create([
            'key' => $key,
            'expiration_date' => $daten->input('date'),
            'owner_id' => Auth::User()->id
        ]);
        return response([""], 200);
    }

    //Funktion zum Löschen von API Keys
    function key_delete(Request $daten)
    {
         $daten->validate([                                                                          
            'key' => 'required|exists:keys|',
        ]);

        $api_key = $daten->input('key');
        Key::where('key', $api_key)->delete();

        return response([""], 200);
    }

    //Funktion zum Erstellen von Nutzern der Webapplikation
    //Im Request wird ein Value für den Button mitgeliefert, der bestimmt ob der Nutzer ein Admin oder ein Redakteur ist
    //Nutzername ist der String vor dem ersten @ in der Mail-Adresse
    //Das Passwort wird für die Validierung mit einer built in Function gehasht
    function user_create(Request $daten)
    {
        $daten->validate([                                                                          
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
        ]);

        $check_admin = $daten->boolean('check');
        if ($check_admin) {
            $check_admin = 'Admin';
        } else {
            $check_admin = 'Redakteur';
        }

        $username = Str::before($daten->input('email'), '@');
        $hashedpassword = Hash::make($daten->input('password'));

        User::create([
            'username' => $username,
            'email' => $daten->input('email'),
            'password' => $hashedpassword,
            'role' => $check_admin
        ]);

        return response([""], 200);
    }
    
    //Funktion zum Löschen von Nutzern
    function user_delete(Request $daten)
    {
        $daten->validate([                                                                          
            'id' => 'required|integer|exists:users|',
        ]);

        User::where('id', $daten->input('id'))->delete();

        return response([""], 200);
    }
}
