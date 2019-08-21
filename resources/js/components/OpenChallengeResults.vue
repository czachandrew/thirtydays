<template> 
<div>
   <ul class="list-group">
      <li  v-for="(challenge, key) in challenges" :class="[{'bg-success': isMember(challenge.id)},'list-group-item']">
         <div class="row">
            <div class="col-md-3">
               <img :src="challenge.image" style="height: 100px; width: auto;" />
            </div>
            <div class="col-md-6">
               <h5 class="font-weight-bold">{{challenge.title}}</h5>
               <p>{{challenge.description}}</p>
               <p><span class="font-weight-bold">Start Date: </span> {{challenge.start_date}}<br>
                  <span class="font-weight-bold">Atheletes: </span> {{challenge.participants.length}}

               </p>
            </div>
            <div class="col-md-3">
               <button v-if="!isMember(challenge.id)" class="btn btn-primary" @click="join(challenge.id)">Join</button>
            </div>
         </div>
      </li>
   </ul>
</div>
</template>
<style>

</style>
<script>
   export default {
      props: ['default', 'user'],
      data() {
         return {
            challenges:[],
            current_user: {},
            my_challenges: [],
         }
      },
      computed: {
         
      },
      methods: {
         join:function(challenge){
            axios.post('/api/challenge/' + challenge + '/join', {}).then(response => {
               console.log(response);
            }).catch(error => {
               console.log(error);
            });
         },
         isMember:function(challengeId){
            return this.my_challenges.includes(challengeId);
         }

      },
      mounted () {
         console.log("table loaded");
         console.log(this.default);
         this.current_user = this.user;
         this.challenges = this.default;
         this.user.challenges.forEach(ele => {
            this.my_challenges.push(ele.id);
         });
         console.log(this.my_challenges);
      }
   }

</script>
