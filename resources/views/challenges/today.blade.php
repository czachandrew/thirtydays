@extends('spark::layouts.app')
@section('content')

<user-challenge-view :challenge="{{$challenge}}" :today="{{$today}}"></user-challenge-view>


@endsection
