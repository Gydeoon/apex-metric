<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — ApexMetric</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0a0a0a] text-zinc-100 min-h-screen flex items-center justify-center font-sans antialiased px-4">
    <div class="w-full max-w-md bg-zinc-950 border border-zinc-900 rounded-2xl p-8 shadow-2xl space-y-6">
        <div class="text-center">
            <h1 class="text-xs font-black tracking-[0.4em] uppercase text-white mb-2">Apex<span class="text-rose-600">Metric</span></h1>
            <p class="text-xs text-zinc-500 font-mono">Buat akun untuk memulai rekam performa</p>
        </div>

        <!-- BOX WARNING UTAMA JIKA ADA ERROR VALIDASI GLOBAL -->
        @if($errors->any())
            <div class="p-3 bg-rose-500/10 border border-rose-500/30 text-rose-400 text-xs rounded-lg font-mono">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-[10px] uppercase tracking-wider text-zinc-400 font-medium mb-1.5 font-mono">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full bg-[#121212] border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white focus:border-rose-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-wider text-zinc-400 font-medium mb-1.5 font-mono">Alamat Email</label>
                <!-- Input email mempertahankan value lama menggunakan old() jika terjadi error submit -->
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-[#121212] border @error('email') border-rose-500 @else border-zinc-800 @enderror rounded-lg px-4 py-3 text-sm text-white focus:border-rose-500 outline-none transition-all">
                
                <!-- ERROR INDIKATOR SPESIFIK TEPAT DI BAWAH KOLOM EMAIL -->
                @error('email')
                    <span class="text-[10px] text-rose-400 font-mono mt-1 block">Alamat email ini sudah terdaftar di platform kami.</span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-zinc-400 font-medium mb-1.5 font-mono">Password</label>
                    <input type="password" name="password" required class="w-full bg-[#121212] border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white focus:border-rose-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-wider text-zinc-400 font-medium mb-1.5 font-mono">Konfirmasi</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-[#121212] border border-zinc-800 rounded-lg px-4 py-3 text-sm text-white focus:border-rose-500 outline-none transition-all">
                </div>
            </div>

            <button type="submit" class="w-full bg-white hover:bg-zinc-200 text-black font-semibold text-xs uppercase tracking-widest py-3.5 rounded-lg transition-all mt-2 shadow-md">
                Create Account
            </button>
        </form>

        <div class="text-center pt-2 border-t border-zinc-900/60">
            <p class="text-xs text-zinc-500 font-sans">Sudah punya akun? <a href="{{ route('login') }}" class="text-rose-400 hover:underline">Masuk di sini</a></p>
        </div>
    </div>
</body>
</html>