<?php
    use App\Http\Controllers\Back\AdminController;
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

Route::get('/', function () { return view('welcome');})->name('home');
Route::get('/logout')->name('logout');

/*
|--------------------------------------------------------------------------|
| Backend                                                                  |
|--------------------------------------------------------------------------|
*/
Route::prefix('admin')->group(function () {
    Route::middleware('redac')->group(function () {
        Route::name('admin')->get('/', [AdminController::class, 'index']);
    });
});
