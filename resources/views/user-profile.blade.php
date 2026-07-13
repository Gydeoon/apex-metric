<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile — {{ $user->name }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'], } } } }</script>
    <style>
        /* ENGINE GEOMETRI KUSTOM APEXMETRIC */
        .shape-triangle { width: 0; height: 0; border-left: 6px solid transparent; border-right: 6px solid transparent; border-bottom: 11px solid currentColor; display: inline-block; }
        .shape-square { width: 9px; height: 9px; background-color: currentColor; transform: rotate(45deg); display: inline-block; }
        .shape-diamond { width: 10px; height: 10px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%); display: inline-block; }
        .shape-pentagon { width: 11px; height: 11px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%); display: inline-block; }
        .shape-hexagon { width: 11px; height: 11px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); display: inline-block; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-zinc-100 antialiased min-h-screen flex flex-col font-sans">
    
    @php
        $stats = $user->fitness_stats;
        $staminaPct = min(($stats['stamina'] / 15000) * 100, 100);
        $powerPct = min(($stats['power'] / 15000) * 100, 100);
        $intelligencePct = min(($stats['intelligence'] / 5000) * 100, 100);
    @endphp

    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between border-b border-zinc-900 z-50">
        <div class="flex items-center space-x-2">
            <span class="text-xs font-black tracking-[0.4em] uppercase text-white">Apex<span class="text-rose-600">Metric</span></span>
        </div>
        <a href="{{ route('leaderboard') }}" class="text-xs uppercase tracking-widest font-semibold text-zinc-500 hover:text-white transition-all">&larr; Back To Leaderboard</a>
    </header>

    <main class="py-12 flex-grow max-w-7xl w-full mx-auto px-6 space-y-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <div class="bg-zinc-950 border border-zinc-900 rounded-xl p-8 flex flex-col justify-between shadow-2xl relative overflow-hidden min-h-[420px]">
                <div class="absolute top-0 right-0 w-32 h-32 bg-zinc-800/10 rounded-full blur-3xl"></div>
                
                <div>
                    <span class="text-[10px] uppercase tracking-[0.4em] text-rose-500 font-bold block mb-1">Athlete Profile</span>
                    <h2 class="text-white text-xl font-bold tracking-tight">{{ $user->name }}</h2>
                    <p class="text-[11px] text-zinc-500 font-mono mt-0.5">Joined {{ $user->created_at->format('M Y') }}</p>
                </div>

                <div class="my-6 flex items-baseline space-x-4">
                    <span class="text-8xl font-extrabold tracking-tighter text-transparent bg-clip-text bg-gradient-to-b {{ $stats['rank_color'] }} drop-shadow-md">
                        {{ $stats['rank'] }}
                    </span>
                    <div class="text-zinc-400 text-xs tracking-wider flex flex-col">
                        <span class="text-zinc-500 text-[9px] uppercase font-mono tracking-widest">Division Rank</span>
                        <span class="text-white font-bold text-sm tracking-normal mt-0.5">{{ $stats['rank_title'] }}</span>
                        <p class="text-zinc-400 font-medium font-mono text-[11px] mt-1">{{ number_format($stats['total']) }} TOTAL PTS</p>
                    </div>
                </div>

                <div class="space-y-4 border-t border-zinc-900/60 pt-5">
                    <div>
                        <div class="flex justify-between text-xs mb-1 font-mono">
                            <span class="text-zinc-400">STAMINA & SPEED</span>
                            <div class="flex items-center gap-1.5 {{ $stats['color_stamina'] }} text-[10px] font-bold">
                                <span class="shape-{{ $stats['badge_stamina'] }} text-current"></span>
                                <span>{{ $stats['rank_stamina'] }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-zinc-900 h-[3px] rounded-full overflow-hidden">
                            <div class="bg-blue-500 h-full" @style(["width: {$staminaPct}%"])></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs mb-1 font-mono">
                            <span class="text-zinc-400">POWER & STRENGTH</span>
                            <div class="flex items-center gap-1.5 {{ $stats['color_power'] }} text-[10px] font-bold">
                                <span class="shape-{{ $stats['badge_power'] }} text-current"></span>
                                <span>{{ $stats['rank_power'] }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-zinc-900 h-[3px] rounded-full overflow-hidden">
                            <div class="bg-rose-600 h-full" @style(["width: {$powerPct}%"])></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs mb-1 font-mono">
                            <span class="text-zinc-400">RECOVERY INTEL</span>
                            <div class="flex items-center gap-1.5 {{ $stats['color_intelligence'] }} text-[10px] font-bold">
                                <span class="shape-{{ $stats['badge_intelligence'] }} text-current"></span>
                                <span>{{ $stats['rank_intelligence'] }}</span>
                            </div>
                        </div>
                        <div class="w-full bg-zinc-900 h-[3px] rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-full" @style(["width: {$intelligencePct}%"])></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 bg-zinc-950 border border-zinc-900 rounded-xl p-8 shadow-2xl min-h-[420px]">
                <div class="mb-6">
                    <span class="text-[10px] uppercase tracking-[0.4em] text-zinc-500 font-semibold block mb-1">Performance Verification</span>
                    <h3 class="text-lg font-medium text-white">Recent Activity Metrics</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-900 text-[10px] uppercase tracking-wider text-zinc-500">
                                <th class="pb-4 font-semibold">Tanggal</th>
                                <th class="pb-4 font-semibold">Jenis Aktivitas</th>
                                <th class="pb-4 font-semibold">Durasi</th>
                                <th class="pb-4 font-semibold text-center">Output</th>
                                <th class="pb-4 font-semibold text-right">Efisiensi Metrik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-900/40 text-sm font-mono">
                            @forelse ($activities as $activity)
                                <tr class="text-zinc-300 hover:bg-zinc-900/10 transition-all">
                                    <td class="py-4 text-zinc-500 text-xs">{{ $activity->created_at->format('d M Y') }}</td>
                                    <td class="py-4 capitalize font-sans text-xs font-medium">
                                        @if($activity->type == 'gym') <span class="text-rose-500">Gym / Beban</span>
                                        @elseif($activity->type == 'lari') <span class="text-blue-400">Lari</span>
                                        @elseif($activity->type == 'sepeda') <span class="text-cyan-400">Sepeda</span>
                                        @else <span class="text-amber-400">Rest / Tidur</span> @endif
                                    </td>
                                    <td class="py-4 text-zinc-400 text-xs">
                                        @php
                                            $totalSeconds = (float) $activity->duration_minutes * 60.0;
                                            $h = floor($totalSeconds / 3600);
                                            $m = floor(($totalSeconds % 3600) / 60);
                                        @endphp
                                        {{ $h > 0 ? $h.'j ' : '' }}{{ $m }}m
                                    </td>
                                    <td class="py-4 text-center font-bold text-zinc-100 text-xs">
                                        @if(in_array($activity->type, ['lari', 'sepeda']))
                                            {{ number_format($activity->distance_km, 2) }} KM
                                        @elseif($activity->type == 'gym')
                                            {{ count($activity->gym_data ?? []) }} Gerakan
                                        @else
                                            <span class="text-amber-400/80">Recovery</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right text-xs font-mono text-zinc-300">
                                        @if($activity->type == 'lari' && (float)$activity->distance_km > 0)
                                            @php
                                                $paceDecimal = $activity->duration_minutes / $activity->distance_km;
                                                $paceMinutes = floor($paceDecimal);
                                                $paceSeconds = round(($paceDecimal - $paceMinutes) * 60);
                                            @endphp
                                            <span class="text-blue-400 font-bold">{{ sprintf('%02d:%02d', $paceMinutes, $paceSeconds) }}</span><span class="text-[10px] text-zinc-500">/km</span>
                                        @elseif($activity->type == 'sepeda' && (float)$activity->duration_minutes > 0)
                                            @php $speedKmh = $activity->distance_km / ($activity->duration_minutes / 60); @endphp
                                            <span class="text-cyan-400 font-bold">{{ number_format($speedKmh, 1) }}</span> <span class="text-[10px] text-zinc-500">km/h</span>
                                        @elseif($activity->type == 'gym')
                                            @php
                                                $highest1RM = 0;
                                                foreach($activity->gym_data ?? [] as $wk) {
                                                    $est = (float)($wk['weight']??0) * (1 + ((int)($wk['reps']??0) / 30));
                                                    if($est > $highest1RM) $highest1RM = $est;
                                                }
                                            @endphp
                                            @if($highest1RM > 0)
                                                <span class="text-rose-400 font-bold">Max {{ number_format($highest1RM, 1) }}</span> <span class="text-[10px] text-zinc-500">KG</span>
                                            @else
                                                <span class="text-zinc-600">—</span>
                                            @endif
                                        @else
                                            <span class="text-zinc-500">Optimal</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-zinc-600 text-sm font-sans">Belum ada rekaman aktivitas publik dari atlet ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </main>

</body>
</html>