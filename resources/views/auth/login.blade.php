<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
<div class="container-fluid flex gap-4 p-4 justify-center">
    <div>
        <form method="post" action="{{ route('login.store') }}" class="bg-slate-400 p-6 rounded-lg shadow-md">
            @csrf
            <div class="mb-2">
                <label for="email" class="block uppercase font-bold text-sm mb-2">E-mail</label>
                <input type="email" name="email" class="p-2 rounded w-full" placeholder="Digite o e-mail">
                @error('email') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="mb-2">
                <label for="password" class="block uppercase font-bold text-sm mb-2">Senha</label>
                <input type="password" name="password" class="p-2 rounded w-full" placeholder="Digite o e-mail">
                @error('password') <span class="text-red-600 text-sm mt-1">{{ $message }}</span> @enderror
            </div>
            <div class="flex justify-center">
                <button type="submit" class="bg-green-900 px-6 py-2 rounded text-white hover:bg-green-700 transition-colors">
                    Login
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
