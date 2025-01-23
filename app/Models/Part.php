<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    /**
     * De tabel geassocieerd met het model.
     *
     * @var string
     */
    protected $table = 'parts';

    /**
     * Mass-assignable velden.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'stock',
    ];

    /**
     * Relatie: een onderdeel kan in meerdere onderhoudsrapporten worden gebruikt.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function maintenanceReports()
    {
        return $this->hasMany(MaintenanceReport::class, 'used_parts');
    }

    /**
     * Controleer of de voorraad laag is.
     *
     * @return bool
     */
    public function isLowStock()
    {
        return $this->stock < 10;
    }
}
