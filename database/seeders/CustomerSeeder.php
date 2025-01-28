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
            ['company_name' => 'Brew Haven Cafe', 'contact_person' => 'Alice Johnson', 'phonenumber' => '123-456-7890', 'email' => 'alice@brewhaven.com', 'address' => '123 Main St, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'The Morning Roast', 'contact_person' => 'Bob Smith', 'phonenumber' => '234-567-8901', 'email' => 'bob@morningroast.com', 'address' => '456 Elm St, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Cafe Delight', 'contact_person' => 'Charlie Brown', 'phonenumber' => '345-678-9012', 'email' => 'charlie@cafedelight.com', 'address' => '789 Oak St, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Espresso Express', 'contact_person' => 'Diana Prince', 'phonenumber' => '456-789-0123', 'email' => 'diana@espressoexpress.com', 'address' => '101 Maple St, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Latte Lounge', 'contact_person' => 'Eve Adams', 'phonenumber' => '567-890-1234', 'email' => 'eve@lattelounge.com', 'address' => '202 Birch St, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'The Bean Scene', 'contact_person' => 'Frank Green', 'phonenumber' => '678-901-2345', 'email' => 'frank@beanscene.com', 'address' => '303 Pine St, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Mocha Magic', 'contact_person' => 'Grace Hall', 'phonenumber' => '789-012-3456', 'email' => 'grace@mochamagic.com', 'address' => '404 Cedar St, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Perk Up Cafe', 'contact_person' => 'Hank Miller', 'phonenumber' => '890-123-4567', 'email' => 'hank@perkup.com', 'address' => '505 Spruce St, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'The Daily Grind', 'contact_person' => 'Ivy Clark', 'phonenumber' => '901-234-5678', 'email' => 'ivy@dailygrind.com', 'address' => '606 Willow St, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Java Junction', 'contact_person' => 'Jack White', 'phonenumber' => '012-345-6789', 'email' => 'jack@javajunction.com', 'address' => '707 Poplar St, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Cafe Paradise', 'contact_person' => 'Anna Blue', 'phonenumber' => '321-654-9870', 'email' => 'anna@cafeparadise.com', 'address' => '808 Aspen St, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Office Brew', 'contact_person' => 'Chris Redfield', 'phonenumber' => '456-654-3210', 'email' => 'chris@officebrew.com', 'address' => '909 Maple Ln, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Cafe Cravings', 'contact_person' => 'Sophia Brown', 'phonenumber' => '789-456-1230', 'email' => 'sophia@cafecravings.com', 'address' => '112 Fir Ave, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Steamy Perks', 'contact_person' => 'Liam Grey', 'phonenumber' => '234-890-5671', 'email' => 'liam@steamyperks.com', 'address' => '223 Cherry Blvd, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Corporate Coffee', 'contact_person' => 'Emma Green', 'phonenumber' => '345-567-8902', 'email' => 'emma@corporatecoffee.com', 'address' => '334 Holly Dr, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Bistro Brews', 'contact_person' => 'James Brown', 'phonenumber' => '456-678-9013', 'email' => 'james@bistrobrews.com', 'address' => '445 Spruce Ave, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Cafe Harmony', 'contact_person' => 'Mia Stone', 'phonenumber' => '567-789-0124', 'email' => 'mia@cafeharmony.com', 'address' => '556 Oak Rd, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Coffee Collective', 'contact_person' => 'Oliver White', 'phonenumber' => '678-890-1235', 'email' => 'oliver@coffeecollective.com', 'address' => '667 Elm Ln, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Caffeine Fix', 'contact_person' => 'Ella Black', 'phonenumber' => '789-901-2346', 'email' => 'ella@caffeinefix.com', 'address' => '778 Pine St, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Brewing Brilliance', 'contact_person' => 'Jacob Miller', 'phonenumber' => '890-123-3457', 'email' => 'jacob@brewingbrilliance.com', 'address' => '889 Cedar Rd, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Urban Brews', 'contact_person' => 'Ava Taylor', 'phonenumber' => '111-222-3333', 'email' => 'ava@urbanbrews.com', 'address' => '1010 Hill St, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Espresso Infinity', 'contact_person' => 'Luna Walker', 'phonenumber' => '222-333-4444', 'email' => 'luna@espressinfinity.com', 'address' => '1212 Moon Rd, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Java Vibes', 'contact_person' => 'Noah Robinson', 'phonenumber' => '333-444-5555', 'email' => 'noah@javavibes.com', 'address' => '1313 Star Blvd, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Perk Central', 'contact_person' => 'Isabella King', 'phonenumber' => '444-555-6666', 'email' => 'isabella@perkcentral.com', 'address' => '1414 Sky Ln, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Bean Dynasty', 'contact_person' => 'Lucas Perez', 'phonenumber' => '555-666-7777', 'email' => 'lucas@beandynasty.com', 'address' => '1515 Lake Ave, Coffeeville', 'bkr_check' => true],
            ['company_name' => 'Morning Bliss', 'contact_person' => 'Charlotte Brown', 'phonenumber' => '666-777-8888', 'email' => 'charlotte@morningbliss.com', 'address' => '1616 River Rd, Coffeeville', 'bkr_check' => false],
            ['company_name' => 'Cafe Brilliance', 'contact_person' => 'Grace Hall', 'phonenumber' => '555-123-1234', 'email' => 'grace@cafebrilliance.com', 'address' => '1737 Elm St, Coffeeville', 'bkr_check' => true],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
