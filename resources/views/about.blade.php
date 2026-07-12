<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About — ApexMetric</title>
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
        <a href="{{ route('dashboard') }}" class="text-xs uppercase tracking-widest font-semibold text-zinc-500 hover:text-white transition-all">&larr; Back Home</a>
    </header>

    <main class="py-20 flex-grow max-w-5xl w-full mx-auto px-6 space-y-16">
        
        <!-- SECTION 01: THE PLATFORM -->
        <div class="space-y-6 max-w-3xl">
            <span class="text-[10px] uppercase tracking-[0.4em] text-rose-500 font-bold block">01 / THE PLATFORM</span>
            <h1 class="text-4xl font-extrabold tracking-tight text-white">Tentang ApexMetric</h1>
            <p class="text-zinc-400 text-sm leading-relaxed font-sans">
                ApexMetric tidak dibangun untuk sekadar menjadi log latihan biasa. Platform ini lahir dari sebuah keresahan nyata para <span class="text-white font-medium">hybrid athlete</span> yang sering kali kesulitan menyeimbangkan antara intensitas endurance (lari/sepeda) dengan weight training (gym). 
            </p>
            <p class="text-zinc-400 text-sm leading-relaxed font-sans">
                Menumpuk metrik dari berbagai device yang terpisah hanya akan menghasilkan tumpukan data mati. Oleh karena itu, kami merancang sistem ini untuk menyatukan dan menerjemahkan konsistensi performa fisik harian Anda ke dalam satu acuan ukur yang presisi—memetakan perjalanan Anda dari seorang Rookie hingga mencapai status tertinggi, Greek God.
            </p>
        </div>

        <div class="w-full h-[1px] bg-zinc-900"></div>

        <!-- SECTION 02: VISION & MISSION -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-start">
            
            <!-- VISI -->
            <div class="space-y-4">
                <span class="text-[10px] uppercase tracking-[0.4em] text-zinc-500 font-bold block">Visi Kami</span>
                <h3 class="text-xl font-bold text-white tracking-tight">Defining the Hybrid Standard</h3>
                <p class="text-zinc-400 text-sm leading-relaxed font-sans">
                    Menjadi ruang analitik personal yang objektif dalam mengukur kapabilitas fisik manusia. Kami percaya bahwa kekuatan murni (power) dan ketahanan batas (stamina) bisa bertumbuh berdampingan tanpa harus mengorbankan kualitas pemulihan tubuh (recovery intel).
                </p>
            </div>

            <!-- MISI -->
            <div class="space-y-4">
                <span class="text-[10px] uppercase tracking-[0.4em] text-zinc-500 font-bold block">Misi Kami</span>
                <ul class="space-y-3 text-zinc-400 text-sm font-sans">
                    <li class="flex items-start space-x-3">
                        <span class="text-rose-500 font-mono text-xs mt-0.5">•</span>
                        <span>Menyediakan algoritma perhitungan skor performa yang adil, berbasis sport science, dan tidak bias pada satu jenis olahraga saja.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-rose-500 font-mono text-xs mt-0.5">•</span>
                        <span>Mempertahankan antarmuka yang gelap, tegas, dan bebas dari distraksi visual agar Anda bisa fokus sepenuhnya pada perkembangan data.</span>
                    </li>
                    <li class="flex items-start space-x-3">
                        <span class="text-rose-500 font-mono text-xs mt-0.5">•</span>
                        <span>Membangun ekosistem pelacakan mandiri yang efisien tanpa beban proses yang memperlambat alur evaluasi harian Anda.</span>
                    </li>
                </ul>
            </div>

        </div>

    </main>

</body>
</html>