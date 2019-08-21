Vue.component('create-challenge', {
	props: ['user'],
	data(){
		return {
			challenge: {
				title:'',
				description:'',
				image: '',
				coach_id:''
			},
			gify: {
				apiUrl: 'http://api.giphy.com/v1/gifs',
				apiKey: 'NUK1JXXhJeFJAJU3nJdRebvoEMj9UFC2'
			},
			gifs: null,
			gifQuery: '',
			isTyping: false,
			errors: {}
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
			this.challenge.image = gif.images.original.url;
		},
		save(){
			const url = 'http://thirtydays.test/challenges';
			let self = this;
			
			axios.post(url, self.challenge).then(
				response => {
					console.log("Here is the response");
					console.log(response);
					window.location.href = response.request.responseURL;
				}).catch(error => {
					console.log("There was an error");
					console.log(error);
					console.log(error.response.data.errors);
					self.errors = error.response.data.errors;
				});
		},
		clearForm(){

		},

	},
	mounted(){
		//
	},
	created:function(){
		//this.getGifs();
	}
});