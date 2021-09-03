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
Route::get('articles/creer',[ArticleController::class, 'create'])->middleware('auth','verified')->name('articles.create');
Route::post('articles/',[ArticleController::class, 'store'])->middleware('auth','verified')->name('articles.store');
Route::get('articles/{article}',[ArticleController::class, 'show'])->name('articles.show');
Route::get('articles/{article}/editer',[ArticleController::class, 'edit'])->middleware('auth','verified')->name('articles.edit');
Route::put('articles/{article}',[ArticleController::class, 'update'])->middleware('auth','verified')->name('articles.update');
Route::delete('articles/{article}',[ArticleController::class, 'destroy'])->middleware('auth','verified')->name('articles.destroy');

Route::get('classement', [RankingController::class, 'ranking'])->name('ranking');
Route::get('classement/OTR', [RankingController::class, 'rankingOTR'])->name('rankingOTR');
Route::get('classement/OTR/{sessiongame}', [RankingController::class, 'rankingOTRPrevious'])->name('rankingOTR.previous');
Route::get('classement/{sessiongame}', [RankingController::class, 'rankingPrevious'])->name('ranking.previous');

Route::get('inscription_sessions', [SessiongameUserController::class, 'create'])->middleware('auth','verified')->name('sessiongameusers.create');
Route::post('inscription_sessions',[SessiongameUserController::class, 'store'])->middleware('auth','verified')->name('sessiongameusers.store');


Route::get('sessions',[SessiongameController::class, 'index'])->middleware('auth','verified')->name('sessiongames.index');
Route::get('sessions/creer',[SessiongameController::class, 'create'])->middleware('auth','verified')->name('sessiongames.create');
Route::post('sessions/',[SessiongameController::class, 'store'])->middleware('auth','verified')->name('sessiongames.store');
Route::get('sessions/{sessiongame}',[SessiongameController::class, 'show'])->middleware('auth','verified')->name('sessiongames.show');
Route::get('sessions/{sessiongame}/editer',[SessiongameController::class, 'edit'])->middleware('auth','verified')->name('sessiongames.edit');
Route::put('sessions/{sessiongame}',[SessiongameController::class, 'update'])->middleware('auth','verified')->name('sessiongames.update');
Route::delete('sessions/{sessiongame}',[SessiongameController::class, 'destroy'])->middleware('auth','verified')->name('sessiongames.destroy');


Route::get('sessions/{sessiongame}/defis/creer',[ChallengeController::class, 'create'])->middleware('auth','verified')->name('sessiongames.challenges.create');
Route::post('sessions/{sessiongame}/defis',[ChallengeController::class, 'store'])->middleware('auth','verified')->name('sessiongames.challenges.store');
Route::get('defis/{challenge}',[ChallengeController::class, 'show'])->middleware('auth','verified')->name('challenges.show');
Route::get('defis/{challenge}/editer',[ChallengeController::class, 'edit'])->middleware('auth','verified')->name('challenges.edit');
Route::put('defis/{challenge}',[ChallengeController::class, 'update'])->middleware('auth','verified')->name('challenges.update');
Route::delete('defis/{challenge}',[ChallengeController::class, 'destroy'])->middleware('auth','verified')->name('challenges.destroy');

Route::delete('images/{image}',[ChallengeController::class, 'destroyImage'])->middleware('auth','verified')->name('images.destroy');

Route::post('defis/{challenge}/posts',[PostController::class, 'store'])->middleware('auth','verified')->name('challenges.posts.store');
Route::delete('posts/{post}',[PostController::class, 'destroy'])->middleware('auth','verified')->name('posts.destroy');
Route::get('posts/valides',[PostController::class, 'indexValidated'])->middleware('auth','verified')->name('posts.indexValidated');
Route::get('posts/en-attente',[PostController::class, 'indexPending'])->middleware('auth','verified')->name('posts.indexPending');
Route::put('posts/{post}',[PostController::class, 'update'])->middleware('auth','verified')->name('posts.update');
Route::get('posts/en-attente/search',[PostController::class, 'search'])->middleware('auth','verified')->name('posts.search');


Route::get('utilisateurs/utilisateurs',[UserController::class, 'indexUsers'])->middleware('auth','verified')->name('users.indexUsers');
Route::get('utilisateurs/admin-defis',[UserController::class, 'indexAdminChallenge'])->middleware('auth','verified')->name('users.indexAdminChallenge');
Route::get('utilisateurs/super-admin',[UserController::class, 'indexSuperAdmin'])->middleware('auth','verified')->name('users.indexSuperAdmin');
Route::get('utilisateurs/creer',[UserController::class, 'create'])->middleware('auth','verified')->name('users.create');
Route::post('utilisateurs/nouveau',[UserController::class, 'storeNewUser'])->middleware('auth','verified')->name('users.storeNewUser');
Route::post('utilisateurs',[UserController::class, 'store'])->middleware('auth','verified')->name('users.store');
Route::get('utilisateurs/{user}/editer',[UserController::class, 'edit'])->middleware('auth','verified')->name('users.edit');
Route::put('utilisateurs/{user}',[UserController::class, 'update'])->middleware('auth','verified')->name('users.update');
Route::put('utilisateurs/{user}/role',[UserController::class, 'updateRole'])->middleware('auth','verified')->name('users.updateRole');
Route::post('utilisateurs/{user}/sessiongames',[UserController::class, 'storeSessiongame'])->middleware('auth','verified')->name('users.storeSessiongame');
Route::delete('utilisateurs/{sessiongameUser}/sessions',[UserController::class, 'deleteSessiongameUser'])->middleware('auth','verified')->name('users.destroySessiongameUser');
Route::delete('utilisateurs/{user}',[UserController::class, 'destroy'])->middleware('auth','verified')->name('users.destroy');
Route::get('utilisateurs/utilisateurs/search',[UserController::class, 'search'])->middleware('auth','verified')->name('users.search');



Route::get('/tirage_gagnant/create',[RankingController::class, 'create'])->middleware('auth','verified')->name('ranking.create');
Route::post('/tirage_gagnant',[RankingController::class, 'store'])->middleware('auth','verified')->name('ranking.store');

Route::get('goodies',[GoodieController::class, 'index'])->middleware('auth','verified')->name('goodies.index');
Route::get('goodies/creer',[GoodieController::class, 'create'])->middleware('auth','verified')->name('goodies.create');
Route::post('goodies/',[GoodieController::class, 'store'])->middleware('auth','verified')->name('goodies.store');
Route::get('goodies/{goodie}/editer',[GoodieController::class, 'edit'])->middleware('auth','verified')->name('goodies.edit');
Route::put('goodies/{goodie}',[GoodieController::class, 'update'])->middleware('auth','verified')->name('goodies.update');
Route::delete('goodies/{goodie}',[GoodieController::class, 'destroy'])->middleware('auth','verified')->name('goodies.destroy');