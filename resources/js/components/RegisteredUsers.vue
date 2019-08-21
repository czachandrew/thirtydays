<template> 
   <div>
      <div class="row">
         <div class="col">
         <h3 class="pull-left">Registered Atheletes</h3> 
         <button class="btn btn-primary btn-sm pull-right" @click="messageAll">Message All Users</button>
      </div>   
      <table class="table">
         <thead>
            <th>Name</th>
            <th>State</th>
            <th></th>
         </thead>
         <tbody>
            <tr v-for="(user, key) in users">
               <td>{{user.name}}</td>
               <td></td>
               <td>
                  <button class="btn btn-sm btn-primary" @click="contactUser(user)"> Message User </button>
               </td>
            </tr>
         </tbody>
      </table>
   </div>
   </div>
</template>
<style>

</style>
<script>
   export default {
      props:['users'],
      data() {
         return {
            
         }
      },
      methods: {
         contactUser(user){
            //send a message to a user 
            axios.post('/api/message/send', {'to': user, 'subject': subject, 'message': message}).then(response => {

            }).catch(error => {
               console.log(error);
            });
         },
         messageAll(){

         }
      },
      mounted () {

      }
   }

</script>
