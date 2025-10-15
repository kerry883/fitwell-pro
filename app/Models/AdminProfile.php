<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'admin_level',
        'department',
        'admin_notes',
        'created_by',
        'status',
        'last_login_at',
        'permissions',
    ];

    protected function casts(): array
    {
        return [
            'last_login_at' => 'datetime',
            'permissions' => 'array',
        ];
    }

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Helper methods
     */
    public function isSuperAdmin()
    {
        return $this->admin_level === 'super_admin';
    }

    public function isAdmin()
    {
        return in_array($this->admin_level, ['super_admin', 'admin']);
    }

    public function isModerator()
    {
        return $this->admin_level === 'moderator';
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function hasPermission($permission)
    {
        if ($this->isSuperAdmin()) {
            return true; // Super admins have all permissions
        }

        return in_array($permission, $this->permissions ?? []);
    }
}