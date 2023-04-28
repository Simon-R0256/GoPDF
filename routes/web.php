<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\DokumentenverwaltungController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Index Route
Route::get('/', [RouteController::class, "route_index"])->name('/');                                                    


/*Routes für den Zugriff auf die Public Views 
Middleware Auth um sicherzugehen, dass nur eingeloggte Nutzer auf die Views zugreifen können*/
Route::group(['middleware' => 'auth'], function () {                                                                                            
    Route::get('/documents', [RouteController::class, "route_documents"]);                                              
    Route::get('/editor', [RouteController::class, "route_editor"]);                                                    
});


/*Routes für den Zugriff auf die Admin Views 
isadmin zur Authentifizierung eines Admins*/
Route::group(['middleware' => ['isadmin', 'auth']], function () {                                                       
    Route::get('/admin/api', [RouteController::class, "route_adminAPI"]);                                               
    Route::get('/admin', [RouteController::class, "route_admin"]);
    Route::get('/admin/api/logs', [RouteController::class, "route_adminAPILogs"]);
});

//Ungeschützte Routes
Route::get('/help', [RouteController::class, "route_help"]);                                                            

//Routes für /admin
Route::post('admin/user_create', [AdminPanelController::class, "user_create"]);                                         
Route::post('admin/user_delete', [AdminPanelController::class, "user_delete"]);


//Routes für /admin/API
Route::post('admin/key_create', [AdminPanelController::class, "key_create"]);                                           
Route::post('admin/key_delete', [AdminPanelController::class, "key_delete"]);


//Routes für /editor
Route::post('editor/save', [EditorController::class, "save"]);                                                         


//Routes für /documents
Route::post('documents/edit', [DokumentenverwaltungController::class, "document_edit"]);                               
Route::post('documents/delete', [DokumentenverwaltungController::class, "document_delete"]);
Route::post('documents/release', [DokumentenverwaltungController::class, "document_release_create"]);
Route::post('documents/accept', [DokumentenverwaltungController::class, "document_release_accept"]);
Route::post('documents/decline', [DokumentenverwaltungController::class, "document_release_decline"]);
Route::post('documents/revert', [DokumentenverwaltungController::class, "document_release_revert"]);

//Routes für die Profilseite
Route::post('profile/changePassword', [ProfileController::class, 'changePassword']);
Route::post('profile/showKey', [ProfileController::class, 'showKey']);
Route::post('profile/getKey', [ProfileController::class, 'getKey']);

//Routes für den TableController
Route::get('table/getAdminTable', [TableController::class, 'getAdminTable']);
Route::get('table/getApiTable', [TableController::class, 'getApiTable']);
Route::get('table/getDocumentsTable', [TableController::class, 'getDocumentsTable']);

//Login
Route::post('authenticate', [LoginController::class, "authenticate"]);                                                 

//Logout
Route::get('logout', [LogoutController::class, "logout"]);                                                              

//Routes für Passwort-Wiederherstellen
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [RouteController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
