<template> 
<div>
   <table class="table" v-if="registered">
      <thead>
         <th>Name</th>
         <th>Level</th>
         <th></th>
      </thead>
      <tbody>
         <tr v-for="(user, key) in registered">
            <td>{{user.name}}</td>
            <td>1</td>
            <td>
               <button class="btn btn-sm btn-default" @click="message(user)">Message</button>
            </td>
         </tr>
      </tbody>
   </table>
</div>
</template>
<style>

</style>
<script>
   export default {
      props:['registered_users'],
      data() {
         return {
            registered:[]
         }
      },
      methods: {
         message(user){
            //console.log(user);
         }
      },
      mounted () {
         this.registered = this.registered_users;
      }
   }

</script>
