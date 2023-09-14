@extends('layouts.auth')
@section('content')
    <div class="flex flex-col items-center justify-center my-5">
        <h1 class="font-bold text-sky-900">
            {{ env('APP_NAME') }}
        </h1>
        <form action="{{ route('auth.register') }}" method="POST" class="flex flex-col space-y-4">
            @csrf
            <input class="rounded-md bg-slate-50 shadow-sm" type="text" placeholder="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <span class="text-red-600">
                    {{ $message }}
                </span>
            @enderror
            <input class="rounded-md bg-slate-50 shadow-sm" type="email" placeholder="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="text-red-600">
                    {{ $message }}
                </span>
            @enderror
            <input class="rounded-md bg-slate-50 shadow-sm" type="password" placeholder="password" name="password" required>
            @error('password')
                <span class="text-red-600">
                    {{ $message }}
                </span>
            @enderror
            <button class="rounded-md text-white bg-blue-500 font-bold py-2" type="submit">
                Crear cuenta
            </button>
            <a href="{{ route('login') }}" class="text-slate-800 text-sm font-light hover:underline cursor-pointer">
                Iniciar sesión
            </a>
        </form>
    </div>
@endsection
