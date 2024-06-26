<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\GameController;

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

Route::get('/', function () {
    return view('index');
});

Route::get('/avatar-editor', function () {
    return redirect(asset('AvatarEditor/index.html'));
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/generate-codes', [BattleController::class, 'showGenerateCodesForm']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/videos', [App\Http\Controllers\VideoController::class, 'show'])->name('video.show');

Route::post('/generate-codes', [BattleController::class, 'generateCodes']);

Route::get('/download-codes', [DownloadController::class, 'downloadCodes']);

Route::post('/mark-code-as-paidB', [BattleController::class, 'markCodeAsPaidB']);

