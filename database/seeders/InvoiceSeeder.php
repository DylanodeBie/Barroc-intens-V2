<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Step 1: Fetch customers, users (finance), and products
        $customers = Customer::all();
        $financeUsers = User::where('role_id', 2)->get(); // Finance role
        $products = Product::all();

        // Step 2: Generate invoices
        foreach ($customers as $customer) {
            // Randomly pick a finance user for the invoice
            $user = $financeUsers->random();

            // Create the invoice
            $invoice = Invoice::create([
                'customer_id' => $customer->id,
                'user_id' => $user->id,
                'invoice_number' => 'INV-' . now()->timestamp . '-' . $customer->id,
                'invoice_date' => now()->subDays(rand(1, 60)), // Random date within the last 2 months
                'notes' => 'Dit is een gegenereerde factuur voor testdoeleinden.',
                'total_amount' => 0,
            ]);

            $totalAmount = 0;

            // Step 3: Add 2-4 random products (machines and beans) as invoice items
            $selectedProducts = $products->random(rand(2, 4));

            foreach ($selectedProducts as $product) {
                $quantity = rand(1, 5);
                $subtotal = $product->price * $quantity;

                // Create invoice items
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $product->name,
                    'quantity' => $quantity,
                    'unit_price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            // Update total amount
            $invoice->update(['total_amount' => $totalAmount]);
        }
    }
}
