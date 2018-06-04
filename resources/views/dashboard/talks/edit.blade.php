@extends('layouts.dashboard')

@section('main')
    <talk-editor :talk="{{ $talk }}"></talk-editor>
@endsection