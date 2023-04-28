<?php

namespace App\Http\Controllers;

use App\Models\Documents;
use App\Models\Api;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class EditorController extends Controller
{

    /**
     * @param Request $request
     * @param int $id
     * @return Response
     */

    //Funktion zum speichern von Dokumentinhalt und Namen
    function save(Request $daten)                                                                                                       
    {
        //Unterscheidung ob die Funktion nach dem Bearbeiten aufgerufen
        //oder ob ein neues Dokument erstellt wurde
        if (!empty($_REQUEST['documentContent_update'])) {                                                                              
            $documentContent = $_REQUEST['documentContent_update'];                                                                     

            $document = Documents::find($daten->input('id'));
            //Zwischenspeichern von Dokumentnamen und Dokumentinhalt
            //Nötig, falls die edit-Funktion zwar aufgerufen, aber nichts
            //verändert wurde
            $document_currentname = $document->document_name;
            $document_currentdata = $document->document_data;                                                                           
            $document->document_data = $documentContent;                                                                                
            $document->document_name = $daten->input('document_name');
            //Prüfung ob etwas verändert wurde
            //Falls ja, Freigabestatus auf "Privat" ändern
            //Schnittstelle löschen
            if ($document_currentdata != $document->document_data || $document_currentname != $daten->input('document_name')) {        
                $document->release_state = 'Privat';                                                                                    
                Api::where('id', $daten->input('id'))->delete();                                                                        
                $document->save();
            } else {
                //Sonst altes Dokument mit altem Namen wiederherstellen
                $document->document_data = $document_currentdata;
                $document->document_name = $document_currentname;
                $document->save();
            }
            return redirect('documents');
        } else {
            //Dies wird aufgerufen, falls ein neues Dokument erstellt wird
            $documentContent = $_REQUEST['documentContent'];
            //ID der aktuellen Session
            $id = Auth::id();


            $document = Documents::create([
                'owner_id' => $id,
                'document_name' => $daten->input('document_name'),
                'document_data' => $documentContent
            ]);
            return redirect('documents');
        }
    }
}
