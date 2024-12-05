<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'issue_description',
        'used_parts',
        'follow_up_notes',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}

