<template>
   <div class="form-group">
      <input type="text" class="form-control" name="gifQuery" v-model="gifQuery" @input="isTyping = true" placeholder="Find the right gif..." />
      <div class="row" v-if="gifs !== null && gifs.length > 0" style="overflow-x: scroll; overflow-y: hidden; height: 100px;">
         <div v-if="gifs"  v-for="gif in gifs" class="gif-box flex" >
            <img @click="setGif(gif)" class="gif-image" :src="gif.images.original.url">
         </div>
      </div>
   </div>
</template>
<script>
export default {
   props: {
      value: {
         type: String,
         default: ''
      }
   },
   data(){
      return{
         gify: {
            apiUrl: 'http://api.giphy.com/v1/gifs',
            apiKey: 'NUK1JXXhJeFJAJU3nJdRebvoEMj9UFC2'
         },
         gifs: null,
         gifQuery: '',
         isTyping: false,
      };
   },
   watch: {
      gifQuery: _.debounce(function(){
         this.isTyping = false;
      }, 1000),
      isTyping: function(value){
         if(!value) {
            this.searchGifs(this.gifQuery);
         }
      }
   },
   methods: {
      getGifs(){
         const url = `${this.gify.apiUrl}/trending?api_key=${this.gify.apiKey}`;
         fetch(url)
            .then(response => response.json())
            .then(data => this.gifs = data.data);
      },
      searchGifs(query){
         const url = `${this.gify.apiUrl}/search?api_key=${this.gify.apiKey}&q=${query}&limit=8`;
         fetch(url)
            .then(response => response.json())
            .then(data => this.gifs = data.data);
      },
      setGif(gif){
         console.log("set gif fired!");
         console.log(gif);
         this.$emit('gif-selected', gif.images.original.url);
         this.clearForm();
         //this.challenge.image = gif.images.original.url;
      },
      clearForm(){
         this.gifs = null;
         this.gifQuery = '';
      },

   },
};
</script>