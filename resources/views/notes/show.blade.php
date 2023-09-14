@extends('layouts.app')
@section('content')
    <div>
        <h1>
            {{ $note->title }}
        </h1>
        <div>
            {{ $note->content }}
        </div>
    </div>
@endsection
