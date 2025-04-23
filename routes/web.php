<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\userController;
use App\Http\Controllers\customerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TypeaheadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/home', [TypeaheadController::class, 'index']);
Route::get('/autocompleteSearch', [TypeaheadController::class, 'autocompleteSearch'])->name('autosearch');

Route::get('/', [APIController::class, 'loginpage']);


Route::post('/addNewUser', [APIController::class, 'addNewUser'])->name('adduser');
Route::get('/registerform', [AdminController::class, 'registerform'])->name('register');
Route::get('/loginpage', [APIController::class, 'loginpage'])->name('loginpage');
Route::get('/addcust', [APIController::class, 'addcust'])->name('addcust');
Route::post('/addcustomer', [APIController::class, 'addcustomer'])->name('customer');
Route::get('/addcall', [APIController::class, 'addcall'])->name('addcall');
Route::post('/callregister', [APIController::class, 'callregister'])->name('callRegister');
Route::post('/updateregister', [APIController::class, 'updateregister'])->name('updateregister');
Route::post('/alterregister', [APIController::class, 'alterregister'])->name('alterregister');
Route::get('/custReport', [APIController::class, 'custReport'])->name('custReport');
Route::post('/CallsReport', [APIController::class, 'CallsReport'])->name('CallsReport');
Route::get('/service', [APIController::class, 'service'])->name('service');
Route::post('/serviceReport', [APIController::class, 'serviceReport'])->name('serviceReport');
Route::get('/leads', [APIController::class, 'leads'])->name('leads');
Route::post('/leadReport', [APIController::class, 'leadReport'])->name('leadReport');
Route::get('/tss', [APIController::class, 'tss'])->name('tss');
Route::post('/tssReport', [APIController::class, 'tssReport'])->name('tssReport');
Route::get('/tdl', [APIController::class, 'tdl'])->name('tdl');
Route::post('/tdlReport', [APIController::class, 'tdlReport'])->name('tdlReport');
Route::get('/UpdateCalls/{id}/', [APIController::class, 'UpdateCalls'])->name('editcalls');
Route::get('/alterCalls/{id}', [APIController::class, 'alterCalls'])->name('alter');
Route::get('/deletecalls/{id}', [APIController::class, 'deletecalls'])->name('delete');
Route::Post('homepage', [APIController::class, 'homepage'])->name('home');
Route::get('home', [APIController::class, 'home'])->name('home1');
Route::get('homelogout', [APIController::class, 'homelogout'])->name('logout');
Route::get('/ledreport', [APIController::class, 'ledreport'])->name('ledreport');
Route::post('/ledgerwisereport', [APIController::class, 'ledgerwisereport'])->name('ledgerwisereport');
Route::get('/viewhistory/{cust_id}/{billtype}', [APIController::class, 'viewhistory'])->name('viewhistory');
Route::get('/editcall/{id}', [APIController::class, 'editcall'])->name('editcall');
Route::put('/updatecall/{id}', [APIController::class, 'updatecall'])->name('updatecall');


// Route::group([  ledreport
//     'prefix'=>'/admin',
//     'as'=>'admin.',
// ],function(){
//     Route::post('/addNewUser',[AdminController::class,'addNewUser'])->name('adduser');
//     Route::get('/registerform',[AdminController::class,'registerform'])->name('register');
//     Route::get('/loginpage',[AdminController::class,'loginpage'])->name('loginpage');
//     Route::get('/addcust',[AdminController::class,'addcust'])->name('addcust');
//     Route::post('/addcustomer',[AdminController::class,'addcustomer'])->name('customer');
//     Route::get('/addcall',[AdminController::class,'addcall'])->name('addcall');
//     Route::post('/callregister',[AdminController::class,'callregister'])->name('callRegister');
//     Route::post('/updateregister',[AdminController::class,'updateregister'])->name('updateregister');
//     Route::get('/custReport',[AdminController::class,'custReport'])->name('custReport');
//     Route::post('/CallsReport',[AdminController::class,'CallsReport'])->name('CallsReport');
//     Route::get('/UpdateCalls/{id}',[AdminController::class,'UpdateCalls'])->name('editcalls');
//     Route::Post('homepage',[AdminController::class,'homepage'])->name('home');
//     Route::get('home',[AdminController::class,'home'])->name('home1');
//     Route::get('homelogout',[AdminController::class,'homelogout'])->name('logout');
// });
