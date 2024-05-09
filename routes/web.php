<?php

use App\Http\Controllers\PostController;
use App\Livewire\CreatePost;
use Illuminate\Http\Request;
use App\Livewire\Posts\EditPost;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CercaControler;


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

//Route::get('/', function () {
//    return view('livewire.home-page', ['posts1' => \App\Models\Post::all()])->layout('components.layouts.app');
//})->name('home');

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/sortSubscribed', [PostController::class, 'sortSubscribed'])->name('home.subscribed');
Route::get('/crear-post', CreatePost::class);
Route::post('/post/save/{post_id}', [PostController::class, 'save'])->name('save');
Route::get('/post/edit/{post_id}', EditPost::class)->name('edit');
Route::post('/post/delete/{post_id}', [PostController::class, 'destroy'])->name('delete');

Route::get('/post/{post_id}', [PostController::class, 'show'])->name('post');
Route::get('/post/comments/{post_id}', [CommentController::class, 'index'])->name('indexcomments');
Route::post('/like/{post_id}', [PostController::class, 'like'])->name('like');
Route::post('/dislike/{post_id}', [PostController::class, 'disLike'])->name('disLike');


Route::post('/comment/save/{comment_id}', [CommentController::class, 'save'])->name('saveComment');
Route::post('/likeComment/{comment_id}', [CommentController::class, 'like'])->name('likeComment');
Route::post('/dislikeComment/{comment_id}', [CommentController::class, 'dislike'])->name('dislikeComment');

//middleware: nomes els usuaris autenticats poden fer aquestes rutes
Route::group(['middleware' => 'auth'], function() {
    Route::get('/comments/create', [CommentController::class, 'create'])->name('comments.create');
    Route::post('/comments/store', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/edit/{comment_id}', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment_id}', [CommentController::class, 'update'])->name('comments.update');

    Route::put('/comments/delete/{comment_id}', [CommentController::class, 'destroy'])->name('comments.delete');
});

Route::get('/communities/subscribed', [CommunityController::class, 'listSubscribed'])->name('community.listsubscribed');

Route::get('/communities', [CommunityController::class, 'index'])->name('community.index');

Route::get('/communities/create', [CommunityController::class, 'create'])->name('community.create');

Route::get('/communities/{idComm}', [CommunityController::class, 'show'])->name('community.show');

Route::get('/communities/{idComm}/comments', [CommunityController::class, 'showComments'])->name('community.showComments');

Route::post('/communities', [CommunityController::class, 'store'])->name('community.store');


Route::get('/communities/subscribe/{idComm}', [CommunityController::class, 'subscribe'])->name('community.subscribe')->middleware('auth');


Route::get('/cerca', [CercaControler::class, 'cerca'])->name('cercador');


Route::get('/cerca/p/{busqueda}', [CercaControler::class, 'cercaposts'])->name('cercaposts');

Route::get('/cerca/c/{busqueda}', [CercaControler::class, 'cercacoments'])->name('cercacoments');

Route::get('login', [LoginController::class, 'login'])->name('login');

Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('login-google', [LoginController::class, 'login_google'])->name('login-google');

Route::get('/google-callback', [LoginController::class, 'google_callback']);


Route::get('/dashboard', function(){
    return redirect()->route('profile');
});

Route::get('/dashboard/posts', [ProfileController::class, 'posts'])->name('profile');

Route::get('/dashboard/comentaris', [ProfileController::class, 'comentaris'])->name('profile-comentaris');

Route::get('/dashboard/desats', [ProfileController::class, 'desats'])->name('profile-desats');

Route::get('editarperfil', [ProfileController::class, 'editar'])->name('profile-edit');

Route::patch('updateperfil', [ProfileController::class, 'update'])->name('profile-update');

Route::get('/u/{user_id}/', function($user_id){
    return redirect('/u/' . $user_id . '/posts');
})->name('user-profil');

Route::get('/u/{user_id}/{type}', [ProfileController::class, 'usuari'])->name('user-profile');



