<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MyApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [MyApp::class, 'register']);
Route::post('login', [MyApp::class, 'login']);



Route::middleware(['myAuth', 'cors'])->group(function () {
    Route::get('my_files', [MyApp::class, 'my_files']);
    Route::post('upload_file', [MyApp::class, 'upload_file']);
});


//
// <script>
//     const toBase64 = file => new Promise((resolve, reject) => {
//         const reader = new FileReader();
//         reader.readAsDataURL(file);
//         reader.onload = () => resolve(reader.result);
//         reader.onerror = error => reject(error);
//     });
//     let data = JSON.stringify({
//         'file_base64' : toBase64()
//     })
//     fetch('/api/upload_file', {

//         method: 'POST',
//         headers: {
//             "Authorization": "Bearer 16|pobUD1wgdbdJcsHfcTHo5WR61G5XJZ8nJV0DCVKs"
//         },
//         body: data
//     })
// </script>
