<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    @vite('resources/css/app.css')
</head>
<body>
    <nav class="flex bg-blue-200 h-16">
        <ul class="container mx-auto flex items-center justify-center space-x-5">
            <li>
                <a href="{{ route('notes.index') }}" class="font-bold cursor-pointer hover:underline text-xl">
                    Notes
                </a>
            </li>
        </ul>
        <div class="flex items-center justify-center my-5">
            <form action="{{ route('auth.logout') }}" method="POST">
                @csrf
                <a href="#" class="bg-sky-700 text-white rounded-md" onclick="document.getElementsByTagName('form')[0].submit()">
                    Cerrar sesión

                </a>
            </form>
        </div>
    </nav>
    @yield('content')
</body>
</html>
