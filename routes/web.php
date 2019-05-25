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

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => 'auth',
], function () {
    Route::resource('projects', 'ProjectsController')->only(['index', 'store', 'show', 'create', 'update', 'edit']);

    Route::post('projects/{project}/tasks', 'ProjectTasksController@store')->name('project.tasks.store');
    Route::put('projects/{project}/tasks/{task}', 'ProjectTasksController@update')->name('project.tasks.update');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();

