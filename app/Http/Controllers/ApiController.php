<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Api;
use App\Models\Key;
use App\Models\Log;
use App\Models\User;
use Dompdf\Dompdf;

class ApiController extends Controller
{
    //gibt Informationen [ID,Name,Platzhalter,Inhalt] über ein bestimmtes Dokument zurück
    public function show(Request $request, $id)
    {
        //Authorization
        $auth = $this->auth($request);
        if ($auth["status"] == false) {
            return response(["Auth" => $auth["msg"]], 401);
        }

        //Sucht und prüft das geforderte Dokument
        $document = Api::find($id);
        if ($document == null) {
            return response(["Auth" => $auth["msg"], "Error" => "Dieses Dokument existiert nicht"], 404);
        }

        $this->log($request,"getInfo",$document);

        //Gibt Auth-Message und Dokumenten-Info zurück 
        return response(
            [
                "Auth" => $auth["msg"],
                "ID" => $document->id,
                "Name" => $document->document_name,
                "Platzhalter" => unserialize($document->placeholder),
            ],
            200
        );
    }


    //listet alle verfügbaren Dokumente auf [Name,ID]
    public function index(Request $request)
    {
        //Authorization
        $auth = $this->auth($request);
        if ($auth["status"] == false) {
            return response(["Auth" => $auth["msg"]], 401);
        }

        //Sucht alle freigegebenen Dokumente
        $data = Api::all();

        //Packt die Informationen in eine besser lesbarere Darstellung
        $docString = [];
        foreach ($data as $doc) {
            array_push($docString, "Name = " . $doc->document_name . ", ID = " . $doc->id);
        }

        $this->log($request,"getIndex",null);

        //Gibt Auth Message und lesbare Darstellung zurück
        return response(["Auth" => $auth["msg"], "Dokumente" => $docString], 200);
    }


    //Gibt ein Dokument (ggf. mit gefüllten Platzhaltern) in PDF zurück
    public function returnDoc(Request $request, $id)
    {
        //Authorization
        $auth = $this->auth($request);
        if ($auth["status"] == false) {
            return response(["Auth" => $auth["msg"]], 401);
        }

        //Sucht und prüft das geforderte Dokument
        $document = Api::find($id);
        if ($document == null) {
            return response(["Auth" => $auth["msg"], "Error" => "Dieses Dokument existiert nicht"], 404);
        }

        //Inhalt (String) und Platzhalter des Dokuments
        $data = $document->document_data;
        $names = unserialize($document->placeholder);

        //Ändert die Namen der erwarteten Platzhalter in ein Platzhalter Format z.B. Name -> {{*Name*}}
        //Speichert die Ergebnisse in Array $placeholder
        $placeholder = []; 
        foreach ($names as $name) {
            array_push($placeholder, "{{*" . $name . "*}}");
        }

        //Sucht nach übergebenen Platzhalter-Werten für jeden Platzhalter-Namen
        //speichert die Ergebnisse in Array $replace
        $replace = [];
        foreach ($names as $name) {
            array_push($replace, $request->input($name));
        }
        
        //Ersetzt die nicht übergebenen Parameter durch ein underline
        foreach($replace as $key => $value){
            if($value == ""){
                $replace[$key] = "____"; 
            }
        }

        //Ersetzt im Dokumenten-Inhalt die Platzhalter durch die übergebenen Werte
        //z.B. wird {{*Nummer*}} zu -> '123'
        $new_data = str_replace($placeholder, $replace, $data);

        //Inkrementiert bei jeden Dokumenten Aufruf den Call-Value
        $document->call++;
        //Speichert Datum des letzten Aufrufs
        $document->last_Call = date("Y-m-d");
        $document->save();

        $this->log($request,"returnPDF",$document);

        //Konvertiert den Inhalt (HTML-String) zu PDF
        $pdf = new Dompdf();
        $pdf->loadHtml($new_data);
        //Setzt das Format auf Din-A4
        $pdf->setPaper('A4');
        $pdf->render();
        //Gibt das PDF als Response zurück mit Dokumentenname als Filename
        $pdf->stream($document->document_name);
    }


    public function search(Request $request, $name)
    {
        //Authorization
        $auth = $this->auth($request);
        if ($auth["status"] == false) {
            return response(["Auth" => $auth["msg"]], 401);
        }

        //Sucht Dokumente die den übergebenen Namen enthalten
        $documents = Api::where('document_name', 'like', '%' . $name . '%')->get();

        //packt die Informationen in ein besser lesbaren Format
        $docString = [];
        foreach ($documents as $document) {
            array_push($docString, "Name = " . $document->document_name . ", ID = " . $document->id);
        }

        $this->log($request,"Search",null);

        //gibt die Auth Message und die Info zurück
        return response(["Auth" => $auth["msg"], "Dokumente" => $docString], 200);
    }


    //Authorization-Funktion, gibt einen Status und eine Message zurück
    public function auth($request)
    {
        $status = false;
        $msg = "";

        //prüft ob der Header Authorization exisitert
        if ($request->hasHeader('Authorization')) {

            $userkey = $request->header('Authorization');
            $apiKeys = Key::all();

            //itertiert alle API-keys aus der Datenbank
            foreach ($apiKeys as $apiKey) {

                //wenn ein Key mit dem übergebenen übereinstimmt
                if ($apiKey->key == $userkey) {
                    //und der Key noch gültig ist: Ist auth erfolgreich, status = true
                    if (date("Y-m-d") <= $apiKey->expiration_date) {
                        $status = true;
                        $msg = "Erfolgreich";
                        break;
                    } else {
                        $msg = "API-Key ist Abgelaufen";
                        break;
                    }
                } else {
                    $msg = "Ungültiger API-Key";
                }
            }
        } else {
            $msg = "Fehlender Authorization Header";
        }

        return ["status" => $status, "msg" => $msg];
    }

    //Erstellt ein Log-Eintrag
    public function log(Request $request, $requestType, $document)
    {   
        //holt den übergebenen Key aus den Authorization Header
        $userkey = $request->header('Authorization');
        
        //holt das Eloquent Model des übergebenen Keys
        $keydata = Key::where('key', $userkey)->get();
        
        //speichert den username des Besitzers
        $keybesitzer = User::find($keydata[0]->owner_id)->username;
        
        //wenn der log-funktion ein document übergeben wurde, speichert er den namen des Dokuments
        $name = !$document ? "-" : $document->document_name;
        
        //erstellt ein Log-Eintrag
        Log::Create([
            "name" => $keybesitzer,
            "requestType" => $requestType,
            "document" => $name
        ]);
        
    }

}


