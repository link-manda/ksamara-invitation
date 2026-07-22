<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Samara Invitation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased flex items-center justify-center min-h-screen relative overflow-hidden">
    <!-- Decor -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 -z-10 blur-3xl opacity-30">
        <div class="w-[40rem] h-[40rem] bg-amber-400 rounded-full mix-blend-multiply filter"></div>
    </div>

    <div class="max-w-xl w-full px-4 text-center">
        <div class="w-16 h-16 bg-amber-600 rounded-2xl flex items-center justify-center text-white font-bold font-serif text-3xl mx-auto mb-8 shadow-lg shadow-amber-600/30">S</div>
        
        <h1 class="text-9xl font-extrabold text-amber-600 tracking-tighter mb-4">@yield('code')</h1>
        <h2 class="text-3xl font-bold text-slate-900 tracking-tight mb-4">@yield('message')</h2>
        <p class="text-slate-600 mb-10 text-lg">
            @yield('description', 'Maaf, terjadi kesalahan saat memproses permintaan Anda.')
        </p>

        <a href="{{ url('/') }}" class="inline-flex justify-center rounded-full bg-amber-600 px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-amber-600/30 hover:bg-amber-500 hover:scale-105 transition duration-300">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>
