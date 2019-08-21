<template> 
   <div v-if="current_day" class="container">
      <div class="row">
         <div class="col-md-8 offset-md-2">
            <div class="card">

               <div class="card-body text-center">
                  <img :src="current_day.workout.gif" />
                  <h4>{{current_day.workout.title}}</h4>
                  <p style="margin-bottom: 10px;">{{current_day.workout.description}}</p>
                  <button class="btn btn-lg btn-primary" @click="enterScore">Submit Score</button>
               </div>
            </div>
            
         </div>
      </div>
      <div class="row">
         <div class="col-md-6">
            <h5>Scores</h5>
            <div v-if="current_day.submissions.length > 0">
               <transition-group name="list" tag="ul">
                  <li class="list-group-item" v-for="(score, key) in orderedSubs" :key="score.id" @click="examineScore(score)">
                     
                     <b-img :src="score.user.photo_url" rounded="circle" style="width: 30px; height: 30px;"></b-img> {{score.user.name}} <i v-if="score.description !== ''" class="fa fa-comment-dots"></i>
                  
                  
                     <button class="btn btn-default btn-sm float-right" style="margin-left:15px;" @click="bump(score.id, key)" :disabled="iBumped(score)"><i class="fa fa-fist-raised fa-rotate-270"></i></button>
                      <span class="float-right">{{score.score}} {{today.workout.type_label}} </span>
                     <!-- <button class="btn btn-danger btn-sm" @click="removeScore(key)">x</button> -->
                 
                  </li>
               </transition-group>
            </div>
         </div>
         <div class="col-md-6">
            <h5>Discussion</h5>
            <comments-component commentable="day" :commentable-id="today.id"></comments-component>
         </div>
      </div>
      
      <b-modal id="score-modal" title="ScoreModal" ref="scoreModal" @ok="handleScoreSubmit">
         <h2>Add your score</h2>
         <div class="row">
            <input class="form-control col-md-4 offset-md-2" v-model="newScore.score" /> 
            <p class="col-md-6">{{today.workout.type_label}}</p>
         </div>
         <label>Notes:</label>
         <textarea class="form-control" v-model="newScore.description"> </textarea>
      </b-modal>
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
                  <h3 class="text-center">{{zoomScore.score}} {{current_day.workout.type_label}}</h3>
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

.list-enter-active,
.list-leave-active,
.list-move {
  transition: 500ms cubic-bezier(0.59, 0.12, 0.34, 0.95);
  transition-property: opacity, transform;
}

.list-enter {
  opacity: 0;
  transform: translateX(50px) scaleY(0.5);
}

.list-enter-to {
  opacity: 1;
  transform: translateX(0) scaleY(1);
}

.list-leave-active {
  position: absolute;
}

.list-leave-to {
  opacity: 0;
  transform: scaleY(0);
  transform-origin: center top;
}
</style>
<script>
   export default {
      props: ['challenge','today'],
      data() {
         return {
            current_day:null,
            submissions:[],
            newScore:{
               score:'',
               description:'',
               challenge_id: '',
               workout_id: '',
               completed: true,
               type:'web'
            },
            zoomScore:{}
         }
      },
      computed: {
         orderedSubs: function(){
            return _.orderBy(this.submissions, 'score');
         },
         zoomModalName: function(){
            if(this.zoomScore.user){
               return this.zoomScore.user.name;
            } else {
               return 'Name missing'
            }
         }
      },
      methods: {
         enterScore: function(){
            this.$refs['scoreModal'].show();
         },
         saveScore: function(){
            this.$refs['scoreModal'].hide();
         },
         examineScore: function(score){
            this.zoomScore = score;
            console.log(score);
            this.$refs['zoomModal'].show();
         },
         closeZoom: function(){
            this.zoomZcore = {};
            //this.$refs['zoomModal'].hide();
         },
         handleScoreSubmit: function(){
            let self = this;
            console.log(this.newScore);
            axios.post('/api/challenge/day/'+ this.current_day.id + '/score', {'score': this.newScore}).then(response => {
               console.log(response.data);
               self.submissions.push(response.data);
               //self.submissions = response.data.submissions;
            }).catch(error => {
               console.log(error);
            })
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
         removeScore: function(id){
            this.submissions.splice(id, 1);
         }
      },
      mounted () {
         this.current_day = this.today;
         console.log(this.today);
         console.log('challenge');
         console.log(this.challenge);
         this.submissions = this.today.submissions;
         this.newScore.workout_id = this.today.workout.id;
         this.newScore.challenge_id = this.challenge.id;
      }
   }

</script>
