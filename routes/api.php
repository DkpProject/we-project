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

Route::get('/user', 'Api\BaseInfoController@user');
Route::get('/specialties', 'Api\BaseInfoController@specialties');
Route::get('/districts', 'Api\BaseInfoController@districts');
Route::get('/myteam', 'Api\BaseInfoController@myTeam');

Route::get('/dialogs', 'Api\MessagerController@dialogs');
Route::get('/messages/{id}', 'Api\MessagerController@messages')->where('id', '[0-9]+');

Route::get('/mygoods', 'Api\Goods@mygoods');
Route::get('/good/{id}', 'Api\Goods@good')->where('id', '[0-9]+');

Route::get('/deals/goods', 'Api\Deals@goods');