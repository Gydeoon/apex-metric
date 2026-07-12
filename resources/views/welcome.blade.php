<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ApexMetric — Hybrid Athlete Rank System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#0a0a0a] text-zinc-100 antialiased min-h-screen flex flex-col justify-between overflow-x-hidden selection:bg-rose-600 selection:text-white font-sans">

    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between border-b border-zinc-900 relative z-50">
        <div class="flex items-center space-x-2">
            <span class="text-xs font-black tracking-[0.4em] uppercase text-white">Apex<span class="text-rose-600">Metric</span></span>
        </div>

        <nav class="flex items-center space-x-3 sm:space-x-6">
            <a href="{{ url('/about') }}" class="text-[10px] sm:text-xs uppercase tracking-widest font-semibold text-zinc-500 hover:text-white transition-all">
                About
            </a>
            
            @auth
                <a href="{{ url('/dashboard') }}" class="bg-zinc-900 text-white border border-zinc-800 text-[10px] sm:text-xs uppercase tracking-widest font-bold px-3 sm:px-5 py-2 sm:py-2.5 rounded-md hover:bg-zinc-800 transition-all shadow-sm">
                    Dashboard &rarr;
                </a>
            @else
                <a href="{{ route('login') }}" class="text-[10px] sm:text-xs uppercase tracking-widest font-semibold text-zinc-500 hover:text-white transition-all">
                    Log In
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="bg-white text-black text-[10px] sm:text-xs uppercase tracking-widest font-bold px-3 sm:px-5 py-2 sm:py-2.5 rounded-md hover:bg-zinc-200 transition-all shadow-sm">
                        Join System
                    </a>
                @endif
            @endauth
        </nav>
    </header>

    <main class="flex-grow flex flex-col items-center justify-center py-20 relative text-center z-10">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-rose-600/5 rounded-full blur-[120px] pointer-events-none -z-10"></div>

        <div class="max-w-4xl mx-auto px-6 space-y-8 relative flex flex-col items-center w-full">
            <div class="text-center">
                <span class="text-[10px] uppercase tracking-[0.5em] text-rose-500 font-bold block mb-3">Your Performance Buddy</span>
                <h1 class="text-4xl sm:text-7xl font-extrabold tracking-tighter text-white leading-tight">
                    Break Your Limit.<br>Reach Tier SS.
                </h1>
            </div>

            <p class="max-w-xl mx-auto text-zinc-400 text-sm sm:text-base font-light leading-relaxed text-center">
                Platform tracker kebugaran, mengubah hasil latihan menjadi poin performa. Dapatkan kalkulasi Rank legendarismu sekarang.
            </p>

            <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-4 w-full max-w-md relative z-30">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full bg-white text-black text-xs uppercase tracking-widest font-bold px-8 py-4 rounded-lg hover:bg-zinc-200 transition-all text-center shadow-lg pointer-events-auto">
                        Buka Dashboard Performance
                    </a>
                @else
                    <a href="{{ route('register') }}" class="w-full bg-white text-black text-xs uppercase tracking-widest font-bold px-8 py-4 rounded-lg hover:bg-zinc-200 transition-all text-center shadow-lg pointer-events-auto">
                        Mulai Track Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="w-full border border-zinc-800 text-zinc-300 text-xs uppercase tracking-widest font-bold px-8 py-4 rounded-lg hover:bg-zinc-900 hover:text-white transition-all text-center pointer-events-auto">
                        Masuk Ke Akun
                    </a>
                @endauth
            </div>

            <div class="grid grid-cols-3 gap-2 sm:gap-8 w-full max-w-lg mx-auto pt-16 border-t border-zinc-900 text-center">
                <div>
                    <p class="text-zinc-500 text-[9px] sm:text-[10px] uppercase tracking-widest">Stats 01</p>
                    <p class="text-white font-mono font-medium text-xs sm:text-sm mt-1">Stamina & Speed</p>
                </div>
                <div class="border-x border-zinc-900 px-1 sm:px-2">
                    <p class="text-zinc-500 text-[9px] sm:text-[10px] uppercase tracking-widest">Stats 02</p>
                    <p class="text-white font-mono font-medium text-xs sm:text-sm mt-1">Power & Strength</p>
                </div>
                <div>
                    <p class="text-zinc-500 text-[9px] sm:text-[10px] uppercase tracking-widest">Stats 03</p>
                    <p class="text-white font-mono font-medium text-xs sm:text-sm mt-1">Intelligence</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="w-full max-w-7xl mx-auto px-6 py-6 border-t border-zinc-900 flex flex-col sm:flex-row items-center justify-between text-zinc-600 text-[11px] font-mono tracking-wide z-50">
        <p>&copy; 2026 ApexMetric. All Rights Reserved.</p>
    </footer>

</body>
</html>