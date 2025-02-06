<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $table = 'parts';

    protected $fillable = [
        'name',
        'stock',
        'price',
    ];

    public function maintenanceReports()
    {
        return $this->hasMany(MaintenanceReport::class, 'used_parts');
    }

    public function isLowStock()
    {
        return $this->stock < 10;
    }
}
