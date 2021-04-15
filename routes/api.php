<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// View Questions
Route::middleware('auth:api')->get('/Question', 'API\QuestionController@index');

// Store image
Route::middleware('auth:api')->post('/Img', 'API\QuestionController@storeimg');

// Store Question
Route::middleware('auth:api')->post('/Question', 'API\QuestionController@store');

// Edit Question View
Route::middleware('auth:api')->get('/Question{id}','API\QuestionController@edit');

// Update Question
Route::middleware('auth:api')->put('/Question/{id}','API\QuestionController@update');

// Show Question
Route::middleware('auth:api')->get('/Questions{id}', 'API\QuestionController@show');

//Delete Question
Route::middleware('auth:api')->delete('/Question/{id}', 'API\QuestionController@destroy');

// Store Answer
Route::middleware('auth:api')->post('/Answer', 'API\AnswerController@store');

// Update Answer
Route::middleware('auth:api')->put('/Answer/{id}','API\AnswerController@update');

//Delete Answer
Route::middleware('auth:api')->delete('/Answer/{id}', 'API\AnswerController@destroy');

// Store image
Route::middleware('auth:api')->post('/Img', 'API\AnswerController@storeimg');

