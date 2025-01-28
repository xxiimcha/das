<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',                   // User role, e.g., 'owner', 'admin', 'tenant'
        'otp',                    // One-time password for verification
        'otp_expires_at',         // Expiry time for OTP
        'forgot_password_token',  // Token for resetting password
        'status',                 // User status, e.g., 'active', 'inactive', 'pending'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
        'forgot_password_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_expires_at' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Relationship: User owns multiple dormitories.
     */
    public function dormitories()
    {
        return $this->hasMany(Dormitory::class);
    }

    /**
     * Check if the user is an owner.
     *
     * @return bool
     */
    public function isOwner()
    {
        return $this->role === 'owner';
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}
