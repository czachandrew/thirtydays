@extends('spark::layouts.app')

@section('content')
<home :user="{{$user}}" :recents="{{$recently_made}}" inline-template>
    <div class="container">
        <!-- Application Dashboard -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-default">
                    <div class="card-header">
                        Let's do it!
                        <button v-if="local_user.type === 'user'" class="btn btn-sm btn-primary pull-right" @click="switchTo('coach')">Go To Coach View</button>
                        <button v-if="local_user.type === 'coach'" class="btn btn-sm btn-success pull-right" @click="switchTo('user')">Go To User View</button>

                    </div>

                    <div class="card-body" v-if="local_user.type === 'admin' || local_user.type === 'coach'">
                        {{__('Your application\'s dashboard.')}}
                        @{{test}}
                         @{{user.name}}
                         <challenges-table ></challenges-table>
                        <a class="btn btn-primary" href="/challenges/new">Create Challenge</a>
                    </div>
                    <div class="card-body" v-if="local_user.type === 'user'">
                        <my-challenges></my-challenges>
                        <h5>Kick ass in 30 days</h5>
                        <b-form-input v-model="challenge_search" placeholder="Search Challenges"></b-form-input>
                        <h3>Here are some challenges you can join </h3>
                        <open-challenges :default="recents" :user="local_user"></open-challenges>
                    </div>
                </div>
            </div>
        </div>
    </div>
</home>
@endsection
