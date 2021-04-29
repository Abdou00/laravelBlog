<?php
    use App\Http\Controllers\Back\AdminController;
    use Illuminate\Support\Facades\Route;
    use \UniSharp\LaravelFilemanager\Lfm;
    use \App\Http\Controllers\Front\PostController;
    /*
    |--------------------------------------------------------------------------|
    | Frontend Web Routes                                                      |
    |--------------------------------------------------------------------------|
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    */
    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => 'auth'], function () { Lfm::routes(); });

    Route::name('home')->get('/', [PostController::class, 'index']);
    Route::name('category')->get('category/{category:slug}', [PostController::class, 'category']);
    Route::name('author')->get('author/{user}', [PostController::class, 'user']);
    Route::name('tag')->get('tag/{tag:slug}', [PostController::class, 'tag']);

    // J’ai créé un groupe parce qu’on aura d’autres routes avec ce préfixe.
    Route::prefix('posts')->group(function () {
        Route::name('posts.display')->get('{slug}', [PostController::class, 'show']);
        Route::name('posts.search')->get('', [PostController::class, 'search']);
    });
    /*
    |--------------------------------------------------------------------------|
    | Backend Web Routes                                                       |
    |--------------------------------------------------------------------------|
    */
    Route::prefix('admin')->group(function () {
        Route::middleware('redac')->group(function () {
            Route::name('admin')->get('/', [AdminController::class, 'index']);
        });
    });
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth'])->name('dashboard');

    require __DIR__.'/auth.php';
