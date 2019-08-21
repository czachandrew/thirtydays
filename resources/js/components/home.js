Vue.component('home', {
    props: ['user', 'recents'],
    data(){
    	return {
    		test: "This is a test",
            challenge_search:'',
            challenge_results:[],
            local_user: {}
    	};
    },
    methods: {
    	createChallenge: function(){
    		alert("Let's build this thing");
    	},
        switchTo: function(switchTo){
            this.local_user.type = switchTo;
        }
    },
    mounted() {
        this.challenge_results = this.recents;
        console.log(this.recents);
        console.log("Here is the current User");
        console.log(this.user);
        this.local_user = this.user;
    }
});
