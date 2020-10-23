<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    
    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', 'Settings\ProfileController@fetchUser');
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    //Permissions
    Route::get('/permissions', 'RoleManagerController@permissionsIndex')
        ->name('permissions.index')
        ->middleware('permission:View All Permissions');

    Route::get('/roles', 'RoleManagerController@rolesIndex')
        ->name('roles.index')
        ->middleware('permission:View All Roles');

    Route::post('/roles/{role}/assign/{user}', 'RoleManagerController@rolesAddUser')
        ->name('roles.addUser')
        ->middleware('permission:Assign Role');

    Route::post('/roles/{role}/unassign/{user}', 'RoleManagerController@rolesRemoveUser')
        ->name('roles.removeUser')
        ->middleware('permission:Unassign Role');
    
});
Route::group(['middleware' => 'auth:api', 'namespace' => 'Admin'], function(){
    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UsersController@index')->name('users');
        Route::post('/store', 'UsersController@store')->name('users.store');
        Route::put('/{id}/update', 'UsersController@update')->name('users.update');
    });
    //users
    Route::group(['prefix' => 'roles'], function() {
        Route::get('/', 'RolesController@index')->name('roles');
        Route::post('/store', 'RolesController@store')->name('roles.store');
        Route::put('/{id}/update', 'RolesController@update')->name('roles.update');
    });
    //specialties
    Route::group(['prefix' => 'specialties'], function() {
        Route::get('/', 'SpecialtyController@index');
        Route::get('/{specialty}/edit', 'SpecialtyController@edit');
        Route::put('/{specialty}/update', 'SpecialtyController@update')->name('specialties.update');
        Route::post('/store', 'SpecialtyController@store')->name('specialties.store');
        Route::delete('/{id}/delete', 'SpecialtyController@destroy')->name('specialties.delete');
    }); 
    //doctors
    Route::group(['prefix' => 'doctors'], function() {
        Route::get('/', 'DoctorController@index')->name('doctors');
        Route::post('/store', 'DoctorController@store')->name('doctors.create');
    });
});




