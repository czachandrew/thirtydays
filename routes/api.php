<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::get('/user/superdata', 'ProgressionController@superdata');

    Route::get('/provider/superdata', 'ProviderController@superdata');

    Route::get('/provider/joinrequests/approve/{joinrequest}', 'JoinRequestController@approve');

    Route::post('/provider/task', 'TaskController@save');

    Route::delete('/provider/task/{task}', 'TaskController@delete');

    Route::post('/provider/{zonegroup}/task', 'TaskController@createTaskForZone');

    Route::get('/provider/submission/reject/{submission}', 'SubmissionController@reject');

    Route::get('/provider/submission/accept/{submission}', 'SubmissionController@accept');

    Route::get('/provider/usertask/approve/{usertask}', 'UsertaskController@approve');

    Route::post('/provider/addtobank', 'XpController@addToBank');

    Route::post('/usermedia', 'MediaController@save');

    Route::post('/usertask', 'UsertaskController@save');

    Route::post('/reward', 'RewardController@save');

    Route::post('/award', 'XpController@awardUser');


    Route::get('/kratespace/join/{kratespace}', 'KrateSpaceController@join');

    Route::get('/kratespace/leave/{kratespace}', 'KrateSpaceController@leave');

    Route::post('/kratespace/search', 'KrateSpaceController@search');

    Route::get('/zonegroup/subscribe/{zonegroup}', 'ZonegroupController@subscribe');

    Route::get('/zonegroup/unsubscribe/{zonegroup}', 'ZonegroupController@unsubscribe');

    Route::post('/submissions', 'SubmissionController@save');


    Route::get('/friends', 'FriendController@get');

    Route::get('/friends/qrcode/{friend}', 'FriendController@qrCodeBefriend');

    Route::post('/friends/request/send', 'FriendController@sendRequest');

    Route::get('/friends/request/accept/{sender}', 'FriendController@acceptRequest');
 
    Route::get('/friends/unfriend/{friend}', 'FriendController@unfriend');

    Route::get('/friends/request', 'FriendController@getRequests');

    Route::get('/challenges', 'ChallengeController@getChallenges');

    Route::get('/challenges/mine', 'ChallengeController@myChallenges');

    Route::get('/workouts/{challenge}', 'ChallengeController@listWorkouts');

    Route::get('/progression/admin', 'ProgressionController@dashboard');

    Route::get('/progression/get', 'ProgressionController@getProgression');

    Route::post('/progression/award/experience', 'ProgressionController@awardExperience');

    Route::post('/progression/gift/buy', 'ProgressionController@buyBox');

    Route::post('/progression/gift/redeem ', 'ProgressionController@redeemGift');

    Route::post('/progression/gift/open', 'ProgressionController@openGift');

    Route::post('/progression/rewards/create', 'RewardController@create');

    Route::post('/progression/rewards/update', 'RewardController@update');

    Route::post('kratespace', 'KrateSpaceController@save');

    Route::post('kratespace/details', 'KrateSpaceController@details');

    Route::post('kratespace/{kratespace}/group', 'ZonegroupController@save');

    Route::delete('zonegroup/{zonegroup}', 'ZonegroupController@delete');

    Route::get('/krates/buy/{krate}', 'KrateController@buy');

    Route::get('/krates/list', 'KrateController@list');

    Route::get('/krates/mine', 'KrateController@getMyKrates');

    Route::post('/krates/open/{krate}', 'KrateController@open');

    Route::post('/krates/buyandopen', "KrateController@buyAndOpen");

    Route::get('/progression/rewards/disable/{reward}', 'RewardController@disable');

    Route::post('/challenges/days/{challenge}', 'ChallengeController@addDay');

    Route::post('/workouts/{challenge}/', 'WorkoutController@create');

    Route::post('/workouts/{challengeday}/create', 'WorkoutController@createWorkoutAndAttach');

    Route::get('/workouts/{challengeday}/scores', 'WorkoutController@getScores');

    Route::post('/challenge/{challenge}/schedulestart', 'ChallengeController@scheduleStart');

    Route::post('/challenge/{challenge}/start', 'ChallengeController@start');

    Route::post('/challenge/day/{challengeday}/score', 'ChallengeController@addScore');

    Route::post('/score/{submission}/bump', 'BumpController@bumpScore');

    Route::post('/challenge/{challenge}/join', 'ChallengeController@joinChallenge');

    Route::get('/comments/{entity}/{entityId}', 'CommentController@getComments');

    Route::post('/comments/{entity}/{entityId}', 'CommentController@addComment');

    Route::get('/users/list', 'FriendController@listUsers');

    Route::post('/search/users', 'SearchController@searchUsers');
});
