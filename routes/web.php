<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Mail\WelcomeMail;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Jobs\ProcessWelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


// Route::get('/posts', [PostsController::class, 'index']);

Route::get('/profile', function () {
    return auth()->user()->name;
})->middleware('verified');

Route::middleware(['auth', 'verified'])->group(function(){
    
    Route::get('/', function () {
        return view('home', ['title' => 'Home Page']);
    });
    
    Route::get('/about', function () {
        return view('about', ['nama' => 'Yovi Fajar', 'title' => 'About']);
    });
    
    Route::get('/posts', function () {
        return view('posts', ['title' => 'Blog', 'posts' => Post::filter(request(['search', 'category' , 'author']))->latest()->paginate(6)->withQueryString()]);
    })->name('posts');

    Route::get('/posts/add', [PostsController::class, 'add']);

    Route::post('posts-add', [PostsController::class, 'create'])->middleware('auth');

    Route::post('/posts/create', [PostsController::class, 'create']);

    Route::get('/posts/{id}/edit', [PostsController::class, 'edit']);

    Route::patch('/posts/{id}/update', [PostsController::class, 'update']);

    // Route::get('/posts/{id}/delete', [PostsController::class, 'delete']);
    Route::delete('/posts/{id}', [CategoryController::class, 'delete'])->name('posts.destroy');
    
    Route::get('/posts/{post:slug}', function(Post $post) {
    
        return view('post', ['title' => 'Single post', 'post' => $post]);
    });

    // ROUTE CATEGORY
    Route::get('/posts/add', [CategoryController::class, 'create']);
    
    Route::get('/posts', [CategoryController::class, 'index'])->name('posts');

    Route::get('/tambah', [CategoryController::class, 'tambah']);

    Route::post('/posts/bikin', [CategoryController::class, 'bikin']);

    Route::get('/posts/{id}/ubah', [CategoryController::class, 'edit']);
    
    Route::patch('/posts/{id}/atasdate', [CategoryController::class, 'update']);

    Route::get('/posts/{id}/hapus', [CategoryController::class, 'delete']);
    
    Route::get('/authors/{user:username}', function(User $user) {
        // $posts = $user->posts->load('category', 'author');
    
        return view('posts', ['title' => count($user->posts) . ' Article by ' . $user->name, 
        'posts' => $user->posts]);
    });
    
    Route::get('/categories/{category:slug}', function(Category $category) {
        // $posts = $category->posts->load('category', 'author');
    
        return view('posts', ['title' => ' Articles in: ' . $category->name, 'posts' => $category->posts]);
    });
    
    Route::get('/contact', function () {
        return view('contact', ['title' => 'Contact']);
    });

    Route::get('/logout', [AuthController::class, 'logout']);

});

Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticating']);
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'createuser']);
});

Route::middleware('auth')->group(function(){

    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        // return redirect('/home');
        return redirect('/profile');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
    
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

Route::get('/send-welcome-mail', function() {
    // $data = [
    //     'email' => 'contoh@gmail.com',
    //     'password' => 123,
    // ];

    $users = [
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
        ['email' => 'john@email.com','password' => 123],
    ];

    foreach ($users as $user) {
        // Mail::to($user['email'])->send(new WelcomeMail($user));
        // sleep(1);
        ProcessWelcomeMail::dispatch($user)->onQueue('kirim-email');
    }
});