@extends('spark::layouts.app')

@section('content')

<create-challenge :user="user" inline-template>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">
				<div class="card">
					<div class="card-header">
						Create a challenge @{{user.name}}
					</div>
					<div class="card-body">
						
						<form class="form" v-on:submit.prevent>
							<div class="form-group">
								<input type="text" class="form-control" name="gifQuery" v-model="gifQuery" @input="isTyping = true" placeholder="Find the right gif..." />
								<div class="row" v-if="gifs !== null && gifs.length > 0" style="overflow-x: scroll; overflow-y: hidden; height: 100px;">
									<div v-if="gifs"  v-for="gif in gifs" class="gif-box flex" >
										<img @click="setGif(gif)" class="gif-image" :src="gif.images.original.url">
									</div>
								</div>
							</div>
							<div class="form-group">
								<img v-if="challenge.image !== ''" style="width: 200px; height: auto;" class="mx-auto"  alt="Gif Image" :src="challenge.image" />
							</div>
							<div :class="['form-group', errors.title ? 'has-error':'']">
								<input class="form-control" type="text" v-model="challenge.title" placeholder="Name this Challenge" style="font-size: 24px;" />
							</div>
							<div :class="['form-group', errors.description ? 'has-error':'']">
								<textarea cols="8" v-model="challenge.description" class="form-control textarea" placeholder="Describe this challenge, goals, what's involved short and sweet">
								</textarea>
							</div>
							<div class="form-group">
								<button class="btn btn-primary" @click="save">Create</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</div>
	
</create-challenge>
@endsection