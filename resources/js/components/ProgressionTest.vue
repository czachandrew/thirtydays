<template>
<div class="card">
   <div class="card-body">
      <div class="row">
         <div class="col">
            <h4>{{user.name}}</h4>
            <p>Next Level: {{user.progression.next_level}}</p>
         </div>
      </div>
      <div class="row">
         <div class="col">
            <button v-bind:disabled="adding" @click="awardExperience" class="btn btn-primary">+100 xp</button>
            <h4>Lifetime xp: {{userXp}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Wallet xp: {{walletXp}}</h4>
            <h3>Current Level: {{level}}</h3>
            <my-krates :my-krates="myKrates"></my-krates>
            <!-- <ul class="list-group">
               <li class="list-group-item" v-for="(krate, index) in myKrates">
                  {{index}} : {{myKrates[index].length}} 

               </li>
            </ul> -->
         </div>
         <div class="col">
            <!-- <box-store :user="user" v-on:reward-rolled="newReward" v-on:purchase-complete="updateWallet">

            </box-store> -->
            <krate-store></krate-store>

         </div>
      </div>
      <div class="row">
         <div class="col">
            <h4>Rewards</h4>
            <ul class="list-group">
               <li v-for="(reward, index) in rewards" :key="index" class="list-group-item" v-if="reward.pivot.status !== 'redeemed'">
                  <div class="col">
                  {{reward.title}} 
                  {{reward.description}}
               </div>
               <div class="col">
                  <button class="btn btn-sm btn-primary pull-right" @click="redeemReward(reward, index)">Redeem</button>
               </div>
               </li>
            </ul>
         </div>
         <div class="col">

         </div>
      </div>
   </div>
</div>   

</template>
<script>
   export default{
      props:['user', 'myKrates'],
      computed:{
         userXp: function(){
            if(this.updated_xp === null){
               return this.user.progression.lifetime_xp
            } else {
               return this.updated_xp;
            }
            
         },
         level: function(){
            if(this.updated_level === null){
               return this.user.progression.level
            } else {
               return this.updated_level;
            }
            
         },
         walletXp: function(){
            if(this.updated_wallet === null){
               return this.user.progression.current_xp
            } else {
               return this.updated_wallet
            }
         },
         rewards: function(){
            if(this.updated_rewards === null){
               return this.user.rewards;
            } else {
               return this.updated_rewards;
            }
         }
      },
      data(){
         return {
            updated_xp: null,
            updated_level: null,
            updated_wallet: null,
            updated_rewards:null,
            adding: false

         }
      },
      methods:{
         awardExperience: function(){
            let self = this;
            this.adding = true;
            axios.post('/api/progression/award/experience',{user:this.user,amount: 100 }).then(response => {
               console.log(response);
               self.updated_xp = response.data.progression.lifetime_xp;
               self.updated_level = response.data.progression.level;
               self.updated_wallet = response.data.progression.current_xp;
               self.adding = false;
            }).catch(error => {
               console.log(error);
            });
         },
         redeemReward: function(reward, index){
            let self = this;
            axios.post('/api/progression/gift/redeem', {reward: reward.id, pivot: reward.pivot.id}).then(response => {
               console.log(response);
               console.log('ok time to splice');
               //self.user.rewards[index].pivot.status = 'redeemed';
               self.updated_rewards = response.data.rewards;
               self.updated_xp = response.data.progression.lifetime_xp;
               self.updated_wallet = response.data.progression.current_xp;

               //self.user.rewards.splice(index, 1);
            }).catch(error => {
               console.log(error);
            })

             //self.user.rewards.splice(index, 1);
         },
         newReward: function(event){
            console.log("here we go"); 
            console.log(event);
            this.updated_rewards = event.rewards;
         },
         updateWallet: function(event){

            this.updated_wallet = Number(this.walletXp - event);
         }

      },
      mounted(){
         console.log('Progression Test has been mounted');
         //console.log(this.user.krates);
         console.log(this.myKrates);


      }
   }
</script>