
/*
 |--------------------------------------------------------------------------
 | Laravel Spark Components
 |--------------------------------------------------------------------------
 |
 | Here we will load the Spark components which makes up the core client
 | application. This is also a convenient spot for you to load all of
 | your components that you write while building your applications.
 */

require('./../spark-components/bootstrap');

require('./home');

require('./createChallenge');

import FriendList from './FriendList.vue';

Vue.component('friend-list', FriendList);

import MyKrates from './MyKrates.vue';

Vue.component('my-krates', MyKrates);

import KrateStore from './KrateStore.vue';

Vue.component('krate-store', KrateStore);

import RewardDash from './RewardDash.vue';

Vue.component('reward-dash', RewardDash);

import ProgressionDash from './ProgressionDash.vue';

Vue.component('progression-dash', ProgressionDash);

import ProgressionTest from './ProgressionTest.vue';

Vue.component('progression-test', ProgressionTest);

import ScheduleWorkouts from './ScheduleWorkouts.vue';

Vue.component('schedule-workouts', ScheduleWorkouts);

import CreateWorkoutForm from './CreateWorkoutForm.vue';

Vue.component('create-workout-form', CreateWorkoutForm);

//require('./setChallengeWorkouts');

import GetGifComponent from './GetGifComponent.vue';

Vue.component('get-gif', GetGifComponent);

import CoachWorkoutGrid from './CoachWorkoutGrid.vue';

Vue.component('coach-workout-grid', CoachWorkoutGrid);

import ChallengesTable from './ChallengesTable.vue';

Vue.component('challenges-table', ChallengesTable);

import CoachWorkoutView from './CoachWorkoutView.vue';

Vue.component('coach-workout-view', CoachWorkoutView);

import BoxStore from './BoxStore.vue';

Vue.component('box-store', BoxStore);

import ChallengeRegisteredUsers from './ChallengeRegisteredUsers.vue';

Vue.component('challenge-users', ChallengeRegisteredUsers);

import OpenChallengeResults from './OpenChallengeResults.vue';

Vue.component('open-challenges', OpenChallengeResults);

import RegisteredUsers from './RegisteredUsers.vue';

Vue.component('registered-users', RegisteredUsers);

import SendMessage from './SendMessage.vue';

Vue.component('send-message', SendMessage);

import UserChallengeView from './UserChallengeView.vue';

Vue.component('user-challenge-view', UserChallengeView);

import CommentsComponent from './CommentsComponent.vue';

Vue.component('comments-component', CommentsComponent);

import MyChallenges from './MyChallenges.vue';

Vue.component('my-challenges', MyChallenges);

import ScoresComponent from './ScoresComponent.vue';

Vue.component('scores-component', ScoresComponent);