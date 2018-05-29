@extends('layouts.dashboard')

@section('main')
    <post-editor :post="{{ $post }}"></post-editor>
@endsection