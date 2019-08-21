<template> 
<div>
   <ul class="list-group" v-if="users">
      <li class="list-group-item" v-for="(user, index) in users">
         <p>{{user.name}}</p>
         <button class="btn btn-primary" @click="sendRequest(user)"> Add Friend</button>
      </li>
   </ul>
   <ul class="list-group" v-if="requests">
      <li class="list-group-item" v-for="(request, index) in myRequests">
         <p>{{request.sender.name}}</p>
         <button class="btn btn-sm btn-primary" @click="acceptRequest">Accept</button>
      </li>
   </ul>
</div>
</template>
<style>

</style>
<script>
   export default {
      data() {
         return {
            friends:[],
            users: null,
            showing: false,
            requests: null
         }
      },
      computed:{
         myRequests(){
            return Object.assign({}, this.requests)
         }
      },
      methods: {
         sendRequest(friend){
            axios.post('/api/friends/request/send', friend).then(response => {
               console.log(response);
               alert("Sent");
            }).catch(error => {
               console.log(error);
            })
         },
         getUsers(){
            let self = this;
            axios.get('/api/users/list').then(response => {
               console.log(response); 
               self.users = response.data;
            }).catch(error => {
               console.log(error);
            })
         },
         getData(){
            let self = this
            axios.get('/api/friends').then(response => {
               console.log(response);
               self.requests = response.data.requests
               self.friends = response.data.friends
            })
         },
         acceptRequest(){

         }
      },
      mounted () {
         this.getUsers()
         this.getData()
      }
   }

</script>
