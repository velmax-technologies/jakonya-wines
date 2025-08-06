<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeter extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'Site_Name',
            'group' => 'general',
            'value' => 'Jakonya Wines & Spirits',
        ]);

        Setting::create([
            'key' => 'site_phone',
            'group' => 'general',
            'value' => '+1234567890',
        ]);

        Setting::create([
            'key' => 'site_developer',
            'group' => 'general',
            'value' => 'Veltech +254708222536',
        ]);

        // receipt settings
        Setting::create([
            'key' => 'receipt_header',
            'group' => 'receipt',
            'value' => 'Jakonya Wines & Spirits\nThank you for your purchase!',
        ]);

        Setting::create([
            'key' => 'receipt_footer',
            'group' => 'receipt',
            'value' => 'Visit us again!',
        ]);

        Setting::create([
            'key' => 'receipt_logo',
            'group' => 'receipt',
            'value' => '/images/logo.png', // Assuming the logo is stored in the public/images directory
        ]);

        Setting::create([
            'key' => 'receipt_show_tax',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_show_total',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_show_date',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_show_time',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_show_cashier',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_show_payment_method',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_show_change',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_show_customer_name',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);


        Setting::create([
            'key' => 'receipt_show_order_number',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_show_order_date',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'receipt_auto_print',
            'group' => 'receipt',
            'value' => '1', // 1 for true, 0 for false
        ]);

        // payment methods
        Setting::create([
            'key' => 'payment_methods',
            'group' => 'payment',
            'value' => json_encode([
                'cash' => [
                    'name' => 'Cash',
                    'enabled' => true,
                ],
                'mpesa' => [
                    'name' => 'M-Pesa',
                    'enabled' => true,
                ],
                'equity' => [
                    'name' => 'Equity Paybill',
                    'enabled' => false,
                ],
            ]),
        ]);

        // order settings
        Setting::create([
            'key' => 'allow_online_orders',
            'group' => 'order',
            'value' => '1', // 1 for true, 0 for false
        ]);
        
        Setting::create([
            'key' => 'auto_confirm_orders',
            'group' => 'order',
            'value' => '0', // 1 for true, 0 for false
        ]);

        Setting::create([
            'key' => 'auto_print_order_receipt',
            'group' => 'order',
            'value' => '0', // 1 for true, 0 for false
        ]);
        
       

         
    }
}
