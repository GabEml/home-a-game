<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\GoodieController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\RankingController;
use App\Http\Controllers\Api\ChallengeController;
use App\Http\Controllers\Api\SessiongameController;
use App\Http\Controllers\Api\SessiongameUserController;
use App\Http\Controllers\Auth\RegisterController;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/', [ArticleController::class, 'home']);
Route::get('articles', [ArticleController::class, 'index']);
Route::get('articles/{article}', [ArticleController::class, 'show']);

Route::get('ranking', [RankingController::class, 'ranking']);

Route::post('register', [UserController::class, 'store']);

Route::post('login',[UserController::class, 'login']);

Route::post('logout',[UserController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function(){
    
    Route::post('articles/',[ArticleController::class, 'store']);
    Route::put('articles/{article}',[ArticleController::class, 'update']);
    Route::delete('articles/{article}',[ArticleController::class, 'destroy']);

    Route::get('winner_draw', [RankingController::class, 'winnerDraw']);

    Route::post('sessions_register', [SessiongameUserController::class, 'store']);

    Route::get('sessions/users', [SessiongameController::class, 'indexUser']);
    Route::get('sessions', [SessiongameController::class, 'index']);
    Route::post('sessions/', [SessiongameController::class, 'store']);
    Route::get('sessions/{sessiongame}', [SessiongameController::class, 'show']);
    Route::put('sessions/{sessiongame}', [SessiongameController::class, 'update']);
    Route::delete('sessions/{sessiongame}', [SessiongameController::class, 'destroy']);

    Route::post('sessions/{sessiongame}/challenges', [ChallengeController::class, 'store']);
    Route::get('challenges/{challenge}', [ChallengeController::class, 'show']);
    Route::put('challenges/{challenge}', [ChallengeController::class, 'update']);
    Route::delete('challenges/{challenge}', [ChallengeController::class, 'destroy']);

    Route::delete('images/{image}', [ChallengeController::class, 'destroyImage']);

    Route::post('challenges/{challenge}/posts', [PostController::class, 'store']);
    Route::delete('posts/{post}', [PostController::class, 'destroy']);
    Route::get('posts/valid', [PostController::class, 'indexValidated']);
    Route::get('posts/pending', [PostController::class, 'indexPending']);
    Route::put('posts/{post}', [PostController::class, 'update']);
    //Route::get('posts/{post}',[PostdefiController::class, 'show']);

    // Route::get('utilisateurs/utilisateurs', [UserController::class, 'indexUsers']);
    Route::get('users/admin-defis', [UserController::class, 'indexAdminChallenge']);
    Route::get('users/super-admin', [UserController::class, 'indexSuperAdmin']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::post('users/new', [UserController::class, 'storeNewUser']);
    Route::put('users/{user}', [UserController::class, 'updateUser']);
    Route::put('profil/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroyUser']);
    Route::delete('profil/{user}', [UserController::class, 'destroy']);

    Route::get('goodies', [GoodieController::class, 'index']);
    Route::get('goodies/{goodie}', [GoodieController::class, 'show']);
    Route::post('goodies/', [GoodieController::class, 'store']);
    Route::put('goodies/{goodie}', [GoodieController::class, 'update']);
    Route::delete('goodies/{goodie}', [GoodieController::class, 'destroy']);
});

Route::middleware('cors')->group(function () {
    Route::get('allutilisateurs', [UserController::class, 'indexUsers']);
    Route::post('authenticate', [LoginController::class, 'authenticate']);
});