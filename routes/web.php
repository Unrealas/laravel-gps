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

Auth::routes();

Route::get('/', 'DeviceController@index')->name('home');

Route::resource('device', 'DeviceController');

Route::get('/admin', 'AdminController@index')->name('admin');

Route::resource('admin', 'AdminController');

Route::get('admin/{lat}/{long}/{device_id}', [
    'as' => 'show', 'uses' => 'AdminController@show']);

Route::get('/mailable', function () {
    $device= App\Device::find(6);
    return new App\Mail\DeviceWork($device);
});