@extends('spark::layouts.app')

@section('content')
<progression-dash :user="{{$user}}" :users="{{$users}}">

</progression-dash>

@endsection