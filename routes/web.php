<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTimeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebugController;

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
});
Route::get('/',function(){
    return view('welcome');
});
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
        Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
        Route::get('rooms', ['as' => 'rooms', 'uses' => 'App\Http\Controllers\RoomController@rooms']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::resource("outsideTemperature", \App\Http\Controllers\OutsideTemperatureController::class);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
Route::post('importRoomTimes', [RoomTimeController::class, 'import'])->name('import.roomTimes')->middleware('auth');
Route::get('importRoomTimes', [RoomTimeController::class, 'index'])->middleware('auth')->name('import.roomTimes');
Route::post('importOutsideTemperatureImport', [\App\Http\Controllers\OutsideTemperatureImportController::class, 'import'])->name('import.outsideTemperatureImport')->middleware('auth');
Route::get('importOutsideTemperatureImport', [\App\Http\Controllers\OutsideTemperatureImportController::class, 'index'])->middleware('auth')->name('import.outsideTemperatureImport');

Route::get('/co2-and-temperature-data', [HomeController::class,'getRoomsAndTemperatures'])->name('getData');
