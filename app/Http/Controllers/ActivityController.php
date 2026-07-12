<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'type' => 'required|in:lari,sepeda,gym,rest',
            'duration_hours' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|numeric|min:0|max:59',
            'duration_seconds' => 'nullable|numeric|min:0|max:59',
            'distance_km' => 'nullable|numeric|min:0',
            'gym_exercises' => 'nullable|array',
            'gym_exercises.*.name' => 'nullable|string',
            'gym_exercises.*.sets' => 'nullable|integer|min:1',
            'gym_exercises.*.reps' => 'nullable|integer|min:1',
            'gym_exercises.*.weight' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        $hours = (int) $request->input('duration_hours', 0);
        $minutes = (int) $request->input('duration_minutes', 0);
        $seconds = (int) $request->input('duration_seconds', 0);
        $totalMinutes = (float) ($hours * 60) + $minutes + ($seconds / 60);

        if ($totalMinutes <= 0) return redirect()->back()->withErrors(['duration_minutes' => 'Durasi tidak boleh kosong.']);

        $type = $request->type;
        $distance = $type === 'lari' || $type === 'sepeda' ? (float) $request->input('distance_km') : null;
        $gymData = $type === 'gym' ? $request->input('gym_exercises') : null;

        $request->user()->activities()->create([
            'type' => $type,
            'duration_minutes' => $totalMinutes,
            'distance_km' => $distance,
            'gym_data' => $gymData,
            'intensity_score' => 0,
            'notes' => $request->notes,
        ]);

        // TRIGGER RE-CALCULATE DATA CACHE UNTUK SAAS
        $request->user()->syncFitnessPoints();

        return redirect()->route('dashboard')->with('success', 'Aktivitas berhasil dicatat.');
    }

    public function edit(Activity $activity): View
    {
        if (Auth::id() !== $activity->user_id) abort(403, 'Akses ditolak.');
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity): RedirectResponse
    {
        if (Auth::id() !== $activity->user_id) abort(403, 'Akses ditolak.');

        $request->validate([
            'type' => 'required|in:lari,sepeda,gym,rest',
            'duration_hours' => 'nullable|numeric|min:0',
            'duration_minutes' => 'nullable|numeric|min:0|max:59',
            'duration_seconds' => 'nullable|numeric|min:0|max:59',
            'distance_km' => 'nullable|numeric|min:0',
            'gym_exercises' => 'nullable|array',
            'gym_exercises.*.name' => 'nullable|string',
            'gym_exercises.*.sets' => 'nullable|integer|min:1',
            'gym_exercises.*.reps' => 'nullable|integer|min:1',
            'gym_exercises.*.weight' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        $hours = (int) $request->input('duration_hours', 0);
        $minutes = (int) $request->input('duration_minutes', 0);
        $seconds = (int) $request->input('duration_seconds', 0);
        $totalMinutes = (float) ($hours * 60) + $minutes + ($seconds / 60);

        if ($totalMinutes <= 0) return redirect()->back()->withErrors(['duration_minutes' => 'Durasi tidak boleh kosong.']);

        $type = $request->type;
        $distance = $type === 'lari' || $type === 'sepeda' ? (float) $request->input('distance_km') : null;
        $gymData = $type === 'gym' ? $request->input('gym_exercises') : null;

        $activity->update([
            'type' => $type,
            'duration_minutes' => $totalMinutes,
            'distance_km' => $distance,
            'gym_data' => $gymData,
            'intensity_score' => 0,
            'notes' => $request->notes,
        ]);

        // TRIGGER RE-CALCULATE DATA CACHE UNTUK SAAS
        $request->user()->syncFitnessPoints();

        return redirect()->route('dashboard')->with('success', 'Aktivitas berhasil diperbarui.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        if (Auth::id() !== $activity->user_id) abort(403);
        
        $user = $activity->user;
        $activity->delete();

        // TRIGGER RE-CALCULATE DATA CACHE UNTUK SAAS
        $user->syncFitnessPoints();

        return redirect()->route('dashboard')->with('success', 'Aktivitas berhasil dihapus.');
    }
}