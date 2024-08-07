<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\FriendsRequests;
use App\Http\Controllers\clothesController;
use App\Http\Controllers\objectscene;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ConsumerCodeController;
use App\Http\Controllers\BattleController;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Database\Console\Migrations\ResetCommand;

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
Route::post('/Register', [AuthController::class,'Register']);
Route::post('/Login', [AuthController::class,'Login']);
Route::post('/Members', [AuthController::class,'Members']);
Route::post('/FriendRequest', [FriendsRequests::class,'Register']);
Route::post('/password/email', [ForgotPasswordController::class,'sendResetLinkEmail']);

Route::post('/Registerevent', [EventsController::class, 'CreateEvent']);
Route::post('/ShowEvents', [EventsController::class, 'show']);
Route::post('/CreateCodes', [EventsController::class, 'CreatedCodes']);
Route::post('/ShowCodes', [EventsController::class, 'showCode']);
Route::post('/ShowCodeEvent', [EventsController::class, 'showEventCodes']);
Route::post('/UpdateEventUrl', [EventsController::class, 'updateUrl']);

Route::post('/createwear', [clothesController::class,'create']);
Route::post('/createdcodesclothes', [clothesController::class,'CreatedCodeclothes']);
Route::post('/buyclothes', [clothesController::class,'buyClothes']);
Route::post('/showcodesclothes', [clothesController::class,'show']);
Route::post('/showclothes', [clothesController::class,'showClothes']);

Route::post('/createobject', [objectscene::class,'create']);
Route::post('/createdcodesobject', [objectscene::class,'CreatedCodeclothes']);
Route::post('/buyobject', [objectscene::class,'buyClothes']);
Route::post('/showcodesobject', [objectscene::class,'show']);
Route::post('/showobject', [objectscene::class,'showClothes']);
Route::post('/showobjectscena', [objectscene::class,'showObjects']);
Route::post('/registerImagen', [objectscene::class,'registerImagen']);

Route::post('/saveString', [VideoController::class,'saveString']);
Route::post('/updatevideo', [VideoController::class,'update']);
Route::post('/searchvideo', [VideoController::class,'search']);

Route::post('/saveGame', [GameController::class, 'store']);
Route::post('/ScoreTop', [GameController::class, 'getTopScores']);
Route::post('/ScoreName', [GameController::class, 'getScoresByUserName']);

Route::post('/saveConsumerCode', [ConsumerCodeController::class, 'store']);

Route::post('/generate-codes', [BattleController::class, 'generateUniqueCodes']);
Route::post('/mark-as-used', [BattleController::class, 'markCodeAsUsed']);
Route::post('/mark-as-paid', [BattleController::class, 'markCodeAsPaid']);
Route::post('/is-code-paid', [BattleController::class, 'isCodePaid']);

Route::post('/listBattle', [GameController::class, 'getGameRecordsByName']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
