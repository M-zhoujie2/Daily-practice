<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group([
    'namespace' => 'App\Controllers\UserInfo',
    'prefix' => 'userInfo'
],function() use ($app) {
    $app->get('lists',
        ['as' => 'lists', 'uses' => 'UserInfoController@lists']
    );
    $app->get('detail',
        ['as' => 'detail', 'uses' => 'UserInfoController@detail']
    );
    $app->post('insert',
        ['as' => 'insert', 'uses' => 'UserInfoUpdateController@insert']
    );
    $app->post('update',
        ['as' => 'update', 'uses' => 'UserInfoUpdateController@update']
    );
    $app->get('delete',
        ['as' => 'delete', 'uses' => 'UserInfoUpdateController@delete']
    );
    $app->post('uploadExcel',
        ['as' => 'uploadExcel', 'uses' => 'UserInfoUpdateController@uploadExcel']
    );
    $app->get('downloadExcel',
        ['as' => 'downloadExcel', 'uses' => 'UserInfoController@downloadExcel']
    );
});

$app->get('/index', function() {
    return view('index');
});
$app->get('/edit', function() {
    return view('edit'); 
});
