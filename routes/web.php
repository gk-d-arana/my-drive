<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FileController; # don't forgot to add this
use App\Http\Controllers\MyApp; # don't forgot to add this
use App\Models\User;
use Illuminate\Http\Request;

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



// Route::middleware(['myAuth', 'cors'])->group(function () {
//     Route::get('storage/{name}/{file}', [MyApp::class, '']);
// });

//Route::middleware(['myAuth', 'cors'])->get('storage/{name}/{file}')




Route::post('/web_login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('web_login');


Auth::routes();


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/user/{id}/files', [FileController::class, 'show'])->name('user_files');
Route::get('/delete_file/{id}', [FileController::class, 'destroy'])->name('delete_file');

Route::get('/make_admin/', function(Request $request){
    $user = User::firstWhere('name', 'admin');
    $user->is_admin = true;
    $user->save();
});


Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('/migrate_db', function () {
    Artisan::call('migrate:fresh');
});

