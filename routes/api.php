<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/test', function () {

//     $posts = array();
//     $database = (new Factory)
//         ->withServiceAccount(__DIR__ . '/eventapprealtime-firebase.json')
//         ->withDatabaseUri('https://eventapprealtime.firebaseio.com/')
//         ->withDatabaseUri('https://eventapprealtime.firebaseio.com/')
//         ->create()
//         ->getDatabase()
//         ->getReference('chats/188D7200-740F-11EA-B0EA-9BFA40B1AA93');

//     $snapshot = $database->getSnapshot();

//     foreach ($snapshot->getValue() as $data) {
//         array_push($posts, $data);
//     }

//     return $posts;

// });