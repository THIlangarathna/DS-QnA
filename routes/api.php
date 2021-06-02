<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Api routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your Api!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// View Questions
Route::middleware('auth:api')->get('/Question', 'Api\QuestionController@index');

// Store image
Route::post('/StoreImg', 'Api\QuestionController@storeimg')->name('StoreImg');

Route::post('/AStoreImg', 'Api\AnswerController@storeimg')->name('AStoreImg');

// Store Question
Route::middleware('auth:api')->post('/Question', 'Api\QuestionController@store');

// Edit Question View
Route::middleware('auth:api')->get('/Question{id}','Api\QuestionController@edit');

// Update Question
Route::middleware('auth:api')->put('/Question/{id}','Api\QuestionController@update');

// Show Question
Route::middleware('auth:api')->get('/ShowQuestion{id}', 'Api\QuestionController@show');

//Delete Question
Route::middleware('auth:api')->delete('/Question/{id}', 'Api\QuestionController@destroy');

// Store Answer
Route::middleware('auth:api')->post('/Answer', 'Api\AnswerController@store');

// Update Answer
Route::middleware('auth:api')->put('/Answer/{id}','Api\AnswerController@update');

//Delete Answer
Route::middleware('auth:api')->delete('/Answer/{id}', 'Api\AnswerController@destroy');

// Store image
Route::middleware('auth:api')->post('/Img', 'Api\AnswerController@storeimg');

Route::post('/QImg', 'Api\QuestionController@img')->name('QImg');

Route::post('/AImg', 'Api\QuestionController@img')->name('AImg');

//All Questions
Route::get('/questions','Api\QuestionController@all');

// Show Question
Route::get('/QuestionGuestShow/{id}', 'Api\QuestionController@showquestion');
