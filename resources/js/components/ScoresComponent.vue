<template> 
   <div>
      <h5>Scores</h5>
         <div v-if="orderedSubs.length > 0">
            <transition-group name="list" tag="ul">
               <li class="list-group-item" v-for="(score, key) in orderedSubs" :key="score.id" @click="examineScore(score)">
                  
                  <b-img :src="score.user.photo_url" rounded="circle" style="width: 30px; height: 30px;"></b-img> {{score.user.name}} <i v-if="score.description !== ''" class="fa fa-comment-dots"></i>
               
               
                  <button class="btn btn-default btn-sm float-right" style="margin-left:15px;" @click="bump(score.id, key)" :disabled="iBumped(score)"><i class="fa fa-fist-raised fa-rotate-270"></i></button>
                   <span class="float-right">{{score.score}} {{day.workout.type_label}} </span>
                  <!-- <button class="btn btn-danger btn-sm" @click="removeScore(key)">x</button> -->
              
               </li>
            </transition-group>
         </div>
         <div v-else>
            <b-card>
               <b-card-text>No scores yet! {{scores}}</b-card-text>
            </b-card>
           
         </div>
         <b-modal id="zoom-modal" :title="zoomModalName" ref="zoomModal" @hidden="closeZoom">
         <div v-if="zoomScore.user">
            <div class="row inline">
               <div class="col-md-2">
                  <b-img :src="zoomScore.user.photo_url" rounded="circle" class="align-middle" style="width:50px; height: auto;"></b-img>
               </div>
               <div class="col">
                  <h3 style="position: absolute; bottom:0;">{{zoomScore.user.name}}</h3>
               </div>
            </div>
            <div class="card">
               <div class="card-body">
                  <h3 class="text-center">{{zoomScore.score}} {{day.workout.type_label}}</h3>
                  <p class="text-muted text-center">Submitted {{zoomScore.created_at | moment('from','now')}}</p>
                  <p v-if="zoomScore.description !== ''" class="font-italic">
                     {{zoomScore.description}}
                  </p>
                  <p v-else>
                     No notes on this one...
                  </p>
               </div>
            </div>
            <comments-component commentable="submission" :commentable-id="zoomScore.id"></comments-component>
         </div>

      </b-modal>
   </div>
</template>
<style>

</style>
<script>
import { EventBus } from '../event-bus.js';
   export default {
      props:['day'],
      data() {
         return {
            scores:[],
            zoomScore:{}
         }
      },
      computed:{
         orderedSubs: function(){
            return _.orderBy(this.scores, 'score');
         },
         zoomModalName: function(){
            if(this.zoomScore.user){
               return this.zoomScore.user.name;
            } else {
               return 'Name missing'
            }
         }
      },
      watch:{
         day: function(){
            this.fetch();
         }
      },
      methods: {
         fetch: function(){
            let self = this;
            axios.get('/api/workouts/' + this.day.id + '/scores').then(response => {
               console.log(response);
               self.scores = response.data;
               // response.data.forEach(ele => {
               //    console.log(ele);
               //    self.scores.push(response.data);
               // })
            }).catch(error => {
               console.log(error);
            });
         },
         closeZoom: function(){
            this.zoomScore = {};
            //this.$refs['zoomModal'].hide();
         },
         bump: function(submission, key){
            console.log("bumping");
            axios.post('/api/score/' + submission + '/bump',{}).then(response => {
               console.log(response);
            }).catch(error => {
               console.log(error);
            });
         },
         iBumped: function(score){
            var result = false;
            score.bumps.forEach(ele => {
               if(ele.user_id === this.spark.userId){
                  result = true;

               }
            })
            return result;
         },
         examineScore: function(score){
            this.zoomScore = score;
            console.log(score);
            this.$refs['zoomModal'].show();
         }
      },
      mounted () {
         this.fetch();
         let self = this;
         //listen here for score submissions
         EventBus.$on('day_changed', payload => {
            console.log(self.day);
            self.fetch();
         })
         this.$on('score-submitted', payload => {
            console.log("I got a new score");
            console.log(payload);
            self.scores.push(payload);
         });
      }
   }

</script>
