<template> 
   <div class="row">
      <div class="col">
   <!-- image goes here --> 
      <img src="/img/lootbox.png" style="width: 160px; height: auto;" />
   <!-- buy button --> 
      <button class="btn btn-danger" @click="buyBox(1)"> Buy a regular box </button>
      <button class="btn btn-primary" @click="buyBox(2)"> Buy a premium box </button>
   <!-- box inventory --> 
   <div class="row">
      <div class="col">
         <button v-bind:disabled="empty" class="btn btn-default" @click="openBox(1)"><img src="/img/lootbox.png" style="width: 160px; height: auto;" /></button>
      </div>
      <div class="col">
         <h3> x {{boxes}}</h3>
      </div>
   </div>
</div>
<div class="col">
   <h3>The Roll</h3>
   <h1>{{roll}}</h1>
   </div>
   </div>
</template>
<style>

</style>
<script>
   export default {
      props:['user'],
      data() {
         return {
            roll: 0,
            updated_gifts: null
         }
      },
      computed: {
         boxes: function(){
            if(this.updated_gifts === null){
               return this.user.progression.gifts;
            } else {
               return this.updated_gifts;
            }
         },
         empty: function(){
            if(this.boxes > 0 ){
               return false;
            } else {
               return true;
            }
         }
      },
      methods: {
         buyBox:function(level) {
            //level is 1 for basic, 2 for premium
            let self = this;
            axios.post('/api/progression/gift/buy', {points: (level * 200), level: level}).then(response => {
               console.log(response);
               self.$emit('purchase-complete', level * 200);
               self.updated_gifts = response.data.progression.gifts;

            }).catch(error => {
               console.log(error);
            });
         },
         openBox: function(type){
            //open a box and return a reward
            let self = this; 
            this.roll = Math.floor((Math.random() * 100) + 1);
            axios.post('/api/progression/gift/open', {roll: this.roll, type:type }).then(response => {
               //let's announc to the application that we have a new reward to procress
                self.$emit('reward-rolled', response.data);
                self.updated_gifts += -1;

               console.log(response); 
            }).catch(error => {
               console.log(error);
            });
         }
      },
      mounted () {

      }
   }

</script>
