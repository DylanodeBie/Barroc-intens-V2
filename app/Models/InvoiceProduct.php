<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $table = 'invoice_product'; // Pivot-tabel naam
    protected $fillable = ['invoice_id', 'product_id', 'amount', 'price'];
}
