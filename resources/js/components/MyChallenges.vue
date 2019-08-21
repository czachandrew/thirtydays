<template> 
   <div>
      <h3>Your Challenges</h3>
      <b-table :items="myChallenges" :fields="fields">
         <template slot="title" slot-scope="data">

            <b-img :src="data.item.image" rounded="circle" class="float-left" style="width: 55px; height: auto;"></b-img><a :href="'/challenges/'+ data.item.id"><h5>{{data.item.title}}</h5></a>
         </template>
      </b-table>
   </div>
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
                  key:'title',
                  label: 'Challenge',
                  sortable:true
               },
               {
                  key:'status',
                  label: 'Status',
                  sortable: true,
               },
               {
                  key:'current_day',
                  label: 'Day',
                  sortable: true
               }
            ]
         }
      },
      methods: {
         fetch: function(){
            let self = this;
            axios.get('/api/challenges/mine').then(response => {
               console.log(response);
               self.myChallenges = response.data;
            }).catch(error => {
               console.log(error);
            })
         }
      },
      mounted () {
         this.fetch();
      }
   }

</script>
