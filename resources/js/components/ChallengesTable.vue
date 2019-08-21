<template> 
   <b-table :items="myChallenges" :busy="isBusy" :fields="fields">
      <template slot="title" slot-scope="data">
        <a :href="'/challenges/' + data.item.id">{{ data.item.title }}</a> <br>
        {{ data.item.description }}
      </template>

      <template slot="creator" slot-scope="data">
         {{data.value.name}}
      </template>

   </b-table>
</template>
<style>

</style>
<script>
   export default {
      data() {
         return {
            myChallenges:[],
            fields: [
               {
                  label: 'Challenge',
                  key:'title'
               },
               {
                  label: 'Creator',
                  key: 'creator'
               },
               'status', 'type', 'start_date', 'end_date'],
            isBusy: true
         };
      },
      methods: {
         getMyChallenges(){

            let self = this;

            axios.get('/api/challenges').then( response => {
               console.log(response);
               self.isBusy = false;
               self.myChallenges = response.data;
            }).catch(error => {
               console.log(error);
            });
         }
      },
      mounted () {
         this.getMyChallenges();
      }
   }

</script>
