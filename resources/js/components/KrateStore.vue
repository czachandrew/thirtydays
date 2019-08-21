<template> 
   <div>
      <h1>Krates</h1>
      <ul class="list-group">
         <li class="list-group-item" v-for="(krate, index) in krates">
            <div class="row">
         <div class="col">
            <b-img :src="'/images/' + krate.image" v-bind="mainProps" rounded="circle" alt="Circle image"></b-img>
         </div>
         <div class="col">
            <span class="bold">{{krate.title}}</span><br>{{krate.description}}
         </div>
         <div class="col">
            {{krate.cost}} xp
         </div>
         <div class="col">
            <button class="btn btn-primary" @click="buyKrate(krate)"> Buy</button>
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
      data() {
         return {
            krates:[],
            mainProps: { width: 75, height: 75, class: 'm1' }
         }
      },
      methods: {
         getKrates(){
            let self = this;
            axios.get('/api/krates/list').then(response => {
               console.log(response);
               //check here for insufficient funds 

               self.krates = response.data
            }).catch(error => {
               console.log(error);
            })
         },
         buyKrate(krate){
            console.log(krate)
            axios.get('/api/krates/buy/' + krate.id).then(response => {
               console.log(response);
            }).catch(error => {
               console.log(error);
            })
         }
      },
      mounted () {
         this.getKrates();
      }
   }

</script>
