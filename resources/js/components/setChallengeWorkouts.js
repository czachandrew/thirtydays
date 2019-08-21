
<script>
import {Calendar} from 'vue-bootstrap4-calendar';
export default {
	props:['user','challenge'],
	components: {
		Calendar
	},
	data(){
		return {
			scheduleDate: {
				workout_id:'',
				date:'' 
			},
			start_date:'',
			end_date:'',
			scheduledDays: []
		};
	},
	methods: {
		added(event){
			console.log(event);
		},
		eventDeleted(){

		}
	},
	mounted() {
		this.$on('event-added', payload => {
			console.log("event has been added");
			console.log(payload);
		});
	}
};
</script>