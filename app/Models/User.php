<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'is_premium',
        'stamina_pts',
        'power_pts',
        'intelligence_pts',
        'total_pts'
    ];

    protected $hidden = [
        'password', 
        'remember_token'
    ];

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    // UTILITY: GET DATA TIER DAN BADGE GEOMETRI KUSTOM
    public function getTierDetails(int $points): array
    {
        if ($points >= 50000) {
            return ['code' => 'SS', 'title' => 'Greek God', 'color' => 'from-amber-300 to-yellow-500', 'bg_badge' => 'bg-amber-500/10 text-amber-400 border-amber-500/30', 'shape' => 'hexagon'];
        }
        if ($points >= 40000) {
            return ['code' => 'S', 'title' => 'Olympia', 'color' => 'from-purple-400 to-indigo-600', 'bg_badge' => 'bg-purple-500/10 text-purple-400 border-purple-500/30', 'shape' => 'pentagon'];
        }
        if ($points >= 30000) {
            return ['code' => 'A+', 'title' => 'Titan', 'color' => 'from-emerald-400 to-teal-600', 'bg_badge' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30', 'shape' => 'diamond'];
        }
        if ($points >= 20000) {
            return ['code' => 'A', 'title' => 'Elite', 'color' => 'from-cyan-400 to-blue-600', 'bg_badge' => 'bg-cyan-500/10 text-cyan-400 border-cyan-500/30', 'shape' => 'diamond'];
        }
        if ($points >= 12000) {
            return ['code' => 'B+', 'title' => 'Athlete', 'color' => 'from-rose-400 to-red-600', 'bg_badge' => 'bg-rose-500/10 text-rose-400 border-rose-500/30', 'shape' => 'square'];
        }
        if ($points >= 6000) {
            return ['code' => 'B', 'title' => 'Hybrid', 'color' => 'from-zinc-300 via-zinc-400 to-zinc-600', 'bg_badge' => 'bg-zinc-400/10 text-zinc-300 border-zinc-500/20', 'shape' => 'square'];
        }
        if ($points >= 2000) {
            return ['code' => 'C', 'title' => 'Beginner', 'color' => 'from-orange-400 to-amber-700', 'bg_badge' => 'bg-orange-700/10 text-orange-400 border-orange-700/20', 'shape' => 'triangle'];
        }
        return ['code' => 'D', 'title' => 'Rookie', 'color' => 'from-zinc-500 to-zinc-700', 'bg_badge' => 'bg-zinc-800/50 text-zinc-500 border-zinc-800', 'shape' => 'triangle'];
    }

    public function syncFitnessPoints(): void
    {
        $activities = $this->activities;
        $stamina = 0; $power = 0; $intelligence = 0;

        $strengthStandards = [
            'bench_press' => ['elite' => 160, 'advanced' => 125, 'intermediate' => 95, 'beginner' => 45],
            'squat' => ['elite' => 200, 'advanced' => 160, 'intermediate' => 115, 'beginner' => 60],
            'deadlift' => ['elite' => 225, 'advanced' => 180, 'intermediate' => 135, 'beginner' => 80],
            'generic' => ['elite' => 140, 'advanced' => 100, 'intermediate' => 60, 'beginner' => 30]
        ];

        foreach ($activities as $activity) {
            $duration = (float) $activity->duration_minutes;
            $distance = (float) $activity->distance_km;

            if ($activity->type === 'lari' && $distance > 0 && $duration > 0) {
                $pace = $duration / $distance;
                $multiplier = ($pace <= 3.75) ? 200 : (($pace <= 4.25) ? 120 : (($pace <= 5.00) ? 70 : (($pace <= 6.50) ? 40 : 20)));
                $stamina += $distance * $multiplier;
            } 
            elseif ($activity->type === 'sepeda' && $distance > 0 && $duration > 0) {
                $speedKmh = $distance / ($duration / 60);
                $multiplier = ($speedKmh >= 40) ? 100 : (($speedKmh >= 32) ? 60 : (($speedKmh >= 24) ? 30 : (($speedKmh >= 16) ? 15 : 10)));
                $stamina += $distance * $multiplier;
            } 
            elseif ($activity->type === 'gym') {
                foreach ($activity->gym_data ?? [] as $workout) {
                    $sets = (int) ($workout['sets'] ?? 0);
                    $reps = (int) ($workout['reps'] ?? 0);
                    $weight = (float) ($workout['weight'] ?? 0);
                    $exercise = $workout['name'] ?? 'generic';

                    if ($sets > 0 && $reps > 0) {
                        $est1RM = $weight * (1 + ($reps / 30));
                        $threshold = $strengthStandards[$exercise] ?? $strengthStandards['generic'];
                        $multiplier = ($est1RM >= $threshold['elite']) ? 100 : (($est1RM >= $threshold['advanced']) ? 60 : (($est1RM >= $threshold['intermediate']) ? 30 : (($est1RM >= $threshold['beginner']) ? 15 : 10)));
                        $power += ($sets * $reps * $multiplier);
                    }
                }
                $power += ($duration * 2); 
            } 
            elseif ($activity->type === 'rest') {
                $intelligence += ($duration >= 420 && $duration <= 540) ? 150 : (($duration >= 360 && $duration < 420) ? 60 : 10);
            }
        }

        $this->update([
            'stamina_pts' => round($stamina),
            'power_pts' => round($power),
            'intelligence_pts' => round($intelligence),
            'total_pts' => round($stamina + $power + $intelligence),
        ]);
    }

    public function getFitnessStatsAttribute(): array
    {
        $tTotal = $this->getTierDetails($this->total_pts);
        $tStamina = $this->getTierDetails($this->stamina_pts);
        $tPower = $this->getTierDetails($this->power_pts);
        $tIntel = $this->getTierDetails($this->intelligence_pts);

        return [
            'stamina' => $this->stamina_pts, 
            'rank_stamina' => $tStamina['code'],
            'title_stamina' => $tStamina['title'],
            'badge_stamina' => $tStamina['shape'],
            
            'power' => $this->power_pts, 
            'rank_power' => $tPower['code'],
            'title_power' => $tPower['title'],
            'badge_power' => $tPower['shape'],
            
            'intelligence' => $this->intelligence_pts, 
            'rank_intelligence' => $tIntel['code'],
            'title_intelligence' => $tIntel['title'],
            'badge_intelligence' => $tIntel['shape'],
            
            'total' => $this->total_pts, 
            'rank' => $tTotal['code'],
            'rank_title' => $tTotal['title'],
            'rank_color' => $tTotal['color'],
            'rank_shape' => $tTotal['shape']
        ];
    }

    protected function casts(): array { return ['email_verified_at' => 'datetime', 'password' => 'hashed']; }
}