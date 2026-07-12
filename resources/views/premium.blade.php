<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upgrade to Premium — ApexMetric</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'], } } } }</script>
</head>
<body class="bg-[#0a0a0a] text-zinc-100 antialiased min-h-screen flex flex-col font-sans">

    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between border-b border-zinc-900 z-50">
        <div class="flex items-center space-x-2">
            <a href="{{ route('dashboard') }}" class="text-xs font-black tracking-[0.4em] uppercase text-white">Apex<span class="text-rose-600">Metric</span></a>
        </div>
        <a href="{{ route('dashboard') }}" class="text-xs uppercase tracking-widest font-semibold text-zinc-500 hover:text-white transition-all">&larr; Back to Dashboard</a>
    </header>

    <div class="py-20 flex-grow flex items-center justify-center">
        <div class="max-w-md w-full px-6">
            
            <div class="bg-zinc-950 border border-zinc-900 rounded-2xl p-8 shadow-2xl relative overflow-hidden group">
                <div class="absolute -top-16 -right-16 w-48 h-48 bg-amber-500/10 rounded-full blur-3xl"></div>
                
                <div class="text-center border-b border-zinc-900 pb-6">
                    <span class="text-[10px] uppercase tracking-[0.4em] text-amber-400 font-semibold block mb-1">Premium Tier Access</span>
                    <h2 class="text-2xl font-bold text-white">Unlock Apex Analytics</h2>
                    <p class="text-zinc-500 text-xs font-mono mt-2">Tingkatkan performa kebugaran hybrid Anda ke level tertinggi</p>
                </div>

                <div class="py-6 text-center">
                    <div class="flex items-baseline justify-center space-x-1">
                        <span class="text-5xl font-extrabold text-white tracking-tight">Rp 49.000</span>
                        <span class="text-zinc-500 text-xs font-mono">/ bulan</span>
                    </div>
                    <p class="text-[10px] text-zinc-600 mt-2">Akses penuh tanpa batas, batalkan kapan saja</p>
                </div>

                <div class="space-y-4 py-4 border-t border-zinc-900 font-sans text-xs text-zinc-300">
                    <div class="flex items-start space-x-3">
                        <span class="text-amber-400 font-bold font-mono">✓</span>
                        <p><strong>Papan Peringkat Global Leaderboard:</strong> Bandingkan akumulasi poin latihan Anda dengan atlet hybrid lainnya di seluruh dunia secara real-time.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="text-amber-400 font-bold font-mono">✓</span>
                        <p><strong>Rank Spesifik Setiap Divisi:</strong> Buka penilaian performa tersendiri pada divisi Stamina & Speed, Power & Strength, serta Recovery Intel.</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <span class="text-amber-400 font-bold font-mono">✓</span>
                        <p><strong>Sains Olahraga Akurat:</strong> Monitor perkembangan estimasi 1-Rep Max (1RM) gym terberat berdasarkan formula sport science komunitas global.</p>
                    </div>
                </div>

                <div class="pt-6 border-t border-zinc-900">
                    <form action="{{ route('premium.simulate') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-black font-bold text-xs uppercase tracking-widest py-4 rounded-xl transition-all shadow-lg shadow-amber-500/5">
                            Beli Sekarang & Buka Fitur
                        </button>
                    </form>
                    <p class="text-center text-[9px] text-zinc-600 mt-3 font-mono">Sistem pembayaran menggunakan mode simulasi SaaS aman</p>
                </div>

            </div>
            
        </div>
    </div>

</body>
</html>