@extends('spark::layouts.app')

@section('content')
<progression-test :user="{{$user}}" :my-krates="{{$myKrates}}">

</progression-test>

@endsection