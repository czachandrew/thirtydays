<template>
   <div>
    <div class="row" v-if="local_challenge">
      <div class="col-md-3">
        <img :src="challenge.image" style="width: 100%; height: auto;" />
        <!-- Let's put the status and current day here --> 
        <!-- maybe add a button  here to change the status --> 
      </div>
      <div class="col-md-9">
        <h1>{{local_challenge.title}}</h1>
        <h6>{{local_challenge.description}}</h6>
           <div class="row" style="padding-bottom: 15px;">
            <div class="col-md-6">
              <div v-if="local_challenge.status !== 'active'">
<!--                <h4 class="title">{{challenge.title}}</h4>
               <p>{{challenge.description}}</p> -->
               <h5 class="font-weight-bold"> Ready to go?</h5> 
               <h6>Pick a start date and allow atheletes to join:</h6>
               <small> you can always start your challenge early</small>
               <div class="form-group">
                  <datepicker input-class="form-control" v-model="local_challenge.start_date"></datepicker>
               </div>
               <button class="btn btn lg btn-primary" @click="scheduleStart"> Schedule it </button>
               <button class="btn btn lg btn-warning" @click="startNow"> Start Now! </button>

               </div>
               <div v-else>

               </div>
            </div>
            <div class="col-md-6">  
              <h5><span class="font-weight-bold">Status:</span> <span v-if="local_challenge" :class="{ 'text-success': challenge.status == 'open', 'font-weight-bold': challenge.status === 'new' }">{{local_challenge.status}}</span></h5>
              <h5><span class="font-weight-bold">Workouts Scheduled:</span> {{scheduled}}</h5>

            </div>
         </div>
         <!-- <div class="row">
            <div class="col">
              <registered-users :users="local_challenge.participants"></registered-users>
                
            </div>
         </div> -->
      </div>
    </div>
      
      <p>Awesome you've created a challenge now you just need to create some workouts. Befor you start a challenge you must have at least 1 week of work programmed in. After that you will get reminded whenever you are coming up on a day without programming</p>
      <div>
          <b-tabs content-calss="mt-3" v-if="local_challenge">
              <b-tab title="Current Day" :disabled="local_challenge.status !== 'active'">
                <button class="btn btn-primary btn-sm" @click="previousDay">Previous Day</button>
                <h2>{{local_challenge.days[(local_challenge.current_day-1)].workout.title}}</h2>
                <p>{{local_challenge.days[(local_challenge.current_day-1)].workout.description}}</p>
                <scores-component :day="local_challenge.days[(local_challenge.current_day - 1)]"></scores-component>
              </b-tab>
              <b-tab title="Workout Schedule">
                <coach-workout-view :challenge="local_challenge"></coach-workout-view>
              </b-tab>
              <b-tab title="Participants">
                
                <registered-users :users="local_challenge.participants"></registered-users>
              </b-tab>

          </b-tabs>

      </div>  
     <!--  <coach-workout-view :challenge="challenge"></coach-workout-view> -->
    
<!--                <div class="card-body">
                  <calendar
                      :first-day="1"
                      :all-events="scheduledDays"
                      @eventAdded="added"
                      @eventDeleted="eventDeleted"
                  ></calendar>
               </div> -->

  </div>
</template>
<style>
   #accordian .card {
      margin-bottom: 0 !important;
   }
</style>
<script>
import {Calendar} from 'vue-bootstrap4-calendar';
import Datepicker from 'vuejs-datepicker';
import { EventBus } from '../event-bus.js';
export default {
	props:['user','challenge'],
	components: {
		Calendar,
    Datepicker
	},
	data(){
		return {
			scheduleDate: {
				workout_id:'',
				date:'' 
			},
      local_challenge: null,
			start_date:'',
			end_date:'',
			scheduledDays: [
            {title: "adfgasdfasdf", color: "", description: "asdfasdfasdfasdf", date: new Date('March 21, 2019')}
         ]
		};
	},
  computed:{
    scheduled(){
      if(this.local_challenge !== null){
        return this.local_challenge.days.filter(ele => {
          return ele.workout_id !== null;
        }).length;
      } else {
        return 0;
      }
      
    },
    currentChallenge(){
      return this.local_challenge.days[this.local_challenge.current_day-1];
    }
  },
	methods: {
		added(event){
			console.log(event);
         this.scheduledDays.push(event);
		},
		eventDeleted(event){
         console.log(event);
		},
    scheduleStart(){
      let self = this;
      //post the date to the serve along with open: true/false param
      axios.post('/api/challenge/' + this.challenge.id + '/schedulestart', {date: this.local_challenge.start_date, open: true}).then(response => {
        //console.log(response);
        self.local_challenge = response.data;
      }).catch(error => {
        console.log(error);
      });
    },
    startNow(){
      alert("You have " + this.local_challenge.participants.length + " atheletes registered, once you start no one else can join.");
      axios.post('/api/challenge/' + this.challenge.id + "/start", {}).then(response => {
        console.log(response);
        this.local_challenge.status = response.data.status;
      }).catch(error => {
        console.log(error);
      });
    },
    previousDay(){
      console.log("Going back in time");
      if(this.local_challenge.current_day - 1 > 0 ){
        //do it 

        this.local_challenge.current_day = this.local_challenge.current_day - 1;
        console.log("The day should be");
        console.log(this.local_challenge.current_day);
        EventBus.$emit('day_changed');
      }
    }
	},
	mounted() {
    this.local_challenge = this.challenge;
		this.$on('event-added', payload => {
			console.log("event has been added");
			console.log(payload);
		});
	}
};
</script>