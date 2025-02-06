<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteMachine extends Model
{
    use HasFactory;

    protected $table = 'quote_machines';

    protected $fillable = [
        'quote_id',
        'machine_id',
        'quantity',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}
