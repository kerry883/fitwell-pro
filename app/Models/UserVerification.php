<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UserVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp_code',
        'expires_at',
        'verified_at',
        'attempts',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return $this->expires_at < now();
    }

    public function isVerified()
    {
        return !is_null($this->verified_at);
    }

    public function incrementAttempts()
    {
        $this->increment('attempts');
    }

    public function markAsVerified()
    {
        $this->update(['verified_at' => now()]);
    }

    public static function generateOtp($length = 6)
    {
        $digits = '';
        for ($i = 0; $i < $length; $i++) {
            $digits .= mt_rand(0, 9);
        }
        return $digits;
    }

    public static function canResend($userId)
    {
        $key = "otp_resend_{$userId}";
        return !Cache::has($key);
    }

    public static function setResendThrottle($userId, $seconds = 30)
    {
        $key = "otp_resend_{$userId}";
        Cache::put($key, true, $seconds);
    }

    public static function getResendCooldown($userId)
    {
        $key = "otp_resend_{$userId}";
        return Cache::store('file')->get($key) ? 30 : 0; // Simplified cooldown check
    }
}
