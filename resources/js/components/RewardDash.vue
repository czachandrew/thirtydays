<template> 
   <div>
      <table class="table">
         <thead>
            <th>Title</th>
            <th>Description</th>
            <th>Type</th>
            <th>Rank</th>
            <th>Stock</th>
            <th><b-button v-b-modal.modal-1>Add Reward</b-button></th>
         </thead>
         <tbody>
            <tr v-for="(reward, index) in currentRewards" :class="{'table-info': reward.status === 'disabled', 'table-danger': reward.stock < 10}">
               <td>{{reward.title}}</td>
               <td>{{reward.description}}</td>
               <td>{{reward.type}}</td>
               <td>{{reward.rank}}</td>
               <td>{{reward.stock}}</td>
               <td>
                  <button class="btn btn-sm btn-warining" @click="editReward(reward, index)">Edit</button>
                  <button class="btn btn-sm btn-danger">Disable</button>
               </td>
            </tr>
         </tbody>
      </table>
      <b-modal id="modal-1" ref="rewardModal" :title="modalTitle">
            <div class="text-center" v-if="!show">
               <b-spinner
                 variant="primary"
                 type="grow"
               ></b-spinner>
            </div>
         <b-form @submit.prevent="onSubmit" @reset.prevent="onReset" v-if="show">
            <b-form-group label="Name this reward">
               <b-form-input v-model="newReward.title"></b-form-input>
            </b-form-group>
            <b-form-group label="Provide some extra description about this reward and how it works">
               <b-form-input v-model="newReward.description"></b-form-input>
            </b-form-group>
            <b-form-group label="Redeemable?" description="Can a user hang on to this reward and redeem it later?">
               <b-form-checkbox
                  id="checkbox-1"
                  v-model="newReward.redeemable"
                  name="checkbox-1"
                  value="1"
                  unchecked-value="0"
                >
                  A user can redeem this reward later
                </b-form-checkbox>
            </b-form-group>
            <b-form-group label="Reward Type" description="This determines what types of boxes your reward will appear in.">
               <b-form-select v-model="newReward.type" :options="rewardTypeOptions"></b-form-select>
            </b-form-group>
            <b-form-group label="Reward Rarity" description="How often should this reward come out of a krate">
               <b-form-select v-model="newReward.rank" :options="rewardTierOptions"></b-form-select>
            </b-form-group>
            <b-form-group label="Stock" description="How many of these are you prepared to give away">
               <b-form-input v-model="newReward.stock" />
            </b-form-group>
            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button type="reset" variant="danger">Reset Form</b-button>
         </b-form>
      </b-modal>
   </div>
</template>
<style>

</style>
<script>
   export default {
      props:['rewards'],
      data() {
         return {
            currentRewards: this.rewards,
            show: true,
            editMode: false,
            modalTitle: 'Create Reward',
            indexOfFocus: null,
            rewardTarget: null,
            rewardTypeOptions:[
               {value: 'food', text: 'Food and drink'}, 
               {value: 'experience', text: 'Experiences'},
               {value: 'gift', text: 'Physical items'},
               {value: 'digital', text: 'Digital items like currencies or download codes'},
               {value: 'app', text: 'Rewards to be used in KrateLyfe app' }
            ],
            rewardTierOptions: [
               {value: 0, text: 'Premium (almost never)'},
               {value: 1, text: 'Classy (a little less than 10%)'},
               {value: 2, text: 'Meat and Potates (decent reward somewhat frequent)'},
               {value: 3, text: 'Consolation Prizes (lots of these will pop)'}
            ],
            newReward:{
               title:'',
               description: '',
               redeemable: true, 
               image:'/rewards/default.png', 
               type:'gift', 
               rank: 0,
               stock: 0
            } 
         }
      },
      methods: {
         onSubmit(){
            if(this.editMode === true){
               this.updateReward();
            } else {

               this.createReward();
            }
         },
         createReward(){
            this.show = false; 
            let self = this;
            axios.post('/api/progression/rewards/create', {reward:this.newReward}).then(response => {
               console.log(response);
               self.onReset();
            }).catch(error => {
               self.show = true;
               console.log(error);
            })
         },
         updateReward(){
            this.show = false;
            let self = this
            console.log(this.newReward);
            axios.post('/api/progression/rewards/update/', {reward: this.rewardTarget, data:this.newReward}).then(response => {
               console.log(response)
               this.rewards.splice(this.indexOfFocus, 1, response.data);
               self.onReset();
            }).catch(error => {
               self.show = true;
               console.log(error)
            })
         },
         editReward(reward, index){
            this.editMode = true;
            console.log(reward);
            this.modalTitle = 'Edit Reward'
            this.indexOfFocus = index;
            this.rewardTarget = reward.id
            this.newReward.title = reward.title;
            this.newReward.description = reward.description
            this.newReward.redeemable = reward.redeemable
            this.newReward.type = reward.type
            this.newReward.rank = reward.rank
            this.newReward.stock = reward.stock
            this.$refs['rewardModal'].show();
         },
         onReset(evt){
            this.editMode = false; 
            this.rewardTarget = null;
            this.newReward.title = '';
            this.newReward.description = ''
            this.newReward.redeemable = true
            this.newReward.type = 'gift'
            this.newReward.rank = 0
            this.newReward.stock = 0
            this.$nextTick(() => {
               this.show = true;
            })
            this.$refs['rewardModal'].hide();
         },
         addStock(){

         },
         disableReward(reward, index){
            axios.get('/api/progression/rewards/disable/' + reward.id).then(response => {
               console.log(response);
               self.rewards.splice(index, 1, response.data);
            }).catch(error => {
               console.log(error);
            })
         }
      },
      mounted () {

      }
   }

</script>
