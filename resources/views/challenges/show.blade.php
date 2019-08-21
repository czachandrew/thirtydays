@extends('spark::layouts.app')
@section('content')
<div class="card offset-md-2 col-md-8">
	<!-- <div class="card-header">
		Plan your challenge....
	</div> -->
	<!-- <img class="card-img-top" src="{{$challenge->image}}" alt="Card image cap"> -->
	<div class="card-body">
		<schedule-workouts :user="user" :challenge="{{$challenge}}">
     </schedule-workouts>
	</div>
</div>

@endsection