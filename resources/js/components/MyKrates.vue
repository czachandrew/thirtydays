<template> 
<div>
   <h3>My Stuff</h3>
      <ul class="list-group" v-if="krates">
         <li class="list-group-item" v-for="(krate, index) in krates">
            {{index}} : {{krates[index].length}} 
            <button class="btn btn-primary" @click="open(krate, index)"> Open one</button>
            
         </li>
      </ul>
      <b-modal ref="openModal">
         <div class="text-center" v-if="openingKrate">
            <h1>{{openingKrate.krate.title}}</h1>
            <p class="info"> Tap to open!</p>
            <b-img v-bind="mainProps" :src="'/images/' + openingKrate.krate.image" @click="executeOpen" v-if="!spinning"></b-img>
            <!-- show some kind of animation --> 
            <b-spinner variant="primary" label="Spinning" v-if="spinning"></b-spinner>
            <h3 v-if="spinning">{{roll}}</h3>
         </div>
         
      </b-modal>
      <b-modal ref="rewardModal">
            <div class="text-center" v-if="newReward">
               <h3>Well looky what you got... </h3>
               <h1>{{newReward.title}}</h1>

            </div>
         </b-modal>

</div>
</template>
<style scoped>

</style>
<script>
   export default {
      props: ['myKrates'],
      data() {
         return {
            krates: null,
            openingKrate: null,
            openingKrateIndex: null,
            newReward: null,
            spinning: false,
            mainProps: { width: 125, height: 125, class: 'm1' },
            roll: 0
         }
      },
      computed: {
         activeKrates(){

         },
         openedKrates(){

         }
      },
      methods: {
         /** expects an array of krate **/
         open(krateType, index){
            if(krateType.length > 0) {
               this.openingKrate = krateType[0]
               this.openingKrateIndex = index
               this.$refs['openModal'].show();
            } else {
               //thorw an error
               alert('you do not have any of those krates');
            }

         },
         executeOpen(){
            console.log('opening');
            this.spinning = true
            let self = this
            axios.post('/api/krates/open/' + this.openingKrate.id).then(response => {
               self.newReward = response.data
               var roller = setInterval(()=>{
                  this.roll = Math.floor((Math.random() * 100) + 1);
               },200)
               setTimeout(() => {
                  clearInterval(roller);
                  this.openingKrate.status = 'opened';
                  this.spinning = false
                  self.krates[self.openingKrateIndex].splice(0, 1);
                  self.$refs['rewardModal'].show();
                  self.$refs['openModal'].hide();
                  self.openingKrate = null
                  self.openingKrateIndex = null
               }, 2000)
               //now i have the reward
               

               console.log(response);
            }).catch(error => {
               console.log(error);
               this.spinning = false
            })
            

         }
      },
      mounted () {
         console.log("Here are the krates");
         console.log(this.myKrates);
         this.krates = this.myKrates;
      }
   }

</script>
