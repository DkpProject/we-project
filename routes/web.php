<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();
Route::get('register/{key}', ['as' => 'auth.register', 'uses' => 'Auth\RegisterController@showRegistrationForm'])->where('key', '\w{30}');

Route::group(['middleware' => 'auth'], function () {

    Route::get('{app}', function ($page) {
        return view('layouts.app');
    })->where('app', '^(?!api\/|images\/).*');

//	Route::get('/', function () {
//		return redirect('/profile');//view('welcome');
//	});
//	Route::get('/home', 'Controller@dashboard');
//
//    //Ajax requests
//    Route::group(['prefix' => 'ajax'], function() {
//
//        Route::group(['middleware' => 'permission:actionDealChat'], function () {
//            Route::post('/deal/chat/{id}/send', 'Ajax\Chat@dealSend')
//                ->where('id', '[0-9]+');
//            Route::post('/deal/chat/{id}/reload', 'Ajax\Chat@dealReload')
//                ->where('id', '[0-9]+');
//        });
//
//        Route::group(['middleware' => 'permission:actionMessage'], function () {
//            Route::post('/chat/{id}/send', 'Ajax\Chat@dialogSend');
//            Route::post('/chat/{id}/reload', 'Ajax\Chat@dialogReload');
//        });
//
//        Route::get('/search', 'Ajax\Search@full_search')
//            ->middleware('permission:actionSearch');
//
//        Route::post('/bugtracker', 'Ajax\BugTracker@newMessage')
//            ->middleware('permission:actionBugTracker');
//
//    });
//
//    //Routes for deals
//    Route::group(['prefix' => 'deal'], function() {
//
//        Route::get('/{deal}', 'DealController@view')
//            ->where('deal', '[0-9]+')
//            ->middleware('permission:showDeal');
//
//        Route::post('/{deal}/{person}', 'DealController@finish')
//            ->where('deal', '[0-9]+')
//            ->where('person', 'seller|purchaser')
//            ->middleware('permission:actionFinishDeal');
//
//        Route::get('/{deal}/cancel', 'DealController@cancel')
//            ->where('deal', '[0-9]+')
//            ->middleware('permission:actionCancelDeal');
//
//        Route::get('/{deal}/receipt/{receipt}', 'DealController@receiptPayment')
//            ->where('deal', '[0-9]+')
//            ->where('receipt', '[0-9]+')
//            ->middleware('permission:actionReceiptPayment');
//
//    });
//
//    //Routes for services
//    Route::group(['prefix' => 'service'], function() {
//
//        Route::get('/', 'ServiceController@index')
//            ->middleware('permission:showServiceCatalog');
//
//        Route::get('/{id}', 'ServiceController@service')
//            ->where('id', '[0-9]+')
//            ->middleware('permission:showServicePage');
//
//        Route::group(['middleware' => 'permission:showServiceEdit'], function() {
//            Route::get('/{id}/edit', 'ServiceController@edit')
//                ->where('id', '[0-9]+');
//            Route::post('/{id}/edit', 'ServiceController@update')
//                ->where('id', '[0-9]+');
//        });
//
//        Route::group(['middleware' => 'permission:showServiceDelete'], function() {
//            Route::get('/{id}/delete', 'ServiceController@delete')
//                ->where('id', '[0-9]+');
//            Route::post('/{id}/delete', 'ServiceController@destroy')
//                ->where('id', '[0-9]+');
//        });
//
//        Route::get('/cat/{id}', 'ServiceController@category')
//            ->where('id', '[0-9]+')
//            ->middleware('permission:showServiceCat');
//
//        Route::group(['middleware' => 'permission:showServiceAdd'], function() {
//            Route::get('/add', 'ServiceController@add');
//            Route::post('/add', 'ServiceController@create');
//        });
//
//        Route::get('/search/{query}', 'ServiceController@search')
//            ->middleware('permission:actionSearchService');
//
//        Route::group(['middleware' => 'permission:showServiceDeal'], function() {
//            Route::get('/{id}/deal', 'ServiceController@makeDeal')
//                ->where('id', '[0-9]+');
//            Route::post('/{id}/deal', 'ServiceController@createDeal')
//                ->where('id', '[0-9]+');
//        });
//    });
//
//	//Routes for catalog
//    Route::group(['prefix' => 'catalog'], function() {
//
//        Route::get('/', 'CatalogController@index')
//            ->middleware('permission:showGoodsCatalog');
//
//        Route::get('/{good}', 'CatalogController@good')
//            ->where('good', '[0-9]+')
//            ->middleware('permission:showGoodsPage');
//
//        Route::group(['middleware' => 'permission:showGoodsEdit'], function() {
//            Route::get('/{good}/edit', 'CatalogController@edit')
//                ->where('good', '[0-9]+');
//            Route::post('/{good}/edit', 'CatalogController@update')
//                ->where('good', '[0-9]+');
//        });
//
//        Route::group(['middleware' => 'permission:showGoodsDelete'], function() {
//            Route::get('/{good}/delete', 'CatalogController@delete')
//                ->where('good', '[0-9]+');
//            Route::post('/{good}/delete', 'CatalogController@destroy')
//                ->where('good', '[0-9]+');
//        });
//
//        Route::get('/cat/{id}', 'CatalogController@category')
//            ->where('id', '[0-9]+')
//            ->middleware('permission:showGoodsCat');
//
//        Route::group(['middleware' => 'permission:showGoodsAdd'], function() {
//            Route::get('/add', 'CatalogController@add');
//            Route::post('/add', 'CatalogController@create');
//        });
//
//        Route::get('/search/{query}', 'CatalogController@search')
//            ->middleware('permission:actionSearchCatalog');
//
//        Route::group(['middleware' => 'permission:showGoodsDeal'], function() {
//            Route::get('/{good}/deal', 'CatalogController@makeDeal')
//                ->where('good', '[0-9]+');
//            Route::post('/{good}/deal', 'CatalogController@createDeal')
//                ->where('good', '[0-9]+');
//        });
//
//        Route::post('/{item}/report', 'CatalogController@report')
//            ->where('item', '[0-9]+')
//            ->middleware('permission:reportCatalogItem');
//    });
//
//	//Routes for profile
//    Route::group(['prefix' => 'profile'], function() {
//
//        Route::get('/', 'ProfileController@index')
//            ->middleware('permission:showProfile');
//
//        Route::group(['middleware' => 'permission:showProfileForm'], function () {
//            Route::get('/form', 'ProfileController@form');
//            Route::post('/form', 'ProfileController@form_update');
//        });
//
//        Route::group(['middleware' => 'permission:showProfileTransfer'], function () {
//            Route::get('/transfer', 'ProfileController@transfer');
//            Route::get('/transfer/request', 'ProfileController@transferDo');
//            Route::post('/transfer', 'ProfileController@transferDo');
//        });
//
//        Route::group(['middleware' => 'permission:showProfileRequest'], function () {
//            Route::get('/request', 'ProfileController@request');
//            Route::post('/request', 'ProfileController@requestSend');
//        });
//
//        Route::group(['middleware' => 'permission:editPassword'], function () {
//            Route::get('/password', 'ProfileController@edit_password');
//            Route::post('/password', 'ProfileController@update_password');
//        });
//
//        Route::get('/invite/add', 'ProfileController@create_invite')
//            ->middleware('permission:createInvite');
//
//        Route::get('/team', 'ProfileController@team')
//            ->middleware('permission:showMyTeam');
//
//        Route::get('/goods', 'ProfileController@goods')
//            ->middleware('permission:showMyGoods');
//
//        Route::get('/services', 'ProfileController@services')
//            ->middleware('permission:showMyServices');
//
//        Route::get('/{user}', 'ProfileController@user')
//            ->where('user', '[0-9]+')
//            ->middleware('permission:showUser');
//
//        Route::get('/{user}/confirm', 'ProfileController@user_confirm')
//            ->where('user', '[0-9]+')
//            ->middleware('permission:confirmUser');
//
//        Route::post('/{user}/report', 'ProfileController@report')
//            ->where('user', '[0-9]+')
//            ->middleware('permission:reportUser');
//
//    });
//
//    Route::group(['prefix' => '/forum', 'middleware' => 'permission:showDiscussion'], function() {
//        Route::get('/', 'Forum\MainController@index');
//        Route::get('/cat/{slug}', 'Forum\MainController@index');
//        Route::resource('/discuss', 'Forum\DiscussionController');
//        Route::get('/discuss/{category}/{slug}', 'Forum\DiscussionController@show');
//        Route::post('/discuss/{id}/confirm', 'Forum\DiscussionController@confirm')->middleware('permission:actionConfirmEvaluation');
//        Route::post('/discuss/{id}/close', 'Forum\DiscussionController@close');
//        Route::resource('/posts', 'Forum\PostController');
//        Route::get('/posts/{id}/thanks', 'Forum\PostController@thanks')->middleware('permission:actionPostThanks');
//    });
//
//    Route::group(['prefix' => '/polls', 'middleware' => 'permission:showPoll'], function() {
//        Route::get('/', 'PollsController@index');
//        Route::get('/{id}', 'PollsController@poll')->where('id', '[0-9]+');
//        Route::post('/{id}', 'PollsController@answer')->where('id', '[0-9]+');
//    });
//
//    Route::group(['prefix' => '/chat', 'middleware' => 'permission:showMessage'], function() {
//        Route::get('/', 'MessageController@index');
//        Route::get('/{id}', 'MessageController@dialog')->where('id', '[0-9]+');
//    });
//
//    //Static pages
//
//    Route::get('/user-agreement', function (){
//        return view('pages.userAgreement');
//    });
//
//	Route::get('/additional-agreements', function (){
//        return view('pages.additionalAgreements');
//    });
//
//	Route::get('/wishes', function (){
//        return view('wishes.index');
//    });
//    Route::post('/wishes', 'AdminController@makeWish');
//    Route::get('/wishes/{wish}/delete', 'AdminController@deleteWish');
//
//    Route::get('/specialties', 'AdminController@specialties');
//    Route::post('/specialties', 'AdminController@specialtiesCreate');
//    Route::get('/specialties/{cat}/delete', 'AdminController@specialtiesDelete');
//
//    //Service routes
//    Route::group(['prefix' => '/admin', 'middleware' => 'permission:showAdminBalance'], function() {
//        Route::get('/balance', 'AdminController@balance');
//        Route::post('/balance', 'AdminController@updateBalance');
//    });
});
