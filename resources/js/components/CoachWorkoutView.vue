<template> 
   <div class="card">
      <div class="card-body">
         <div class="row">
            <div class="col">

               <b-button @click="showCreateModal(nextDay)">Add a Workout</b-button>
               <b-modal id="modal-1" ref="create-modal" :title="'Create a Workout for Day ' + createForDay.order">
                  <create-workout-form :day="createForDay.id" :order="createForDay.order" :challenge-id="challenge.id"></create-workout-form>
               </b-modal>
            </div>
         </div>

         <draggable v-if="days.length > 2" v-model="days" group="day" @start="drag=true" @end="drag=false" @change="log">
            <div class="card col-md-12" v-for="(day, key) in days" :key="day.order">
               <div class="card-body">
                  <div class="row " v-if="day.workout">
                     <div class="col-md-3">
                        <h5>Day {{day.order}} </h5>
                        <img :src="day.workout.gif" style="height: 125px; width: auto; max-width: 100%;" />
                     </div>
                     <div class="col d-flex flex-column">
                        <h5>{{day.workout.title}}</h5>
                        <p>{{day.workout.description}}</p>
                        <p>
                           <span class="font-weight-bold">Type:</span> {{day.workout.type}} <br>
                           <span class="font-weight-bold">Submissions:</span> {{day.submissions.length}}
                        </p>
                        <div class="mt-auto">
                        <button class="btn btn-sm btn-warning">Edit</button>
                        <button class="btn btn-sm btn-danger"> X Remove</button>
                     </div>
                     </div>
                  </div>
                  <div v-else>
                     <h5>Day {{day.order}}</h5>
                     <button class="btn btn-primary btn-sm" @click="showCreateModal(day)">Add Workout</button>
                  </div>
               </div>
            </div>
         </draggable>
      </div>
   </div>
   <!-- PUt the gif up here and the title of the workout as well as an editable description --> 

   <!-- Show the challenge status --> 

   <!-- Have a tab for atheletes and scores --> 

</template>
<style>

</style>
<script>
import Datepicker from 'vuejs-datepicker';
   export default {
      props: {
         challenge: {
            type: Object, 
            required: true
         }
      },
      components: {
         Datepicker
      },
      computed: {
         nextDay: function(){
            return this.days.find(day => day.workout_id == null);
         }
      },
      data() {
         return {
            workouts:[],
            days:[],
            createForDay: {
               id: 0
            }
            
         };
      },
      methods: {
         log: function(){
            console.log(this.days);
            var i = 1;
            this.days.forEach(ele => {
               ele.order = i; 
               i++;
            });         
         },
         reorg: function(ele){

         },
         showCreateModal: function(day){
            this.createForDay = day;
            this.$refs['create-modal'].show();
         },
         dismissCreateModal: function(){
            this.createForDay = {id: null};
            this.$refs['create-modal'].hide();
         }
      },
      mounted () {
         let self = this;
         this.workouts = this.challenge.workouts;
         this.days = this.challenge.days;
         this.$on('created', payload => {
            //payload contains the newly created exercise 
            self.dismissCreateModal();
            
         })
      }
   };

</script>
