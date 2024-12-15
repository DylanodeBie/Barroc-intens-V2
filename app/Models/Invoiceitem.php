<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'invoice_items';

    // Mass assignable fields
    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    /**
     * Relationship: InvoiceItem belongs to an Invoice.
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Helper Method: Calculate subtotal dynamically.
     */
    public function calculateSubtotal()
    {
        return $this->quantity * $this->unit_price;
    }
}
