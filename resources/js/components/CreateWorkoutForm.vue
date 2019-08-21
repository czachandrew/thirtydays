<template>
   <div>
    Day {{order}}
      <get-gif @gif-selected="attachGif"></get-gif>
      <div class="card md-offset-2 col-md-12" v-if="workout.gif">
         <div class="card-header">
            <h5 class="title">Attached Gif</h5>
         </div>
         <div class="card-body">
            <img class="image" v-if="workout.gif" :src="workout.gif" style="width: 100%; height: auto; position:relative;" />
         </div>
      </div>
      
      <div class="form-group">
         <label>Title</label>
         <input type="title" class="form-control" v-model="workout.title" name="title" placeholder="Descending sets pushups" />
      </div>
      <div class="form-group">
         <label>Workout Description</label>
         <div class="textarea-emoji-picker">
            <span
              class="emoji-trigger"
              :class="{ 'triggered': showEmojiPicker }"
              @mousedown.prevent="toggleEmojiPicker"
            >
              <svg
                style="width:20px;height:20px"
                viewBox="0 0 24 24"
              >
                <path fill="#888888" d="M20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M10,9.5C10,10.3 9.3,11 8.5,11C7.7,11 7,10.3 7,9.5C7,8.7 7.7,8 8.5,8C9.3,8 10,8.7 10,9.5M17,9.5C17,10.3 16.3,11 15.5,11C14.7,11 14,10.3 14,9.5C14,8.7 14.7,8 15.5,8C16.3,8 17,8.7 17,9.5M12,17.23C10.25,17.23 8.71,16.5 7.81,15.42L9.23,14C9.68,14.72 10.75,15.23 12,15.23C13.25,15.23 14.32,14.72 14.77,14L16.19,15.42C15.29,16.5 13.75,17.23 12,17.23Z" />
              </svg>
            </span>
            <picker v-show="showEmojiPicker" title="Pick your emoji.." emoji="point_up" @select="addEmoji" />
         
         <textarea class="form-control textarea" v-model="workout.description" name="description" placeholder="Describe the workout" @input="$emit('input', $event.target.value)" ref="textarea"></textarea>
         </div>
      </div>
      
      <div class="form-group">
         <label class="control-label" for="linkedExercises">Link Exercises?</label>
         <input type="text" class="form-control" v-model="linked" id="linkedExercises" placeholder="Yes or no" />
      </div>
      <div class="form-group">
         <label class="control-label" for="type">
            Score Type
         </label>
         <select class="form-control" v-model="workout.type">
            <option>For Time</option>
            <option>For Reps/Rounds</option>
            <option>For Completion</option>
            <option>Other (include in description)</option>
         </select>
      </div>
      <div v-show="workout.type == 'For Reps/Rounds'">
         <label>How are we counting this?</label>
         <div class="form-check">
            <input type="radio" class="form-check-input" v-model="workout.type_label" value="rounds" />
            <label class="form-check-label">Rounds</label>
         </div>
         <div class="form-check">
            <input type="radio" class="form-check-input" v-model="workout.type_label" value="reps" />
            <label class="form-check-label">Reps</label>
         </div>
         <div class="form-check">
            <input type="radio" class="form-check-input" v-model="workout.type_label" value="other" />
            <label class="form-check-label">Other</label>
         </div>
      </div>
      <div class="form-group">
         <label>Attach a youtube video(s)</label>
         <div class="input-group">
            <input type="text" class="form-control" v-model="youtube_video_url" placeholder="Ex: https://youtu.be/m8UQ4O7UiDs" />
            <div class="input-group-append">
               <button class="btn btn-primary" type="button" @click="attachVideo">Attach</button>
            </div>
            
         </div>
         <small>Copy and paste a YouTube link here</small>
         
      </div>
      <div class="form-group">
         <ul class="list-group">
            <li class="list-group-item" v-for="(video, key) in videos">
               {{video}}
               <button class="btn btn-primary pull-right" @click="removeVideo(key)"><i class="fas fa-igloo"></i></button>
            </li>
         </ul>
      </div>
      <div class="form-group" v-show="workout.type_label == 'other'">
         <label>Enter a label for this type</label>
         <input type="text" class="form-control" v-model="workout.type_label" />
      </div>
      <div class="form-group">
         <button class="btn btn-default" @click="createWorkout">Create Workout</button>
      </div>
   </div>
</template>
<style scoped>
* {
  box-sizing: border-box;
}
.textarea-emoji-picker {
  position: relative;
  width: 400px;
  margin: 0 auto;
}
.textarea {
  width: 100%;
  min-height: 300px;
  /*outline: none;
  box-shadow: none;*/
  /*padding: 10px 28px 10px 10px;*/
  font-size: 15px;
  border: 1px solid #BABABA;
  color: #333;
  border-radius: 2px;
  box-shadow: 0px 2px 4px 0 rgba(0,0,0,0.1) inset;
  resize: vertical;
}
.emoji-mart {
  position: absolute;
  top: 33px;
  right: 10px;
}
.emoji-trigger {
  position: absolute;
  top: 10px;
  right: 10px;
  cursor: pointer;
  height: 20px;
}
.emoji-trigger path {
  transition: 0.1s all;
}
.emoji-trigger:hover path {
  fill: #000000;
}
.emoji-trigger.triggered path {
  fill: darken(#FEC84A, 15%);
}
</style>
<script>
import { Picker } from 'emoji-mart-vue';
export default {
   props: {
      challengeId: {
         type: Number,
         required: false
      },
      week: {
         type: String,
      },
      order: {
        type: Number,
        required: false
      },
      day: {
        type: Number, 
        required: true
      }
   },
   components: { Picker },
   data(){
      return {
         workout: {
            title:'',
            gif: '', 
            description: '',
            type:'',
            type_label: 'completion'
         },
         linked: 'no',
         showEmojiPicker: false,
         youtube_video_url:'',
         videos: []
      };
   },
   methods: {
      toggleEmojiPicker () {
         this.showEmojiPicker = !this.showEmojiPicker;
      },
      addEmoji (emoji) {
         console.log(emoji.native);
        const textarea = this.$refs.textarea;
        //console.log(textarea);
        const cursorPosition = textarea.selectionEnd;
        console.log(cursorPosition);
        const start = this.workout.description.substring(0, textarea.selectionStart);
        const end = this.workout.description.substring(textarea.selectionStart);
        console.log(start);
        console.log(end);
        const text = start + emoji.native + end;
        this.$emit('input', text);
        this.workout.description = text;
        textarea.focus();
        this.$nextTick(() => {
          textarea.selectionEnd = cursorPosition + emoji.native.length;
        });
      },
      attachGif(payload){
         console.log("Caught the event!");
         console.log(payload);
         this.workout.gif = payload;
      },
      attachVideo(){
         if(this.youtube_video_url !== ''){
            this.videos.push(this.youtube_video_url);
            this.youtube_video_url = '';
         }
         //this.videos.push();
      },
      createWorkout(){
         //submit
         let self = this;
         axios.post('/api/workouts/' + self.day + '/create', {workout: self.workout, order: self.order}).then(response => {
            console.log("A workout has been successfully created");
            console.log(response);
            self.$emit('created', response.data);
            //here we should reset that entire form
         }).catch(error => {
            console.log("There was some error creating the workout");
            console.log(error);
         });

      },
      removeVideo(key){
         this.videos.splice(key, 1);
      }

   },
   mounted(){
    console.log("Here is the order");
    console.log(this.order);
    console.log("here is the week");
    console.log(this.week);
      let self = this;
      this.$on('gif-selected', payload => {
         console.log("Gif Event has fired");
         console.log(payload);
         self.challenge.gif = payload;

      });
      if(self.order > 30){
        alert('You must remove a workout before adding one');
      }
   }
};
</script>