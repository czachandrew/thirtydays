<template>
   <div id="accordian">
      <!-- week 1 --> 
      <div class="card">
         <div class="card-header" id="headingOne">
            <h5 class="mb-0">
               <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="width:75%;">
                  Week 1: Create/Edit Workouts {{challenge.workouts.length}} / 7 Created
                  
               </button>
               <button class="btn btn-primary pull-right" @click="addWorkout('weekOne')"> + Workout </button>
            </h5>
         </div>
         <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordian">
            <div class="card-body">



              <draggable v-model="workouts" group="workout" @start="drag=true" @end="drag=false" @change="log" v-if="weekOne.length > 0">
               <li class="list-group-item" v-for="workout in weekOne" :key="workout.pivot.order">
                  {{workout.title}}
               </li>
                  <!-- <li class="list-group-item"  v-for="workout in workouts">
                     {{workout.title}}
                  </li>
               </ul> -->
             </draggable>
               <p v-else>
                  You haven't added any Week 1 workouts
               </p>
            </div>
         </div>
         <div class="card-header" id="headingTwo">
            <h5 class="mb-0">
               <button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  Week 2: Create/Edit Workouts {{week2.workouts.length}} / 7 Created
               </button>
               <button class="btn btn-primary pull-right" @click="addWorkout('weekOne')"> + Workout </button>
            </h5>
         </div>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordian">
            <div class="card-body">
               <p>Here is the second card body</p>
            </div>
         </div>
      </div>
         <!-- day 1 --> 
         <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
             <div class="modal-content">
               <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Add a workout for Week {{addWeek}}</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>
               <div class="modal-body">
                 <create-workout-form :week="addWeek" :order="addPos" :challenge-id="challengeId" @created="pushWorkout"></create-workout-form>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">Save changes</button>
               </div>
             </div>
           </div>
         </div>
   </div>
</template>
<script>
import draggable from 'vuedraggable';
export default {
   props: {
      challengeId: {
         type: Number,
         required: true
      },
      challenge: {
         type: Object,
         required: true
      }
   },
   data(){
      return {
         week1: {
            workouts:[]
         },
         week2: {
            workouts:[]
         },
         addWeek:'',
         addPos: 0,
         workouts: []
      };
   },
   computed: {
    nextOrder: function(){
      return this.workouts.length + 1;
    },
    weekOne: function(){
      return this.workouts.filter(workout => 0 < workout.pivot.order < 8);
    },
    weekTwo: function(){
      return this.workouts.filter(workout => 7 < workout.pivot.order < 15);
    },
    weekThree: function(){

    },
    weekFour: function(){

    }
   },
   methods: {
      addWorkout(week){
         //open the modal attached to this week
         console.log(week);
         if(week == null || week == undefined){
          alert("You can only add workouts to a specific week");
         }
         if(week == 'weekOne'){
            this.addWeek = 1;
         } else if(week == 'weekTwo'){
            this.addWeek = 2;
         } else if(week == 'weekThree'){
            this.addWeek = 3;
         } else if(week == 'weekFour'){
            this.addWeek = 4;
         }

         this.addWeek = week;
         console.log("Here is the dynamic count for the computed property");
         console.log(this[week].length);
         this.addPos = this[week].length + 1;

         console.log(this.nextOrder);
         $('#exampleModal').modal('show');
      },
      getWorkouts(){
        let self = this;
        axios.get('/api/workouts/' + self.challengeId).then(response => {
          console.log(response);
          self.workouts = response.data;
        }).catch(error => {
          console.log(error);
        });
      },
      prepDataForDisplay(){

      },
      pushWorkout(payload){
        console.log("Workout received");
        console.log(payload);
        this.workouts.push(payload);
      },
      log(){
        console.log(this.workouts);
      }
   },
   mounted(){
    //this.getWorkouts();
    this.workouts = this.challenge.workouts;
    console.log("Mounted");
    console.log(this.challenge);
   }
};
//A challenge has a bunch of workouts, the workouts each have an order let's just add it to the table for now
</script>