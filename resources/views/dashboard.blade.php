<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard — ApexMetric V5</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'], } } } }</script>
    <style>
        /* CSS BADGE ENGINE GEOMETRI KUSTOM */
        .shape-triangle { width: 0; height: 0; border-left: 7px solid transparent; border-right: 7px solid transparent; border-bottom: 12px solid currentColor; }
        .shape-square { width: 10px; height: 10px; background-color: currentColor; transform: rotate(45deg); }
        .shape-diamond { width: 11px; height: 11px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%); }
        .shape-pentagon { width: 12px; height: 12px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 38%, 82% 100%, 18% 100%, 0% 38%); }
        .shape-hexagon { width: 12px; height: 12px; background-color: currentColor; clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%); }
    </style>
</head>
<body class="bg-[#0a0a0a] text-zinc-100 antialiased min-h-screen flex flex-col font-sans">
    
    @php
        $stats = auth()->user()->fitness_stats;
        $staminaPct = min(($stats['stamina'] / 15000) * 100, 100);
        $powerPct = min(($stats['power'] / 15000) * 100, 100);
        $intelligencePct = min(($stats['intelligence'] / 5000) * 100, 100);
    @endphp

    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between border-b border-zinc-900 z-50">
        <div class="flex items-center space-x-2">
            <a href="{{ url('/') }}" class="text-xs font-black tracking-[0.4em] uppercase text-white">Apex<span class="text-rose-600">Metric</span></a>
        </div>
        <div class="flex items-center space-x-6">
            <span class="text-xs font-mono text-zinc-400">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs uppercase tracking-widest font-semibold text-zinc-500 hover:text-rose-500 transition-all">Log Out</button>
            </form>
        </div>
    </header>

    <div class="py-12 flex-grow">
        <div class="max-w-7xl mx-auto px-6 space-y-8">
            
            @if (session('success'))
                <div id="toast-success" class="p-4 bg-zinc-950 border border-emerald-500/30 text-emerald-400 text-sm rounded-lg flex items-center justify-between shadow-xl transition-opacity duration-500">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-zinc-500 hover:text-zinc-300 font-bold">&times;</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm rounded-lg flex items-start justify-between shadow-xl">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                    <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-300 font-bold ml-4">&times;</button>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                
                <div class="bg-zinc-950 border border-zinc-900 rounded-xl p-8 flex flex-col justify-between shadow-2xl relative overflow-hidden group min-h-[440px]">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-rose-600/5 rounded-full blur-3xl duration-500"></div>
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] uppercase tracking-[0.4em] text-zinc-500 font-semibold block mb-1">Current Tier</span>
                            <h2 class="text-zinc-400 text-sm font-medium">Your Rank</h2>
                        </div>
                        <form action="{{ route('premium.simulate') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[9px] uppercase tracking-widest font-mono font-bold px-2 py-1 rounded transition-all {{ auth()->user()->is_premium ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30' : 'bg-zinc-800 text-zinc-400 hover:bg-zinc-700' }}">
                                {{ auth()->user()->is_premium ? 'PREMIUM' : 'FREE' }}
                            </button>
                        </form>
                    </div>

                    <div class="my-4 flex items-baseline space-x-4">
                        <span class="text-8xl font-extrabold tracking-tighter text-transparent bg-clip-text bg-gradient-to-b {{ $stats['rank_color'] }} drop-shadow-md">
                            {{ $stats['rank'] }}
                        </span>
                        <div class="text-zinc-400 text-xs tracking-wider flex flex-col">
                            <span class="text-zinc-500 text-[9px] uppercase font-mono tracking-widest">Division Title</span>
                            <span class="text-white font-bold text-sm tracking-normal mt-0.5">{{ $stats['rank_title'] }}</span>
                            <p class="text-zinc-400 font-medium font-mono text-[11px] mt-1">{{ number_format($stats['total']) }} PTS</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        @if(auth()->user()->is_premium)
                            <a href="{{ route('leaderboard') }}" class="w-full block text-center bg-zinc-900 hover:bg-zinc-800 border border-zinc-800 text-xs uppercase tracking-widest font-semibold py-2.5 rounded-lg transition-all text-amber-400">
                                View Leaderboard &rarr;
                            </a>
                        @else
                            <a href="{{ route('premium.index') }}" class="w-full block text-center bg-gradient-to-r from-amber-500/10 to-amber-600/10 hover:from-amber-500/20 hover:to-amber-600/20 border border-amber-500/30 text-xs uppercase tracking-widest font-bold py-2.5 rounded-lg text-amber-400 transition-all shadow-md">
                                Unlock Leaderboard
                            </a>
                        @endif
                    </div>

                    <div class="space-y-4 border-t border-zinc-900 pt-5">
                        <div>
                            <div class="flex justify-between text-xs mb-1 font-mono">
                                <span class="text-zinc-400">STAMINA & SPEED</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->is_premium)
                                        <div class="flex items-center gap-1.5 bg-blue-900/20 text-blue-400 px-2 py-0.5 rounded text-[10px] font-bold">
                                            <span class="shape-{{ $stats['badge_stamina'] }}"></span>
                                            <span>{{ $stats['rank_stamina'] }}</span>
                                        </div>
                                    @else
                                        <a href="{{ route('premium.index') }}" class="text-[9px] text-amber-400/80 hover:text-amber-400 transition-all font-sans tracking-wide underline">Unlock Rank</a>
                                    @endif
                                    <span class="text-zinc-500">{{ number_format($stats['stamina']) }} pts</span>
                                </div>
                            </div>
                            <div class="w-full bg-zinc-900 h-[3px] rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-full transition-all duration-500" @style(["width: {$staminaPct}%"])></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1 font-mono">
                                <span class="text-zinc-400">POWER & STRENGTH</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->is_premium)
                                        <div class="flex items-center gap-1.5 bg-rose-900/20 text-rose-400 px-2 py-0.5 rounded text-[10px] font-bold">
                                            <span class="shape-{{ $stats['badge_power'] }}"></span>
                                            <span>{{ $stats['rank_power'] }}</span>
                                        </div>
                                    @else
                                        <a href="{{ route('premium.index') }}" class="text-[9px] text-amber-400/80 hover:text-amber-400 transition-all font-sans tracking-wide underline">Unlock Rank</a>
                                    @endif
                                    <span class="text-zinc-500">{{ number_format($stats['power']) }} pts</span>
                                </div>
                            </div>
                            <div class="w-full bg-zinc-900 h-[3px] rounded-full overflow-hidden">
                                <div class="bg-rose-600 h-full transition-all duration-500" @style(["width: {$powerPct}%"])></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between text-xs mb-1 font-mono">
                                <span class="text-zinc-400">RECOVERY INTEL</span>
                                <div class="flex items-center gap-2">
                                    @if(auth()->user()->is_premium)
                                        <div class="flex items-center gap-1.5 bg-amber-900/20 text-amber-400 px-2 py-0.5 rounded text-[10px] font-bold">
                                            <span class="shape-{{ $stats['badge_intelligence'] }}"></span>
                                            <span>{{ $stats['rank_intelligence'] }}</span>
                                        </div>
                                    @else
                                        <a href="{{ route('premium.index') }}" class="text-[9px] text-amber-400/80 hover:text-amber-400 transition-all font-sans tracking-wide underline">Unlock Rank</a>
                                    @endif
                                    <span class="text-zinc-500">{{ number_format($stats['intelligence']) }} pts</span>
                                </div>
                            </div>
                            <div class="w-full bg-zinc-900 h-[3px] rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-full transition-all duration-500" @style(["width: {$intelligencePct}%"])></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 bg-zinc-950 border border-zinc-900 rounded-xl p-8 shadow-2xl">
                    <div class="mb-6">
                        <span class="text-[10px] uppercase tracking-[0.4em] text-rose-500 font-semibold block mb-1">Liftoff Tracker</span>
                        <h3 class="text-xl font-medium text-white">Daily Tracker</h3>
                    </div>

                    <form action="{{ route('activities.store') }}" method="POST" id="activityForm" class="space-y-6">
                        @csrf
                        <div>
                            <label for="type" class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Jenis Aktivitas</label>
                            <select id="type" name="type" required onchange="toggleFormFields()" class="w-full bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg px-4 py-3 text-sm focus:border-rose-500 outline-none cursor-pointer">
                                <option value="lari" {{ old('type') == 'lari' ? 'selected' : '' }}>Lari (Speed & Stamina)</option>
                                <option value="sepeda" {{ old('type') == 'sepeda' ? 'selected' : '' }}>Sepeda (Stamina)</option>
                                <option value="gym" {{ old('type') == 'gym' ? 'selected' : '' }}>Gym / Beban (Power)</option>
                                <option value="rest" {{ old('type') == 'rest' ? 'selected' : '' }}>Rest / Recovery (Intelligence)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                            <div id="duration_input_wrapper">
                                <label id="duration-label" class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Durasi Waktu</label>
                                <div class="grid grid-cols-3 gap-2">
                                    <div><input type="number" name="duration_hours" min="0" max="23" value="{{ old('duration_hours', 0) }}" class="w-full text-center bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg py-2.5 text-sm outline-none focus:border-rose-500"><span class="text-[10px] text-zinc-500 text-center block mt-1 font-mono">JAM</span></div>
                                    <div><input type="number" name="duration_minutes" min="0" max="59" value="{{ old('duration_minutes', 0) }}" class="w-full text-center bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg py-2.5 text-sm outline-none focus:border-rose-500"><span class="text-[10px] text-zinc-500 text-center block mt-1 font-mono">MENIT</span></div>
                                    <div><input type="number" name="duration_seconds" min="0" max="59" value="{{ old('duration_seconds', 0) }}" class="w-full text-center bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg py-2.5 text-sm outline-none focus:border-rose-500"><span class="text-[10px] text-zinc-500 text-center block mt-1 font-mono">DETIK</span></div>
                                </div>
                            </div>

                            <div id="right_dynamic_wrapper">
                                <div id="cardio_wrapper">
                                    <label class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Jarak Tempuh (KM)</label>
                                    <input type="number" id="distance_input" name="distance_km" step="any" min="0.01" value="{{ old('distance_km') }}" placeholder="Contoh: 5.42" class="w-full bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg px-4 py-3 text-sm outline-none focus:border-rose-500">
                                </div>

                                <div id="gym_count_wrapper" class="hidden">
                                    <label class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Jumlah Macam Gerakan</label>
                                    <input type="number" id="workout_count" min="1" max="15" placeholder="Contoh: 5" oninput="generateGymFields()" class="w-full bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg px-4 py-3 text-sm outline-none focus:border-rose-500">
                                </div>
                            </div>
                        </div>

                        <div id="gym_dynamic_fields" class="hidden space-y-4 border-t border-zinc-900 pt-4 mt-2"></div>

                        <div>
                            <label for="notes" class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2 mt-2">Catatan Latihan (Opsional)</label>
                            <input type="text" id="notes" name="notes" value="{{ old('notes') }}" placeholder="Tulis rute, perasaan latihan, dll" maxlength="255" class="w-full bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg px-4 py-3 text-sm focus:border-rose-500 outline-none">
                        </div>

                        <div class="flex justify-end pt-2">
                            <button type="submit" class="w-full sm:w-auto bg-white hover:bg-zinc-200 text-black font-semibold text-xs uppercase tracking-widest px-8 py-3.5 rounded-lg transition-all shadow-md">
                                Submit Log & Update Rank
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-zinc-950 border border-zinc-900 rounded-xl p-8 shadow-2xl">
                <div class="mb-6 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-medium text-white">Activity Log History</h3>
                    </div>
                    <div>
                        <select id="table_filter" onchange="filterTable()" class="bg-zinc-900 border border-zinc-700 text-zinc-300 rounded-lg px-3 py-2 text-xs outline-none focus:border-rose-500 cursor-pointer">
                            <option value="all">Semua Aktivitas</option>
                            <option value="lari">Lari</option>
                            <option value="sepeda">Sepeda</option>
                            <option value="gym">Gym / Beban</option>
                            <option value="rest">Rest / Tidur</option>
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-zinc-900 text-[10px] uppercase tracking-wider text-zinc-500">
                                <th class="pb-4 font-semibold">Tanggal</th>
                                <th class="pb-4 font-semibold">Jenis Latihan</th>
                                <th class="pb-4 font-semibold">Durasi</th>
                                <th class="pb-4 font-semibold text-center">Output Data</th>
                                <th class="pb-4 font-semibold text-center">Metrik (Speed/Max)</th>
                                <th class="pb-4 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody id="activity_tbody" class="divide-y divide-zinc-900/40 text-sm font-mono">
                            @forelse (auth()->user()->activities()->latest()->get() as $activity)
                                <tr class="activity-row text-zinc-300 hover:bg-zinc-900/10 transition-all" data-type="{{ $activity->type }}">
                                    <td class="py-4 text-zinc-500 text-xs">{{ $activity->created_at->format('d M Y - H:i') }}</td>
                                    <td class="py-4 capitalize font-sans text-xs font-medium">
                                        @if($activity->type == 'gym') <span class="text-rose-500">Gym / Beban</span>
                                        @elseif($activity->type == 'lari') <span class="text-blue-400">Lari</span>
                                        @elseif($activity->type == 'sepeda') <span class="text-cyan-400">Sepeda</span>
                                        @else <span class="text-amber-400">Tidur</span> @endif
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
                                            @php $workoutCount = count($activity->gym_data ?? []); @endphp
                                            <span class="text-rose-400">{{ $workoutCount }} Gerakan</span>
                                        @else
                                            <span class="text-amber-400">Tidur</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-center text-xs font-mono text-zinc-300">
                                        @if($activity->type == 'lari' && (float)$activity->distance_km > 0)
                                            @php
                                                $paceDecimal = $activity->duration_minutes / $activity->distance_km;
                                                $paceMinutes = floor($paceDecimal);
                                                $paceSeconds = round(($paceDecimal - $paceMinutes) * 60);
                                                if ($paceSeconds == 60) { $paceMinutes++; $paceSeconds = 0; }
                                            @endphp
                                            <span class="text-blue-400 font-bold">{{ sprintf('%02d:%02d', $paceMinutes, $paceSeconds) }}</span><span class="text-[10px] text-zinc-500">/km</span>
                                        @elseif($activity->type == 'sepeda' && (float)$activity->duration_minutes > 0)
                                            @php $speedKmh = $activity->distance_km / ($activity->duration_minutes / 60); @endphp
                                            <span class="text-cyan-400 font-bold">{{ number_format($speedKmh, 2) }}</span> <span class="text-[10px] text-zinc-500">km/h</span>
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
                                            <span class="text-zinc-600">—</span>
                                        @endif
                                    </td>
                                    <td class="py-4 text-right">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('activities.edit', $activity) }}" class="text-zinc-500 hover:text-blue-400 text-xs font-sans font-medium">Edit</a>
                                            <form action="{{ route('activities.destroy', $activity) }}" method="POST" onsubmit="return confirm('Hapus log?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-zinc-600 hover:text-rose-500 text-xs font-sans font-medium">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-zinc-600 text-sm">Belum ada aktivitas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        const successToast = document.getElementById('toast-success');
        if (successToast) {
            setTimeout(() => {
                successToast.classList.add('opacity-0');
                setTimeout(() => successToast.remove(), 500); 
            }, 3000); 
        }

        function filterTable() {
            const filterValue = document.getElementById('table_filter').value;
            const rows = document.querySelectorAll('.activity-row');

            rows.forEach(row => {
                if (filterValue === 'all' || row.getAttribute('data-type') === filterValue) {
                    row.style.display = ''; 
                } else {
                    row.style.display = 'none'; 
                }
            });
        }

        function toggleFormFields() {
            const type = document.getElementById('type').value;
            const durationLabel = document.getElementById('duration-label');
            const rightWrapper = document.getElementById('right_dynamic_wrapper');
            const cardioWrapper = document.getElementById('cardio_wrapper');
            const distanceInput = document.getElementById('distance_input');
            const gymCountWrapper = document.getElementById('gym_count_wrapper');
            const workoutCountInput = document.getElementById('workout_count');
            const gymDynamicFields = document.getElementById('gym_dynamic_fields');

            if (type === 'rest') {
                durationLabel.innerText = "Durasi Tidur";
                rightWrapper.classList.add('hidden');
                gymDynamicFields.classList.add('hidden');
                distanceInput.required = false;
                workoutCountInput.required = false;
            } else {
                durationLabel.innerText = "Durasi Waktu";
                rightWrapper.classList.remove('hidden');

                if (type === 'lari' || type === 'sepeda') {
                    cardioWrapper.classList.remove('hidden');
                    gymCountWrapper.classList.add('hidden');
                    gymDynamicFields.classList.add('hidden');
                    distanceInput.required = true;
                    workoutCountInput.required = false;
                } else if (type === 'gym') {
                    cardioWrapper.classList.add('hidden');
                    gymCountWrapper.classList.remove('hidden');
                    gymDynamicFields.classList.remove('hidden');
                    distanceInput.required = false;
                    workoutCountInput.required = true;
                }
            }
        }

        function generateGymFields() {
            const count = parseInt(document.getElementById('workout_count').value) || 0;
            const container = document.getElementById('gym_dynamic_fields');
            container.innerHTML = ''; 

            for(let i = 0; i < count; i++) {
                container.innerHTML += `
                    <div class="bg-[#121212] p-5 rounded-xl border border-zinc-800 space-y-4 relative">
                        <div class="text-[10px] text-zinc-600 font-mono absolute top-3 right-4 font-bold">GERAKAN #${i+1}</div>
                        
                        <div>
                            <select name="gym_exercises[${i}][name]" required class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-lg px-4 py-2.5 text-xs outline-none focus:border-rose-500 cursor-pointer">
                                <optgroup label="Dada (Chest)">
                                    <option value="bench_press">Bench Press</option>
                                    <option value="db_bench_press">Dumbbell Bench Press</option>
                                    <option value="incline_db_bench">Incline Dumbbell Bench Press</option>
                                    <option value="chest_press">Chest Press (Machine)</option>
                                    <option value="db_fly">Dumbbell Fly</option>
                                    <option value="machine_chest_fly">Machine Chest Fly</option>
                                    <option value="cable_fly">Cable Fly</option>
                                    <option value="push_ups">Push Ups</option>
                                </optgroup>
                                <optgroup label="Punggung (Back)">
                                    <option value="deadlift">Deadlift</option>
                                    <option value="pull_ups">Pull Ups</option>
                                    <option value="lat_pulldown">Lat Pulldown</option>
                                    <option value="close_grip_lat_pulldown">Close Grip Lat Pulldown</option>
                                    <option value="seated_cable_row">Seated Cable Row</option>
                                    <option value="machine_row">Machine Row</option>
                                    <option value="db_row">Dumbbell Row</option>
                                    <option value="chest_supported_db_row">Chest Supported Dumbbell Row</option>
                                    <option value="db_shrug">Dumbbell Shrug</option>
                                </optgroup>
                                <optgroup label="Kaki (Legs)">
                                    <option value="squat">Squat (Barbell)</option>
                                    <option value="sled_leg_press">Sled Leg Press</option>
                                    <option value="horizontal_leg_press">Horizontal Leg Press</option>
                                    <option value="hack_squat">Hack Squat</option>
                                    <option value="db_lunge">Dumbbell Lunge</option>
                                    <option value="db_bulgarian_split_squat">Dumbbell Bulgarian Split Squat</option>
                                    <option value="db_romanian_deadlift">Dumbbell Romanian Deadlift</option>
                                    <option value="goblet_squat">Goblet Squat</option>
                                    <option value="leg_extension">Leg Extension</option>
                                    <option value="seated_leg_curl">Seated Leg Curl</option>
                                    <option value="lying_leg_curl">Lying Leg Curl</option>
                                    <option value="machine_calf_raise">Machine Calf Raise</option>
                                    <option value="hip_adduction">Hip Adduction</option>
                                </optgroup>
                                <optgroup label="Bahu (Shoulders)">
                                    <option value="shoulder_press">Shoulder Press (Barbell)</option>
                                    <option value="db_shoulder_press">Dumbbell Shoulder Press</option>
                                    <option value="seated_db_shoulder_press">Seated DB Shoulder Press</option>
                                    <option value="machine_shoulder_press">Machine Shoulder Press</option>
                                    <option value="db_lateral_raise">Dumbbell Lateral Raise</option>
                                    <option value="cable_lateral_raise">Cable Lateral Raise</option>
                                    <option value="face_pull">Face Pull</option>
                                </optgroup>
                                <optgroup label="Lengan & Core (Arms/Abs)">
                                    <option value="db_curl">Dumbbell Curl</option>
                                    <option value="hammer_curl">Hammer Curl</option>
                                    <option value="cable_bicep_curl">Cable Bicep Curl</option>
                                    <option value="db_tricep_extension">Dumbbell Tricep Extension</option>
                                    <option value="tricep_pushdown">Tricep Pushdown</option>
                                    <option value="tricep_rope_pushdown">Tricep Rope Pushdown</option>
                                    <option value="cable_crunch">Cable Crunch</option>
                                </optgroup>
                                <optgroup label="Lainnya">
                                    <option value="generic">Latihan Lainnya (Isolasi / Mesin)</option>
                                </optgroup>
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <input type="number" name="gym_exercises[${i}][sets]" required min="1" placeholder="0" class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-lg px-3 py-2.5 text-xs text-center focus:border-rose-500 outline-none">
                                <span class="text-[9px] text-zinc-500 block text-center mt-1.5 font-mono">SETS</span>
                            </div>
                            <div>
                                <input type="number" name="gym_exercises[${i}][reps]" required min="1" placeholder="0" class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-lg px-3 py-2.5 text-xs text-center focus:border-rose-500 outline-none">
                                <span class="text-[9px] text-zinc-500 block text-center mt-1.5 font-mono">REPS</span>
                            </div>
                            <div>
                                <input type="number" name="gym_exercises[${i}][weight]" required step="any" min="0" placeholder="0.0" class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-lg px-3 py-2.5 text-xs text-center focus:border-rose-500 outline-none">
                                <span class="text-[9px] text-zinc-500 block text-center mt-1.5 font-mono">BEBAN (KG)</span>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        window.onload = toggleFormFields;
    </script>
</body>
</html>