<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Aktivitas — ApexMetric V5</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'], } } } }</script>
</head>
<body class="bg-[#0a0a0a] text-zinc-100 antialiased min-h-screen flex flex-col font-sans">

    <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between border-b border-zinc-900 z-50">
        <div class="flex items-center space-x-2">
            <a href="{{ url('/') }}" class="text-xs font-black tracking-[0.4em] uppercase text-white">Apex<span class="text-rose-600">Metric</span></a>
        </div>
        <div class="flex items-center space-x-6">
            <a href="{{ route('dashboard') }}" class="text-xs uppercase tracking-widest font-semibold text-zinc-500 hover:text-white transition-all">&larr; Back to Dashboard</a>
        </div>
    </header>

    <div class="py-12 flex-grow flex items-center justify-center">
        <div class="w-full max-w-3xl mx-auto px-6">
            
            <div class="bg-zinc-950 border border-zinc-900 rounded-xl p-8 shadow-2xl">
                <div class="mb-8 border-b border-zinc-900 pb-4 flex justify-between items-end">
                    <div>
                        <span class="text-[10px] uppercase tracking-[0.4em] text-blue-500 font-semibold block mb-1">Data Modification</span>
                        <h3 class="text-xl font-medium text-white">Edit Log Aktivitas</h3>
                    </div>
                </div>

                @if($errors->any())
                    <div class="mb-6 p-4 bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm rounded-lg">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                @php
                    $totalSeconds = round((float) $activity->duration_minutes * 60.0);
                    $h = floor($totalSeconds / 3600);
                    $m = floor(($totalSeconds % 3600) / 60);
                    $s = $totalSeconds % 60;
                    $gymData = old('gym_exercises', $activity->gym_data ?? []);
                    $gymCount = count($gymData) > 0 ? count($gymData) : 1;
                @endphp

                <form action="{{ route('activities.update', $activity) }}" method="POST" id="activityForm" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="type" class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Jenis Aktivitas</label>
                        <select id="type" name="type" required onchange="toggleFormFields()" class="w-full bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg px-4 py-3 text-sm focus:border-blue-500 outline-none transition-all cursor-pointer">
                            <option value="lari" {{ old('type', $activity->type) == 'lari' ? 'selected' : '' }}>Lari (Speed & Stamina)</option>
                            <option value="sepeda" {{ old('type', $activity->type) == 'sepeda' ? 'selected' : '' }}>Sepeda (Stamina)</option>
                            <option value="gym" {{ old('type', $activity->type) == 'gym' ? 'selected' : '' }}>Gym / Beban (Power)</option>
                            <option value="rest" {{ old('type', $activity->type) == 'rest' ? 'selected' : '' }}>Rest / Recovery (Intelligence)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                        <div id="duration_input_wrapper">
                            <label id="duration-label" class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Durasi Waktu</label>
                            <div class="grid grid-cols-3 gap-2">
                                <div><input type="number" name="duration_hours" min="0" max="23" value="{{ old('duration_hours', $h) }}" class="w-full text-center bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg py-2.5 text-sm outline-none focus:border-blue-500"><span class="text-[10px] text-zinc-500 text-center block mt-1 font-mono">JAM</span></div>
                                <div><input type="number" name="duration_minutes" min="0" max="59" value="{{ old('duration_minutes', $m) }}" class="w-full text-center bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg py-2.5 text-sm outline-none focus:border-blue-500"><span class="text-[10px] text-zinc-500 text-center block mt-1 font-mono">MENIT</span></div>
                                <div><input type="number" name="duration_seconds" min="0" max="59" value="{{ old('duration_seconds', $s) }}" class="w-full text-center bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg py-2.5 text-sm outline-none focus:border-blue-500"><span class="text-[10px] text-zinc-500 text-center block mt-1 font-mono">DETIK</span></div>
                            </div>
                        </div>

                        <div id="right_dynamic_wrapper">
                            <div id="cardio_wrapper">
                                <label class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Jarak Tempuh (KM)</label>
                                <input type="number" id="distance_input" name="distance_km" step="any" min="0.01" value="{{ old('distance_km', $activity->distance_km) }}" placeholder="Contoh: 5.42" class="w-full bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg px-4 py-3 text-sm focus:border-blue-500 outline-none transition-all">
                            </div>

                            <div id="gym_count_wrapper" class="hidden">
                                <label class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Jumlah Macam Gerakan</label>
                                <input type="number" id="workout_count" min="1" max="15" value="{{ $gymCount }}" oninput="generateGymFields()" class="w-full bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg px-4 py-3 text-sm outline-none focus:border-blue-500">
                            </div>
                        </div>
                    </div>

                    <div id="gym_dynamic_fields" class="hidden space-y-4 border-t border-zinc-900 pt-4 mt-2"></div>

                    <div>
                        <label for="notes" class="block text-xs uppercase tracking-wider text-zinc-400 font-medium mb-2">Catatan Latihan (Opsional)</label>
                        <input type="text" id="notes" name="notes" value="{{ old('notes', $activity->notes) }}" placeholder="Misal: Tidur nyenyak / Rute kampus / Chest Press" maxlength="255" class="w-full bg-[#121212] border border-zinc-800 text-zinc-100 rounded-lg px-4 py-3 text-sm focus:border-blue-500 outline-none transition-all">
                    </div>

                    <div class="flex justify-end pt-4 border-t border-zinc-900 gap-4">
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto bg-transparent border border-zinc-700 text-zinc-300 hover:text-white hover:bg-zinc-800 font-semibold text-xs uppercase tracking-widest px-8 py-3.5 rounded-lg transition-all text-center">Batal</a>
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-500 text-white font-semibold text-xs uppercase tracking-widest px-8 py-3.5 rounded-lg transition-all shadow-md">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const existingGymData = JSON.parse('{!! json_encode($gymData, JSON_HEX_APOS) !!}');

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
                    
                    generateGymFields();
                }
            }
        }

        function generateGymFields() {
            const count = parseInt(document.getElementById('workout_count').value) || 0;
            const container = document.getElementById('gym_dynamic_fields');
            container.innerHTML = ''; 

            for(let i = 0; i < count; i++) {
                const data = existingGymData[i] || { name: 'bench_press', sets: '', reps: '', weight: '' };
                const isSelected = (val) => data.name === val ? 'selected' : '';

                container.innerHTML += `
                    <div class="bg-[#121212] p-5 rounded-xl border border-zinc-800 space-y-4 relative">
                        <div class="text-[10px] text-zinc-600 font-mono absolute top-3 right-4 font-bold">GERAKAN #${i+1}</div>
                        
                        <div>
                            <select name="gym_exercises[${i}][name]" required class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-lg px-4 py-2.5 text-xs outline-none focus:border-blue-500 cursor-pointer">
                                <optgroup label="Dada (Chest)">
                                    <option value="bench_press" ${isSelected('bench_press')}>Bench Press</option>
                                    <option value="db_bench_press" ${isSelected('db_bench_press')}>Dumbbell Bench Press</option>
                                    <option value="incline_db_bench" ${isSelected('incline_db_bench')}>Incline Dumbbell Bench Press</option>
                                    <option value="chest_press" ${isSelected('chest_press')}>Chest Press (Machine)</option>
                                    <option value="db_fly" ${isSelected('db_fly')}>Dumbbell Fly</option>
                                    <option value="machine_chest_fly" ${isSelected('machine_chest_fly')}>Machine Chest Fly</option>
                                    <option value="cable_fly" ${isSelected('cable_fly')}>Cable Fly</option>
                                    <option value="push_ups" ${isSelected('push_ups')}>Push Ups</option>
                                </optgroup>
                                <optgroup label="Punggung (Back)">
                                    <option value="deadlift" ${isSelected('deadlift')}>Deadlift</option>
                                    <option value="pull_ups" ${isSelected('pull_ups')}>Pull Ups</option>
                                    <option value="lat_pulldown" ${isSelected('lat_pulldown')}>Lat Pulldown</option>
                                    <option value="close_grip_lat_pulldown" ${isSelected('close_grip_lat_pulldown')}>Close Grip Lat Pulldown</option>
                                    <option value="seated_cable_row" ${isSelected('seated_cable_row')}>Seated Cable Row</option>
                                    <option value="machine_row" ${isSelected('machine_row')}>Machine Row</option>
                                    <option value="db_row" ${isSelected('db_row')}>Dumbbell Row</option>
                                    <option value="chest_supported_db_row" ${isSelected('chest_supported_db_row')}>Chest Supported Dumbbell Row</option>
                                    <option value="db_shrug" ${isSelected('db_shrug')}>Dumbbell Shrug</option>
                                </optgroup>
                                <optgroup label="Kaki (Legs)">
                                    <option value="squat" ${isSelected('squat')}>Squat (Barbell)</option>
                                    <option value="sled_leg_press" ${isSelected('sled_leg_press')}>Sled Leg Press</option>
                                    <option value="horizontal_leg_press" ${isSelected('horizontal_leg_press')}>Horizontal Leg Press</option>
                                    <option value="hack_squat" ${isSelected('hack_squat')}>Hack Squat</option>
                                    <option value="db_lunge" ${isSelected('db_lunge')}>Dumbbell Lunge</option>
                                    <option value="db_bulgarian_split_squat" ${isSelected('db_bulgarian_split_squat')}>Dumbbell Bulgarian Split Squat</option>
                                    <option value="db_romanian_deadlift" ${isSelected('db_romanian_deadlift')}>Dumbbell Romanian Deadlift</option>
                                    <option value="goblet_squat" ${isSelected('goblet_squat')}>Goblet Squat</option>
                                    <option value="leg_extension" ${isSelected('leg_extension')}>Leg Extension</option>
                                    <option value="seated_leg_curl" ${isSelected('seated_leg_curl')}>Seated Leg Curl</option>
                                    <option value="lying_leg_curl" ${isSelected('lying_leg_curl')}>Lying Leg Curl</option>
                                    <option value="machine_calf_raise" ${isSelected('machine_calf_raise')}>Machine Calf Raise</option>
                                    <option value="hip_adduction" ${isSelected('hip_adduction')}>Hip Adduction</option>
                                </optgroup>
                                <optgroup label="Bahu (Shoulders)">
                                    <option value="shoulder_press" ${isSelected('shoulder_press')}>Shoulder Press (Barbell)</option>
                                    <option value="db_shoulder_press" ${isSelected('db_shoulder_press')}>Dumbbell Shoulder Press</option>
                                    <option value="seated_db_shoulder_press" ${isSelected('seated_db_shoulder_press')}>Seated DB Shoulder Press</option>
                                    <option value="machine_shoulder_press" ${isSelected('machine_shoulder_press')}>Machine Shoulder Press</option>
                                    <option value="db_lateral_raise" ${isSelected('db_lateral_raise')}>Dumbbell Lateral Raise</option>
                                    <option value="cable_lateral_raise" ${isSelected('cable_lateral_raise')}>Cable Lateral Raise</option>
                                    <option value="face_pull" ${isSelected('face_pull')}>Face Pull</option>
                                </optgroup>
                                <optgroup label="Lengan & Core (Arms/Abs)">
                                    <option value="db_curl" ${isSelected('db_curl')}>Dumbbell Curl</option>
                                    <option value="hammer_curl" ${isSelected('hammer_curl')}>Hammer Curl</option>
                                    <option value="cable_bicep_curl" ${isSelected('cable_bicep_curl')}>Cable Bicep Curl</option>
                                    <option value="db_tricep_extension" ${isSelected('db_tricep_extension')}>Dumbbell Tricep Extension</option>
                                    <option value="tricep_pushdown" ${isSelected('tricep_pushdown')}>Tricep Pushdown</option>
                                    <option value="tricep_rope_pushdown" ${isSelected('tricep_rope_pushdown')}>Tricep Rope Pushdown</option>
                                    <option value="cable_crunch" ${isSelected('cable_crunch')}>Cable Crunch</option>
                                </optgroup>
                                <optgroup label="Lainnya">
                                    <option value="generic" ${isSelected('generic')}>Latihan Lainnya (Isolasi / Mesin)</option>
                                </optgroup>
                            </select>
                        </div>
                        
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <input type="number" name="gym_exercises[${i}][sets]" value="${data.sets}" required min="1" placeholder="0" class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-lg px-3 py-2.5 text-xs text-center focus:border-blue-500 outline-none">
                                <span class="text-[9px] text-zinc-500 block text-center mt-1.5 font-mono">SETS</span>
                            </div>
                            <div>
                                <input type="number" name="gym_exercises[${i}][reps]" value="${data.reps}" required min="1" placeholder="0" class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-lg px-3 py-2.5 text-xs text-center focus:border-blue-500 outline-none">
                                <span class="text-[9px] text-zinc-500 block text-center mt-1.5 font-mono">REPS</span>
                            </div>
                            <div>
                                <input type="number" name="gym_exercises[${i}][weight]" value="${data.weight}" required step="any" min="0" placeholder="0.0" class="w-full bg-zinc-900 border border-zinc-700 text-zinc-100 rounded-lg px-3 py-2.5 text-xs text-center focus:border-blue-500 outline-none">
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