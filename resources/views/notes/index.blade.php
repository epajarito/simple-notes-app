@extends('layouts.app')
@section('content')
    <div class="container max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 my-5 gap-2 lg:gap-4">
        @foreach($notes as $note)
            <div class="flex flex-col justify-center items-center border-2 border-slate-200 space-y-2 p-5">
                <a href="{{ route('notes.show', $note->slug) }}" class="underline text-center">
                    {{ $note->title }}
                </a>
                <a href="{{ route('notes.show', $note->slug) }}" class="w-1/2 self-center bg-gray-500 rounded-md text-white cursor-pointer text-center">
                    See note
                </a>
                <span class="font-light">
                    {{ $note->updated_at }}
                </span>
            </div>
        @endforeach
    </div>
    <div class="flex flex-row items-center justify-center py-5">
        {{ $notes->links() }}
    </div>
@endsection
