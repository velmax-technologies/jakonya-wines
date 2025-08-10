<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(app()->env == "local"){
            $customer = Customer::create([
                'name' => 'Velmax Technologies',
                'email' => 'vt@veltech.com',
                'phone' => '0708222536',
                'address' => 'Nairobi, Kenya',
                'note' => 'This is a test customer for Velmax Technologies.',
            ]);
        }
    }
}
