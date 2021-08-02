<?php

use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SessiongameController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessiongameUserController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\RankingController;
use App\Http\Controllers\GoodieController;

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


Route::get('/',[ArticleController::class, 'home'])->name('home');

Route::get('/deconnexion',[ConnexionController::class, 'logout'])->middleware('auth')->name('disconnection');

Route::get('presentation', function () {
    return view('presentation');
})->name('presentation');



Route::get('articles',[ArticleController::class, 'index'])->name('articles.index');
Route::get('articles/creer',[ArticleController::class, 'create'])->middleware('auth')->name('articles.create');
Route::post('articles/',[ArticleController::class, 'store'])->middleware('auth')->name('articles.store');
Route::get('articles/{article}',[ArticleController::class, 'show'])->name('articles.show');
Route::get('articles/{article}/editer',[ArticleController::class, 'edit'])->middleware('auth')->name('articles.edit');
Route::put('articles/{article}',[ArticleController::class, 'update'])->middleware('auth')->name('articles.update');
Route::delete('articles/{article}',[ArticleController::class, 'destroy'])->middleware('auth')->name('articles.destroy');

Route::get('classement', [RankingController::class, 'ranking'])->name('ranking');

Route::get('inscription_sessions', [SessiongameUserController::class, 'create'])->middleware('auth')->name('sessiongameusers.create');
Route::post('inscription_sessions',[SessiongameUserController::class, 'store'])->middleware('auth')->name('sessiongameusers.store');


Route::get('sessions',[SessiongameController::class, 'index'])->middleware('auth')->name('sessiongames.index');
Route::get('sessions/creer',[SessiongameController::class, 'create'])->middleware('auth')->name('sessiongames.create');
Route::post('sessions/',[SessiongameController::class, 'store'])->middleware('auth')->name('sessiongames.store');
Route::get('sessions/{sessiongame}',[SessiongameController::class, 'show'])->middleware('auth')->name('sessiongames.show');
Route::get('sessions/{sessiongame}/editer',[SessiongameController::class, 'edit'])->middleware('auth')->name('sessiongames.edit');
Route::put('sessions/{sessiongame}',[SessiongameController::class, 'update'])->middleware('auth')->name('sessiongames.update');
Route::delete('sessions/{sessiongame}',[SessiongameController::class, 'destroy'])->middleware('auth')->name('sessiongames.destroy');


Route::get('sessions/{sessiongame}/defis/creer',[ChallengeController::class, 'create'])->middleware('auth')->name('sessiongames.challenges.create');
Route::post('sessions/{sessiongame}/defis',[ChallengeController::class, 'store'])->middleware('auth')->name('sessiongames.challenges.store');
Route::get('defis/{challenge}',[ChallengeController::class, 'show'])->middleware('auth')->name('challenges.show');
Route::get('defis/{challenge}/editer',[ChallengeController::class, 'edit'])->middleware('auth')->name('challenges.edit');
Route::put('defis/{challenge}',[ChallengeController::class, 'update'])->middleware('auth')->name('challenges.update');
Route::delete('defis/{challenge}',[ChallengeController::class, 'destroy'])->middleware('auth')->name('challenges.destroy');

Route::delete('images/{image}',[ChallengeController::class, 'destroyImage'])->middleware('auth')->name('images.destroy');

Route::post('defis/{challenge}/posts',[PostController::class, 'store'])->middleware('auth')->name('challenges.posts.store');
Route::delete('posts/{post}',[PostController::class, 'destroy'])->middleware('auth')->name('posts.destroy');
Route::get('posts/valides',[PostController::class, 'indexValidated'])->middleware('auth')->name('posts.indexValidated');
Route::get('posts/en-attente',[PostController::class, 'indexPending'])->middleware('auth')->name('posts.indexPending');
Route::put('posts/{post}',[PostController::class, 'update'])->middleware('auth')->name('posts.update');



Route::get('utilisateurs/utilisateurs',[UserController::class, 'indexUsers'])->middleware('auth')->name('users.indexUsers');
Route::get('utilisateurs/admin-defis',[UserController::class, 'indexAdminChallenge'])->middleware('auth')->name('users.indexAdminChallenge');
Route::get('utilisateurs/super-admin',[UserController::class, 'indexSuperAdmin'])->middleware('auth')->name('users.indexSuperAdmin');
Route::get('utilisateurs/creer',[UserController::class, 'create'])->middleware('auth')->name('users.create');
Route::post('utilisateurs/nouveau',[UserController::class, 'storeNewUser'])->middleware('auth')->name('users.storeNewUser');
Route::post('utilisateurs',[UserController::class, 'store'])->middleware('auth')->name('users.store');
Route::get('utilisateurs/{user}/editer',[UserController::class, 'edit'])->middleware('auth')->name('users.edit');
Route::put('utilisateurs/{user}',[UserController::class, 'update'])->middleware('auth')->name('users.update');
Route::put('utilisateurs/{user}/role',[UserController::class, 'updateRole'])->middleware('auth')->name('users.updateRole');
Route::delete('utilisateurs/{user}',[UserController::class, 'destroy'])->middleware('auth')->name('users.destroy');


Route::get('/tirage_gagnant',[RankingController::class, 'winnerDraw'])->middleware('auth')->name('winner_draw');

Route::get('goodies',[GoodieController::class, 'index'])->middleware('auth')->name('goodies.index');
Route::post('goodies/',[GoodieController::class, 'store'])->middleware('auth')->name('goodies.store');
Route::put('goodies/{goodie}',[GoodieController::class, 'update'])->middleware('auth')->name('goodies.update');
Route::delete('goodies/{goodie}',[GoodieController::class, 'destroy'])->middleware('auth')->name('goodies.destroy');