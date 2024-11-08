<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',  // zorg ervoor dat deze kolom juist heet in je database
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'user_id'); // Foreign key in quotes-table zou 'user_id' moeten zijn
    }

    public function error_notifications()
    {
        return $this->hasMany(ErrorNotification::class, 'user_id'); // Foreign key in error_notifications-table zou 'user_id' moeten zijn
    }

    public function visits()
    {
        return $this->hasMany(Visit::class, 'user_id'); // Foreign key in visits-table zou 'user_id' moeten zijn
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'user_id'); // Foreign key in invoices-table zou 'user_id' moeten zijn
    }

    public function leasecontracts()
    {
        return $this->hasMany(LeaseContract::class, 'user_id'); // Foreign key in leasecontracts-table zou 'user_id' moeten zijn
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}