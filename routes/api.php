<?php
// use App\Models\Users;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CommentsController;
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
// Route::get('/users',function(){
//     return Users::all();
// });
// Route::resource('users',UsersController::class);
// Route::get('/users/search/{login}',[UsersController::class,'search']);
// Route::resource('users',)
// Route::group(['prefix' => 'auth'], function ($router) {
//Authentication module
Route::post('auth/login', [UsersController::class,'login']);//++
Route::post('auth/register', [UsersController::class,'RegistersNewUser']);//++
Route::post('auth/logout', [UsersController::class,'logout']);//++
Route::post('auth/password-reset', [UsersController::class,'resetpassword']);//++
Route::post('auth/password-reset/{confirm_token}', [UsersController::class,'resetpasswordwithtoken']);//+
//User module
// Route::group(['middleware' => 'auth:api'], function ($router) {
Route::get('/users',[UsersController::class,'index']);//++
Route::post('/users',[UsersController::class,'register']);//++
Route::get('/users/{id}',[UsersController::class,'getid']);//++
Route::post('users/avatar',[UsersController::class,'avatar']);//+
Route::patch('users/{id}', [UsersController::class,'update']);//++
Route::delete('users/{id}', [UsersController::class,'delete']);//++
// });
Route::get('posts',[PostController::class,'getAll']);//++
Route::get('posts/{id}',[PostController::class,'getById']);//++
Route::get('posts/{id}/comments',[PostController::class,'getByIdComments']);//++
Route::post('posts/{id}/comments',[PostController::class,'createComments']);//++
Route::get('posts/{id}/categories',[PostController::class,'getAllCategoriesPost']);//++
Route::get('posts/{id}/like',[PostController::class,'getAllLikes']);//++
Route::post('posts',[PostController::class,'createNewPost']);//++
Route::post('posts/{id}/like',[PostController::class,'createNewLike']);//++
Route::patch('posts/{id}',[PostController::class,'updatePost']);//++
Route::delete('posts/{id}',[PostController::class,'deletePost']);//++
Route::delete('posts/{id}/like',[PostController::class,'deleteLikesUnderPost']);//++

//categories
Route::get('categories',[CategoriesController::class,'getAll']);//++
Route::get('categories/{id}',[CategoriesController::class,'getCategoriesById']);//++
Route::get('categories/{id}/posts',[CategoriesController::class,'getPosts']);//++
Route::post('categories',[CategoriesController::class,'createCategories']);//++
Route::patch('categories/{id}',[CategoriesController::class,'update']);//++
Route::delete('categories/{id}',[CategoriesController::class,'delete']);//++

//comments
Route::get('comments/{id}',[CommentsController::class,'getById']);//++
Route::get('comments/{id}/like',[CommentsController::class,'gelAllLikes']);//++
Route::post('comments/{id}/like',[CommentsController::class,'createNewLike']);//++
Route::patch('comments/{id}',[CommentsController::class,'update']);//++
Route::delete('comments/{id}',[CommentsController::class,'delete']);//++
Route::delete('comments/{id}/like',[CommentsController::class,'deleteLike']);//++
//админ панель
// Route::post('/register',[UsersController::class,'register']);
// Route::middleware('auth')->get('/user', function (Request $request) {
//     return $request->user();
// });
// auth()->user();
