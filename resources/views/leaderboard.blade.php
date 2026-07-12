<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leaderboard — ApexMetric</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .shape-triangle { width: 0; height: 0; border-left: 6px solid transparent; border-right: 6px solid transparent; border-bottom: 10px solid currentColor; display: inline-block; }
        .shape-square { width: 8px; height: 10px; background-color: currentColor; transform: rotate(45deg); display: inline-block; }
        .shape-diamond { width: 9px; height: 9px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%); display: inline-block; }
        .shape-pentagon { width: 10px; height: 10px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%); display: inline-block; }
        .shape-hexagon { width: 10px; height: 10px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); display: inline-block; }
    </style>
</head>
<body class="bg-[#0a0a0a] text-zinc-100 antialiased min-h-screen flex flex-col font-sans">
    
    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between border-b border-zinc-900">
        <div class="flex items-center space-x-2">
            <span class="text-xs font-black tracking-[0.4em] uppercase text-white">Apex<span class="text-rose-600">Metric</span></span>
            <span class="text-[9px] bg-amber-500/20 text-amber-400 font-bold uppercase tracking-widest font-mono px-2 py-0.5 rounded">Premium Division</span>
        </div>
        <a href="{{ route('dashboard') }}" class="text-xs uppercase tracking-widest font-semibold text-zinc-500 hover:text-white transition-all">&larr; Dashboard</a>
    </header>

    <main class="py-12 flex-grow max-w-4xl w-full mx-auto px-6">
        <div class="bg-zinc-950 border border-zinc-900 rounded-xl p-8 shadow-2xl space-y-6">
            <div>
                <span class="text-[10px] uppercase tracking-[0.4em] text-amber-400 font-semibold block mb-1">Global Competition</span>
                <h2 class="text-xl font-medium text-white">Leaderboard</h2>
            </div>

            <div class="overflow-hidden border border-zinc-900 rounded-lg">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#121212]/50 border-b border-zinc-900 text-[10px] uppercase tracking-wider text-zinc-500 font-mono">
                            <th class="p-4 text-center w-16">Pos</th>
                            <th class="p-4">Nama Atlet</th>
                            <th class="p-4 text-center">Stamina</th>
                            <th class="p-4 text-center">Power</th>
                            <th class="p-4 text-center">Intel</th>
                            <th class="p-4 text-right">Total Poin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-900/60 font-mono text-xs">
                        @foreach($leaderboard as $index => $player)
                            @php 
                                $pStats = $player->fitness_stats; 
                                $pTier = $player->getTierDetails($player->total_pts);
                            @endphp
                            <tr class="{{ Auth::id() === $player->id ? 'bg-rose-500/5 text-white' : 'text-zinc-400' }} hover:bg-zinc-900/20 transition-all">
                                <td class="p-4 text-center font-bold text-sm text-zinc-500">
                                    @if($index == 0) <span class="text-amber-400">#1</span>
                                    @elseif($index == 1) <span class="text-zinc-300">#2</span>
                                    @elseif($index == 2) <span class="text-amber-600">#3</span>
                                    @else {{ $index + 1 }} @endif
                                </td>
                                <td class="p-4 font-sans font-medium text-white">
                                    <div class="flex items-center gap-2">
                                        <div class="text-transparent bg-clip-text bg-gradient-to-r {{ $pTier['color'] }} flex items-center justify-center">
                                            <span class="shape-{{ $pTier['shape'] }} text-current"></span>
                                        </div>
                                        <div>
                                            <span>{{ $player->name }}</span>
                                            <span class="text-[9px] text-zinc-500 font-mono block uppercase tracking-wider">{{ $pStats['rank_title'] }} ({{ $pStats['rank'] }})</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 text-center text-blue-400 font-bold">{{ $pStats['rank_stamina'] }}</td>
                                <td class="p-4 text-center text-rose-400 font-bold">{{ $pStats['rank_power'] }}</td>
                                <td class="p-4 text-center text-amber-400 font-bold">{{ $pStats['rank_intelligence'] }}</td>
                                <td class="p-4 text-right font-bold text-white text-sm">{{ number_format($player->total_pts) }} PTS</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>