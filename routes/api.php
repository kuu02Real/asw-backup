<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiAuthenticate;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(ApiAuthenticate::class)->group(function () {
    Route::get('/posts/subscribed',[ApiController::class, 'postsSubscribed']);
    Route::post('/posts', [ApiController::class, 'newPost']);
    Route::delete('/posts/{post_id}', [ApiController::class, 'deletePost']);
    Route::put('/posts/{post_id}', [ApiController::class, 'updatePost']);
    Route::post('/posts/{post_id}/like', [ApiController::class, 'likePost']);
    Route::post('/posts/{post_id}/dislike', [ApiController::class, 'dislikePost']);
    Route::post('/posts/{post_id}/unlike', [ApiController::class, 'unlikePost']);
    Route::post('/posts/{post_id}/save', [ApiController::class, 'savePost']);
    Route::post('/posts/{post_id}/unsave', [ApiController::class, 'unsavePost']);


    Route::post('/comments', [ApiController::class, 'newComment']);
    Route::delete('/comments/{comment_id}', [ApiController::class, 'deleteComment']);
    Route::put('/comments/{comment_id}', [ApiController::class, 'updateComment']);
    Route::post('/comments/{comment_id}/like', [ApiController::class, 'likeComment']);
    Route::post('/comments/{comment_id}/dislike', [ApiController::class, 'dislikeComment']);
    Route::post('/comments/{comment_id}/unlike', [ApiController::class, 'unlikeComment']);
    Route::post('/comments/{comment_id}/save', [ApiController::class, 'saveComment']);
    Route::post('/comments/{comment_id}/unsave', [ApiController::class, 'unsaveComment']);


    Route::get('/user',[ApiController::class, 'logged_user']);//Necesita authentificacio per veure el usuari
    Route::post('/user/edit/info', [ApiController::class, 'editUserInfo']); //Necesita authentificacio per editar el usuari
    Route::post('/user/edit/avatar', [ApiController::class, 'editUserAvatar']);
    Route::post('/user/edit/banner', [ApiController::class, 'editUserBanner']);
    Route::get('/user/savedPosts', [ApiController::class, 'savedPosts']);
    Route::get('/user/savedComments', [ApiController::class, 'savedComments']);


    Route::post('/communities/subscribe/{idComm}', [ApiController::class, 'communitySubscribe']);
    Route::post('/communities/unsubscribe/{idComm}', [ApiController::class, 'communityUnsubscribe']);
    Route::get('/communities/subscribed',[ApiController::class, 'subscribedCommunities']);
});


Route::get('/posts',[ApiController::class, 'posts']);
Route::get('/posts/{post_id}',[ApiController::class, 'post']);
Route::get('/posts/{post_id}/comments',[ApiController::class, 'postComments']);

Route::get('/user/{user_id}',[ApiController::class, 'user']);
Route::get('/user/posts/{user_id}',[ApiController::class, 'userPosts']);
Route::get('/user/comments/{user_id}',[ApiController::class, 'userComments']);
//Route::get('/users',[ApiController::class, 'users']); //per privacitat no fare aquests dos
//Route::get('/users/{user_id}',[ApiController::class, 'user']);

Route::get('/cercador/posts/{cerca}', [ApiController::class, 'cercaPosts']);
Route::get('/cercador/comments/{cerca}', [ApiController::class, 'cercaComments']);

Route::get('/communities',[ApiController::class, 'communities']);
Route::get('/communities/{idComm}/posts',[ApiController::class, 'postsFromCommunity']);
Route::get('/communities/{idComm}/comments',[ApiController::class, 'commentsFromCommunity']);
Route::post('/communities', [ApiController::class, 'newCommunity']);

Route::get('/communities/{community_id}',[ApiController::class, 'community']);

Route::get('/comments',[ApiController::class, 'comments']);
Route::get('/comments/{comment_id}',[ApiController::class, 'comment']);
Route::get('/comments/{comment_id}/replies',[ApiController::class, 'commentReplies']);
