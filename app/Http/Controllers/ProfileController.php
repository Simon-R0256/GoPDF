<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Key;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{   
    //Ändert das Passwort
    function changePassword(Request $request){
        $user = User::find(Auth::User()->id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back();
    }
    
    //Lädt den API-Key des Redakteurs und zeigt ihn an
    function showKey(Request $request){
    
        $key = Key::where('owner_id',$request->id)->first();

        if($key != null){
            return response([
                'key' => $key->key, 
                'date' => date('d.m.Y', strtotime($key->expiration_date))]
                ,200
            );
        }
    }


    //Gibt den Redakteur einen neuen Key
    function getKey(Request $request){
        
        $key = Key::where('owner_id',$request->id)->first();

        //Wenn bereits ein gültiger key existiert wird die Funktion abgebrochen
        //Wenn ein ungültiger Key existiert wird der alte Key gelöscht
        if($key != null){
            if($this->keyIsExpired($key)){
                $key->delete();
            }
            else{
                return;
            }
        }
        
        //Erstellt einen neuen Key mit gültigkeit für 14 Tage und gibt ihn zurück
        $newKeyVal = md5(time() . rand());                         
        $newKey = Key::create([
            'key' => $newKeyVal,
            'expiration_date' => date('Y-m-d', strtotime(date("Y-m-d"). ' + 14 days')),
            'owner_id' => Auth::User()->id
        ]); 

        return response([
            'key' => $newKey->key, 
            'date' => date('d.m.Y', strtotime($newKey->expiration_date))]
            ,200
        );
        
    }

    function keyIsExpired($key){
        if (date("Y-m-d") <= $key->expiration_date) {
            return false;
        }
        return true;
    }
}
