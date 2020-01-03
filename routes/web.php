<?php

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
// Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// home
Route::get('/', 'HomeController@index')->name('index');

Route::group(['middleware' => ['auth']], function () {
    // profile
    Route::get('profile',           'ProfileController@index')->name('profile.index');
    Route::post('profile/setting',  'ProfileController@setting')->name('profile.setting');
    Route::post('profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/avatar',   'ProfileController@avatar')->name('profile.avatar');
    Route::post('profile/location', 'ProfileController@location')->name('profile.location');
    Route::post('profile/balance',  'ProfileController@balance')->name('profile.balance');

});

Route::prefix('store')->namespace('Store')->name('store.')->group(function () {
    Route::group(['middleware' => ['auth']], function () {
        // home
        Route::get('/', 'HomeController@index')->name('index');

        // profile
        Route::get('profile',           'ProfileController@index')->name('profile.index');
        Route::post('profile/setting',  'ProfileController@setting')->name('profile.setting');
        Route::post('profile/password', 'ProfileController@password')->name('profile.password');
        Route::post('profile/avatar',   'ProfileController@avatar')->name('profile.avatar');
        Route::post('profile/location',   'ProfileController@location')->name('profile.location');
    });
});

Route::prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Login
    Route::match(['get', 'post'], 'login', 'Auth\LoginController@login')->name('login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::group(['middleware' => ['auth']], function () {
        // home
        Route::get('/', 'HomeController@index')->name('index');

        // province
        Route::match(['get', 'post'], 'province',   'ProvinceController@index')->name('province.index');
        Route::post('province/add',                 'ProvinceController@store')->name('province.store');
        Route::resource('province',                 'ProvinceController', ['only' => [
            'update', 'destroy',
        ]]);

        // district
        Route::match(['get', 'post'], 'district',   'DistrictController@index')->name('district.index');
        Route::post('district/add',                 'DistrictController@store')->name('district.store');
        Route::resource('district',                 'DistrictController', ['only' => [
            'update', 'destroy',
        ]]);

        // sub-district
        Route::match(['get', 'post'], 'sub-district',   'SubDistrictController@index')->name('sub-district.index');
        Route::post('sub-district/add',                 'SubDistrictController@store')->name('sub-district.store');
        Route::resource('sub-district',                 'SubDistrictController', ['only' => [
            'update', 'destroy',
        ]]);

        // shipping
        Route::match(['get', 'post'], 'shipping',   'ShippingController@index')->name('shipping.index');
        Route::post('shipping/add',                 'ShippingController@store')->name('shipping.store');
        Route::resource('shipping',                 'ShippingController', ['only' => [
            'update', 'destroy',
        ]]);

        // category
        Route::match(['get', 'post'], 'category',   'CategoryController@index')->name('category.index');
        Route::post('category/add',                 'CategoryController@store')->name('category.store');
        Route::resource('category',                 'CategoryController', ['only' => [
            'update', 'destroy',
        ]]);

        // level
        Route::match(['get', 'post'], 'level',   'LevelController@index')->name('level.index');
        Route::post('level/add',                 'LevelController@store')->name('level.store');
        Route::resource('level',                 'LevelController', ['only' => [
            'update', 'destroy',
        ]]);

        // slider
        Route::match(['get', 'post'], 'slider', 'SliderController@index')->name('slider.index');
        Route::post('slider/add',               'SliderController@store')->name('slider.store');
        Route::resource('slider',               'SliderController', ['only' => [
            'update', 'destroy',
        ]]);

        // topup
        Route::match(['get', 'post'], 'topup',   'TopUpController@index')->name('topup.index');
        Route::resource('topup',                 'TopUpController', ['only' => [
            'show'
        ]]);
        Route::post('topup/approve',               'TopUpController@approve')->name('topup.approve');
        Route::post('topup/reject',                'TopUpController@reject')->name('topup.reject');
    });
});
