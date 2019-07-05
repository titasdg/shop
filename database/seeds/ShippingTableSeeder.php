<?php

use Illuminate\Database\Seeder;

class ShippingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shippings')->insert([[
            'title' => 'Atsiimti bityne',
            'price' => 0,
            'days' =>'',
            'created_at' => now(),
            'updated_at' => now(),
        ],
            [
                'title' => 'Omniva pastomatas',
                'price' => 3,
                'days' =>'1-2 darbo dienos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Omniva Kurjeris',
                'price' => 6,
                'days' =>'1-2 darbo dienos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
