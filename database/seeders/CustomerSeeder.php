<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'company_name' => 'Brew Haven Cafe',
                'contact_person' => 'Alice Johnson',
                'phonenumber' => '123-456-7890',
                'email' => 'alice@brewhaven.com',
                'address' => '123 Main St, Coffeeville',
                'bkr_check' => false,
            ],
            [
                'company_name' => 'The Morning Roast',
                'contact_person' => 'Bob Smith',
                'phonenumber' => '234-567-8901',
                'email' => 'bob@morningroast.com',
                'address' => '456 Elm St, Coffeeville',
                'bkr_check' => true,
            ],
            [
                'company_name' => 'Cafe Delight',
                'contact_person' => 'Charlie Brown',
                'phonenumber' => '345-678-9012',
                'email' => 'charlie@cafedelight.com',
                'address' => '789 Oak St, Coffeeville',
                'bkr_check' => false,
            ],
            [
                'company_name' => 'Espresso Express',
                'contact_person' => 'Diana Prince',
                'phonenumber' => '456-789-0123',
                'email' => 'diana@espressoexpress.com',
                'address' => '101 Maple St, Coffeeville',
                'bkr_check' => true,
            ],
            [
                'company_name' => 'Latte Lounge',
                'contact_person' => 'Eve Adams',
                'phonenumber' => '567-890-1234',
                'email' => 'eve@lattelounge.com',
                'address' => '202 Birch St, Coffeeville',
                'bkr_check' => false,
            ],
            [
                'company_name' => 'The Bean Scene',
                'contact_person' => 'Frank Green',
                'phonenumber' => '678-901-2345',
                'email' => 'frank@beanscene.com',
                'address' => '303 Pine St, Coffeeville',
                'bkr_check' => true,
            ],
            [
                'company_name' => 'Mocha Magic',
                'contact_person' => 'Grace Hall',
                'phonenumber' => '789-012-3456',
                'email' => 'grace@mochamagic.com',
                'address' => '404 Cedar St, Coffeeville',
                'bkr_check' => false,
            ],
            [
                'company_name' => 'Perk Up Cafe',
                'contact_person' => 'Hank Miller',
                'phonenumber' => '890-123-4567',
                'email' => 'hank@perkup.com',
                'address' => '505 Spruce St, Coffeeville',
                'bkr_check' => true,
            ],
            [
                'company_name' => 'The Daily Grind',
                'contact_person' => 'Ivy Clark',
                'phonenumber' => '901-234-5678',
                'email' => 'ivy@dailygrind.com',
                'address' => '606 Willow St, Coffeeville',
                'bkr_check' => false,
            ],
            [
                'company_name' => 'Java Junction',
                'contact_person' => 'Jack White',
                'phonenumber' => '012-345-6789',
                'email' => 'jack@javajunction.com',
                'address' => '707 Poplar St, Coffeeville',
                'bkr_check' => true,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
