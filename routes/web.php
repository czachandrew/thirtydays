<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@show');

Route::get('/home', 'HomeController@show');

Route::get('/challenges/new', 'ChallengeController@create');

Route::post('/signup', 'SignupController@signup');

Route::post('/challenges', 'ChallengeController@store');

Route::get('/challenges', 'ChallengeController@index');

Route::get('/challenges/{challenge}', 'ChallengeController@show');

Route::get('/challenge/{challenge}/{challengeday}', 'ChallengeController@showUserChallengeView');

Route::post('/exercises/create', 'ExerciseController@create');

Route::post('/workouts/{challengeId}/create', 'WorkoutController@create');

Route::get('/progression/test', 'ProgressionController@index');

Route::get('/progression/dashboard', 'ProgressionController@dashboard');
