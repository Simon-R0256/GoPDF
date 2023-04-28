<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documents;
use App\Models\Key;
use Illuminate\Support\Facades\Auth;

class TableController extends Controller
{   
    /*
    Der Table-Controller ist dafür zuständig Arrays zu erstellen ("$tableObject"), die 
    dann den jeweiligen DataTables initialisierungen übergeben werden.
    Dafür wird eine Database-Tabelle iteriert und die gefragten Daten in ein array ($newrow) gepackt, 
    ggf. mit HTML/CSS-Format Anpassungen. Am ende jeder iterierung wird die $newrow in das $tableObject gepackt.
    Jede $newrow repräsentiert eine Reihe der HTML-Tabelle.
    */

    //Tabelle der Nutzerverwaltung
    function getAdminTable(){
        $users = User::all();

        $tableObject = [];
        foreach($users as $user){
            $newrow = [
                $user->id,
                $user->email,
                $user->role,
                //unformatierte hidden speicherung für korrektes dataTables sortieren
                "<span style=\"display:none;\">".$user->created_at."</span>".
                $user->created_at->format('d.m.Y')
            ];
            array_push($tableObject, $newrow);
        }
        return $tableObject;
    }

    //Tabelle der API-Verwaltung
    function getApiTable(){
        $keys = Key::all();

        $tableObject = [];
        foreach($keys as $key){
            $newrow = [
                "<span onclick=\"copyOnClick(this)\">".$key->key."</span>",
                User::find($key->owner_id)->username,
                "<span style=\"display:none;\">".$key->expiration_date."</span>".
                date('d.m.Y', strtotime($key->expiration_date))
            ];
            array_push($tableObject, $newrow);
        }
        return $tableObject;
    }

    //Tabelle der Dokumenten-Seite
    function getDocumentsTable(){
        $documents = [];
        if(Auth::user()->role == 'Admin') {
            $documents = Documents::all();   
        } else {
            $documents = Documents::where('owner_id', Auth::id())->get();
        }

        $tableObject = [];
        $authName = Auth::User()->username;
        $authID =Auth::User()->id;
        $authRole = Auth::User()->role;
    
        foreach($documents as $document){
            $newTR = [];
            $ownerID = User::find($document->owner_id)->id;
            $ownerName = User::find($document->owner_id)->username;
            $ownerRole = User::find($document->owner_id)->role;

            //Dokumenten-Name---------------
            $newTD = $document->document_name;

            array_push($newTR, $newTD);

            //Besitzer----------------------
            if($authRole == "Admin"){
                
                $newTD = $ownerName;
                $ownerRole == "Admin" ? 
                    $newTD .= "<span class=\"ms-1 bi bi-person-fill-gear\"></span>"
                :   $newTD .= "<span class=\"ms-2 bi bi-pencil-fill\"></span>";

                array_push($newTR, $newTD);
            }

            //Status---------------------------
            $status = $document->release_state;

            switch($status){
                case "Freigegeben":
                    $newTD = "<span style=\"color:green\">".$document->release_state." (".$document->id.")</span>".
                             "<span style=\"color:green\" class=\"bi bi-unlock-fill\"></span>";
                    break;

                case "Wartend":
                    $newTD = "<span style=\"color:blue\">".$document->release_state."</span>".
                             "<span style=\"color:blue\" class=\"bi bi-hourglass\"></span>";
                    break;
                
                case "Privat":
                    $newTD = "<span style=\"color:rgb(197, 14, 14)\">".$document->release_state."</span>".
                             "<span style=\"color:rgb(197, 14, 14)\" class=\"bi bi-lock-fill\"></span>";
                    break;
            }
           
            array_push($newTR, $newTD);

            //Erstelldatum-----------------------
            $newTD = "<span style=\"display:none;\">".$document->created_at."</span>";
            $newTD .= $document->created_at->format('d.m.Y');
            array_push($newTR, $newTD);

            //Aktionen-----------------------------
            $newTD = "<div class=\"row justify-content-center flex-nowrap hideAction mx-0\">";


            //Bearbeiten
            $newTD .=   "
                        <div class=\"col-auto\">
                            <form method=\"post\" action=\"documents/edit\">
                                <input type=\"hidden\" name=\"_token\" value=".csrf_token().">
                                <input type=\"hidden\" name=\"id\" value=".$document->id.">
                                <button class=\"tableButton px-2\" type=\"submit\">
                                    <span style=\"color:black\" class=\"bi bi-wrench-adjustable\"></span>
                                </button>
                            </form>
                        </div>
                        ";      
            //Freigeben
            if($authName == $ownerName AND $status == "Privat"){
                $newTD .=  "
                            <div class=\"col-auto\">
                                <button class=\"tableButton px-2\" onclick=\"release(this)\" value=".$document->id.">
                                    <span style=\"color:yellow\" class=\"bi bi-broadcast-pin\"></span>
                                </button>
                            </div>
                            ";
            }

            //Freigabe zurücknehmen
            if($authName == $ownerName AND ($status == "Freigegeben" || $status == "Wartend")){
                $newTD .=  "
                            <div class=\"col-auto\">
                                <button class=\"tableButton px-2\" onclick=\"releaseRevert(this)\" value=".$document->id.">
                                    <span style=\"color:yellow\" class=\"bi bi bi-wifi-off\"></span>
                                </button>
                            </div>
                            ";
            }

            //Freigabe Annehmen, Ablehnen
            if($status == "Wartend" AND $authRole == "Admin"){
                $newTD .=  "
                            <div class=\"col-auto pe-1\">
                                <button class=\"tableButton px-2\" onclick=\"releaseAccept(this)\" value=".$document->id.">
                                    <span style=\"color:green\" class=\"bi bi-check-lg\"></span>
                                </button>
                            </div>
                            ";
                
                $newTD .=  "
                            <div class=\"col-auto ps-1\">
                                <button class=\"tableButton px-2\" onclick=\"releaseDecline(this)\" value=".$document->id.">
                                    <span style=\"color:red\" class=\"bi bi-x-lg\"></span>
                                </button>
                            </div>
                            ";
            }

            //Löschen
            $newTD .=  "
                        <div class=\"col-auto\">
                            <button class=\"tableButton px-2\" onclick=\"deleteDocument(this)\" value=".$document->id.">
                                <span style=\"color:rgb(197, 14, 14)\" class=\"bi bi-trash3\"></span>
                            </button>
                        </div>
                        ";
        
            
            $newTD .= "</div>";

            array_push($newTR, $newTD);

            array_push($tableObject, $newTR);
        }
        
        return $tableObject;
    }

}
