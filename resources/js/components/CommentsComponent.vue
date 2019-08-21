<template> 
   <div class="row">
      <div class="col">
         <div class="form-group">
            <input type="text" class="form-control" v-model="newComment.content" palceholder="Leave your comment" /> 
         </div>
         <div class="form-group">
            <!-- maybe some help text here --> 
            <button type="button" class="btn btn-primary" @click="saveComment">Add Comment</button>
         </div>
         <transition-group name="list" tag="ul" class="list-group" v-if="comments.length > 0">
            <li v-for="(comment, key) in comments" :key="comment.id" class="list-group-item" style="margin-bottom: 10px;">
               <div class="row">
                  <div class="col-md-2">
                     <b-img :src="comment.user.photo_url" rounded="circle" style="width:50px; height:auto;"></b-img>
                  </div>
                  <div class="col-md-8">
                     <p><b>{{comment.user.name}}</b> {{comment.content}}</p>
                  </div>
               </div>
            </li>
         </transition-group>
      </div>
   </div>
</template>
<style>
   .list-enter-active,
   .list-leave-active,
   .list-move {
     transition: 500ms cubic-bezier(0.59, 0.12, 0.34, 0.95);
     transition-property: opacity, transform;
   }

   .list-enter {
     opacity: 0;
     transform: translateX(50px) scaleY(0.5);
   }

   .list-enter-to {
     opacity: 1;
     transform: translateX(0) scaleY(1);
   }

   .list-leave-active {
     position: absolute;
   }

   .list-leave-to {
     opacity: 0;
     transform: scaleY(0);
     transform-origin: center top;
   }
</style>
<script>
   export default {
      props:{
         commentable: {
            validator: function(value){
               return ['submission','day','challenge'].indexOf(value) !== -1;
            }
         },
         commentableId: {
            type: Number
         }
      },
      data() {
         return {
            newComment: {
               content:'',
            },
            comments:[]
         }
      },
      methods: {
         fetch: function(){
            axios.get('/api/comments/' + this.commentable + '/' + this.commentableId).then(response => {
               console.log(response);
               this.comments = response.data;
            }).catch(error => {
               console.log(error);
            })
         },
         saveComment: function(){
            let self = this;
            //this.newComment.id = this.comments.length + 1;
            //this.comments.push(this.newComment);
            axios.post('/api/comments/' + this.commentable + '/' + this.commentableId, {comment: this.newComment}).then(response => {
               console.log(response);
               self.comments.push(response.data);
               self.newComment.content = ''; 
            }).then(error => {
               console.log(error);
            })
         }
      },
      mounted () {
         this.fetch();
      }
   }

</script>
