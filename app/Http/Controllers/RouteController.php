<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Key;
use App\Models\Documents;
use App\Models\Api;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;


class RouteController extends Controller
{
    //Index Route
    function route_index()
    {  
        return view('login');
    }
    //Route Dokumentenverwaltung
    function route_documents()
    {
        return view('documents');
    }
    //Route Editor
    function route_editor()
    {
        return view('editor');
    }
    //Route admin
    function route_admin()
    {
        return view('admin');
    }
    //Route API-Verwaltung
    function route_adminAPI()
    {
        return view('adminAPI');
    }

    //Route API-logs
    function route_adminAPILogs()
    {
        $documents = Api::all();
        $logs = Log::all();
        return view('adminAPILogs', ['documents' => $documents, 'logs' => $logs]);
    }
    //Route Help
    function route_help()
    {
        return view('help');
    }

    public function showResetPasswordForm($token)
    {
        return view('forgetPasswordLink', ['token' => $token]);
    }

}
