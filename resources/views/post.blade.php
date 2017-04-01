@extends('layouts.master')

@section('content')
    {!! $post->markdown() !!}
@endsection