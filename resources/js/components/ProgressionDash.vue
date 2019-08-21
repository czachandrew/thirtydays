<template> 
   <div class="card col-md-12">
      <div class="card-body">
      <div class="row">

         <div class="col">
            <h1>Your Players</h1>
         <table class="table">
            <thead>
               <th>User</th>
               <th>Level</th>
               <th>XP</th>
               <th>Wallet</th>
               <th></th>
            </thead>
            <tbody>
               <tr v-for="(player, index) in players" :key="player.id">
                  <td>
                     <div class="spinner-grow text-primary" role="status" v-if="player.loading">
                       <span class="sr-only">Loading...</span>
                     </div>
                     {{player.name}}
                  </td>
                  <td>{{player.progression.level}}</td>
                  <td>{{player.progression.lifetime_xp}}/{{player.progression.next_level}}</td>
                  <td>{{player.progression.current_xp}}</td>
                  <td>
                     <button class="btn btn-sm btn-primary" @click="awardExperience(player, index)" :disabled="player.loading">Award 100 XP</button>
                     <!-- <button class="btn btn-sm btn-danger" @click="penalizeExperience(player, index)">Penalize</button> -->
                     <button class="btn btn-sm btn-success" @click="giveGift" :disabled="player.loading">Gift Reward</button>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      </div>
<div class="row">
   <div class="col">
      <h1>Rewards Management</h1>
  <!--  <rewards-dash > -->
   <reward-dash :rewards="providedRewards" @rewardAdded="alert(reward)"></reward-dash>
   <friend-list></friend-list>
</div>
</div>
</div>
</div>
</template>
<style>
.loading {
   background-color: red;
}
</style>
<script>
   export default {
      props:['user', 'users'],
      data() {
         return {
            players: this.users,
            providedRewards: this.user.provided_rewards

         }
      },
      methods: {
         awardExperience: function(player, index){
            let self = this;
            player.loading = true;
            Vue.set(this.players, index, player)
            axios.post('/api/progression/award/experience',{user:player, amount: 100 }).then(response => {
               console.log(response);
               //check and see for toasts
               self.players.splice(index, 1, response.data);

            }).catch(error => {
               console.log(error);
            });
         },
         penalizeExperience: function(){

         },
         giveGift: function(){

         }
      },
      mounted () {

      }
   }

</script>
