<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'user_type',
        'status',
        'last_login',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login' => 'datetime',
        ];
    }

    /**
     * Determine if the user can access the Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Allow access based on panel ID
        if ($panel->getId() === 'admin') {
            return $this->user_type === 'ADMIN';
        }

        if ($panel->getId() === 'trainer') {
            return in_array($this->user_type, ['ADMIN', 'TRAINER']);
        }

        return true;
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's name for Filament.
     * This is required by Filament's FilamentUser interface.
     */
  public function getFilamentName(): string
{
    // Always return a string — never null
    $fullName = trim("{$this->first_name} {$this->last_name}");
    return $fullName !== '' ? $fullName : ($this->email ?? 'Unknown User');
}

public function getFilamentAvatarUrl(): ?string
{
    // Optional: generate a default avatar if none uploaded
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->getFilamentName());
}

// Optional: covers other packages expecting $user->name
public function getNameAttribute(): string
{
    return $this->getFilamentName();
}
}   
