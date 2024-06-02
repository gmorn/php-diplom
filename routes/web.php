<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

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


Route::get('/', function () {
    $products = Product::all();
    return view('home.home', compact('products'));
})->name('/');

Route::get('/reg', [UserController::class,'register'])->name('reg');
Route::post('/reg', [UserController::class,'registerPost'])->name('reg_post');
Route::get('/login', [UserController::class,'login'])->name('login');
Route::post('/login', [UserController::class,'loginPost'])->name('login_post');
Route::get('/logout', [UserController::class,'logout'])->name('logout');


Route::get('/product/{id}', [ProductController::class, 'show'])->name('product');
Route::get('/user/{id}', [UserController::class, 'userPage'])->name('user.page');

Route::get('/user/{id}/reviews', [UserController::class, 'userReviewsPage'])->name('user_page_reviews');
Route::get('/user/{id}/products', [UserController::class, 'userProductsPage'])->name('user_page_products');

Route::middleware(['auth.user'])->group(function () {
    Route::get('/create_product', [ProductController::class, 'createProduct'])->name('create_product');
    Route::post('/create_product', [ProductController::class, 'createProductPost'])->name('create_product_post');
    Route::delete('/product/{id}', [ProductController::class, 'delete'])->name('product_delete');
    Route::get('account/products', [UserController::class,'userProduct'])->name('user_products');
    Route::get('/product/{id}/edit', [ProductController::class, 'edit'])->name('product_edit');
    Route::put('/product/{id}', [ProductController::class, 'update'])->name('product_update');
    Route::post('/user/upload-avatar', [UserController::class, 'uploadAvatar'])->name('user_upload_avatar');
    Route::get('/user/settings/{user}', [UserController::class, 'settings'])->name('settings');
    Route::post('/user/update', [UserController::class, 'update'])->name('user_update');
    Route::get('/chat/{id?}', [ChatController::class, 'chat'])->name('chat');
    Route::post('/create-chat/{userId}', [ChatController::class, 'createChat'])->name('chat_create');
    Route::post('/message/store', [MessageController::class, 'store'])->name('message.store');
    Route::get('/get-messages', [MessageController::class, 'getMessages'])->name('get.messages');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});
