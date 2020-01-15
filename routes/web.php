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

// product
Route::get('product',                   'ProductController@index')->name('product.index');
Route::get('product/category/{id}',     'ProductController@category')->name('product.category');
Route::get('product/level/{id}',        'ProductController@level')->name('product.level');
Route::get('product/detail/{id}',       'ProductController@detail')->name('product.detail');

// message
Route::match(['get', 'post'], 'message',   'MessageController@index')->name('message.index');

Route::group(['middleware' => ['auth']], function () {
    // profile
    Route::get('profile',           'ProfileController@index')->name('profile.index');
    Route::post('profile/setting',  'ProfileController@setting')->name('profile.setting');
    Route::post('profile/password', 'ProfileController@password')->name('profile.password');
    Route::post('profile/avatar',   'ProfileController@avatar')->name('profile.avatar');
    Route::post('profile/location', 'ProfileController@location')->name('profile.location');
    Route::post('profile/balance',  'ProfileController@balance')->name('profile.balance');

    // donation
    Route::match(['get', 'post'], 'donation',   'DonationController@index')->name('donation.index');
    Route::post('donation/add',                 'DonationController@store')->name('donation.store');
    Route::resource('donation',                 'DonationController', ['only' => [
        'update', 'destroy'
    ]]);

    // cart
    Route::match(['get', 'post'], 'cart',   'CartController@index')->name('cart.index');
    Route::post('cart/add',                 'CartController@store')->name('cart.store');
    Route::resource('cart',             'CartController', ['only' => [
        'update', 'destroy'
    ]]);

    // voucher
    Route::get('voucher',       'VoucherController@index')->name('voucher.index');
    Route::get('voucher/me',    'VoucherController@me')->name('voucher.me');
    Route::post('voucher/add',  'VoucherController@store')->name('voucher.store');

    // invoice
    Route::get('invoice',                                   'InvoiceController@index')->name('invoice.index');
    Route::post('invoice/add',                              'InvoiceController@store')->name('invoice.store');

    Route::get('invoice/pending/{id}',                      'InvoiceController@pending')->name('invoice.pending');
    Route::get('invoice/waiting-store/{id}',                'InvoiceController@waitingStore')->name('invoice.waiting-store');
    Route::get('invoice/canceled/{id}',                     'InvoiceController@canceled')->name('invoice.canceled');
    Route::get('invoice/order-shipped/{id}',                'InvoiceController@orderShipped')->name('invoice.order-shipped');
    Route::get('invoice/order-reject/{id}',                 'InvoiceController@orderReject')->name('invoice.order-reject');
    Route::get('invoice/received/{id}',                     'InvoiceController@received')->name('invoice.received');

    Route::post('invoice/destination-location-new',         'InvoiceController@destinationLocationNew')->name('invoice.destination-location-new');
    Route::post('invoice/destination-location-now',         'InvoiceController@destinationLocationNow')->name('invoice.destination-location-now');
    Route::post('invoice/payment',                          'InvoiceController@payment')->name('invoice.payment');
    Route::post('invoice/cancel',                           'InvoiceController@cancel')->name('invoice.cancel');
    Route::post('invoice/confirm-shipped',                  'InvoiceController@confirmShipped')->name('invoice.confirm-shipped');
    Route::post('invoice/use-voucher',                      'InvoiceController@useVoucher')->name('invoice.use-voucher');
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
        Route::post('profile/location', 'ProfileController@location')->name('profile.location');

        // product
        Route::match(['get', 'post'], 'product',   'ProductController@index')->name('product.index');
        Route::post('product/add',                 'ProductController@store')->name('product.store');
        Route::resource('product',                 'ProductController', ['only' => [
            'update', 'destroy',
        ]]);

        // order-entry
        Route::match(['get', 'post'], 'order-entry',    'OrderEntryController@index')->name('order-entry.index');
        Route::resource('order-entry',                  'OrderEntryController', ['only' => [
            'show'
        ]]);
        Route::post('order-entry/approve',              'OrderEntryController@approve')->name('order-entry.approve');
        Route::post('order-entry/reject',               'OrderEntryController@reject')->name('order-entry.reject');

        // order-shipped
        Route::match(['get', 'post'], 'order-shipped',    'OrderShippedController@index')->name('order-shipped.index');
        Route::resource('order-shipped',                  'OrderShippedController', ['only' => [
            'show'
        ]]);

        // order-declined
        Route::match(['get', 'post'], 'order-declined',    'OrderDeclinedController@index')->name('order-declined.index');
        Route::resource('order-declined',                  'OrderDeclinedController', ['only' => [
            'show'
        ]]);

        // order-received
        Route::match(['get', 'post'], 'order-received',    'OrderReceivedController@index')->name('order-received.index');
        Route::resource('order-received',                  'OrderReceivedController', ['only' => [
            'show'
        ]]);
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

        // withdraw
        Route::match(['get', 'post'], 'withdraw',   'WithdrawController@index')->name('withdraw.index');
        Route::resource('withdraw',                 'WithdrawController', ['only' => [
            'show'
        ]]);
        Route::post('withdraw/approve',               'WithdrawController@approve')->name('withdraw.approve');
        Route::post('withdraw/reject',                'WithdrawController@reject')->name('withdraw.reject');

        // product
        Route::match(['get', 'post'], 'product',   'ProductController@index')->name('product.index');
        Route::resource('product',                 'ProductController', ['only' => [
            'update',
        ]]);

        // message
        Route::match(['get', 'post'], 'message',   'MessageController@index')->name('message.index');

        // donation
        Route::match(['get', 'post'], 'donation',   'DonationController@index')->name('donation.index');
        Route::resource('donation',                 'DonationController', ['only' => [
            'show'
        ]]);
        Route::post('donation/approve',               'DonationController@approve')->name('donation.approve');
        Route::post('donation/reject',                'DonationController@reject')->name('donation.reject');

        // voucher
        Route::match(['get', 'post'], 'voucher',   'VoucherController@index')->name('voucher.index');
        Route::post('voucher/add',                 'VoucherController@store')->name('voucher.store');
        Route::resource('voucher',                 'VoucherController', ['only' => [
            'update', 'destroy',
        ]]);
    });
});
