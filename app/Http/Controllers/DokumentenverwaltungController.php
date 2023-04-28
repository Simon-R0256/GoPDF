<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Documents;
use App\Models\User;
use App\Models\Api;

class DokumentenverwaltungController extends Controller
{
    //Funktion zum Bearbeiten eines Dokuments
    //Datenbankabfrage für den Dokumenteninhalt
    //Datenbankabfrage für das gesamte Dokument
    function document_edit(Request $daten)
    {
        $document_data = Documents::find($daten->input('id'))->document_data;
        $document = Documents::find($daten->input('id'));
        return view('editor', ['document_data' => $document_data], ['document' => $document]);
    }
    //Funktion zum Löschen von Dokumenten
    //durch das Löschen vom Dokument wird auch die entsprechende Schnittstelle über die Migration gelöscht
    function document_delete(Request $daten)
    {
        Documents::find($daten->input('id'))->delete();
        return response([""], 200);
    }
    //Funktion zur Erstellung einer Freigabeanfrage
    //Rolle des Nutzers, da Funktion je nach Rolle etwas anderes macht
    //Admins geben ihre Dokumente direkt frei, ohne eine Anfrage zu stellen
    //Macht das Dokument über /api erreichbar
    //Redakteure müssen auf eine Freigabe warten
    function document_release_create(Request $daten)
    {
        $document = Documents::find($daten->input('id'));
        $role = User::find($document->owner_id)->role;

        if ($role == 'Admin') {
            $document->release_state = 'Freigegeben';
            $this->release($document);
        }

        if ($role == 'Redakteur') {
            $document->release_state = 'Wartend';
        }

        $document->save();
        return response([""], 200);
    }
    //Funktion zum Annehmen von Freigabeanfragen
    //Freigabestatus wird auf "Freigegeben" geändert
    //Schnittstellenerstellung
    function document_release_accept(Request $daten)
    {
        $document = Documents::find($daten->input('id'));
        $document->release_state = 'Freigegeben';
        $this->release($document);
        $document->save();
        return response([""], 200);
    }
    //Funktion zum Ablehnen von Freigabeanfragen
    //Freigabestatus wird wieder auf "Privat" geändert
    function document_release_decline(Request $daten)
    {
        $document = Documents::find($daten->input('id'));
        $document->release_state = 'Privat';
        $document->save();
        return response([""], 200);
    }
    //Funktion zur Erstellung der Schnittstelle
    //Funktionsaufruf zum erhalten der Platzhalter
    //Umwandlung des Platzhalter-Arrays in eine Byte-Darstellung zur Datenbankspeicherung
    function release($document)
    {
        $placeholder = $this->getPlaceHolder($document->document_data, true);
        Api::create([
            'id' => $document->id,
            'document_name' => $document->document_name,
            'document_data' => $document->document_data,
            'placeholder' => serialize($placeholder)
        ]);
        return response([""], 200);
    }
    //Funktion um die Freigabe wieder rückgängig zu machen
    function document_release_revert(Request $daten)
    {
        $document = Documents::find($daten->input('id'));

        if ($document->release_state == 'Freigegeben') {
            Api::find($daten->input('id'))->delete();
        }

        $document->release_state = 'Privat';
        $document->save();
        return response([""], 200);
    }
    //Funktion zum Scannen des Dokuments nach Platzhaltern
    //Index 1 und 2 ist der String-Index des ersten "{{*" und "*}}*, sonst false
    public function getPlaceHolder($data_string, $format)
    {

        $search = true;
        $placeholders = [];

        while ($search) {
            $search = false;
            $index1 = strpos($data_string, "{{*");
            $index2 = strpos($data_string, "*}}");

            if ($index1 !== false && $index2 !== false) {                                                   //True wenn eine Kombination aus "{{*" und "*}}" gefunden wurde
                array_push($placeholders, substr($data_string, $index1, $index2 - $index1 + 3));            //fügt das gefundene "{{*x*}}" dem Platzhalter Array hinzu
                $data_string = substr($data_string, $index2 + 3);                                           //trennt den $data_string am Ende des Platzhalters ab 
                $search = true;                                                                             //gleiche Operation mit dem restlichen $data_string nochmal bis kein Platzhalter mehr gefunden wird
            }
        }

        if ($format == true) {                                                                              //Hier werden ggf. die Platzhalter-Kennzeichnung "{{**}}" entfernt 
            foreach ($placeholders as $key => $placeholder) {
                $placeholders[$key] = substr($placeholder, 3, strlen($placeholder) - 6);
            }
        }
        $placeholders = array_unique($placeholders);                                                        //Alle doppelten Platzhalter werden aus dem Array entfernt

        $newplaceholders = [];
        foreach ($placeholders as $placeholder) {                                                             //Entfernt die Key-Values aus dem Array (Für die Ausgabe in API)
            array_push($newplaceholders, $placeholder);
        }

        return $newplaceholders;
    }
}
