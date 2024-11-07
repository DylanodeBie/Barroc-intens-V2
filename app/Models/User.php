<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'quote_id');
    }

    public function error_notifications()
    {
        return $this->hasMany(ErrorNotification::class, 'error_notification_id');
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'visit_id');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'invoice_id');
    }

    public function leasecontracts()
    {
        return $this->hasMany(LeaseContract::class, 'leasecontract_id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }
}
