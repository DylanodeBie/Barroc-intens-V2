<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
        'subtotal',
    ];


    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function calculateSubtotal()
    {
        return $this->quantity * $this->unit_price;
    }
}
