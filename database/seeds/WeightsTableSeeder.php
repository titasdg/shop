<?php

use Illuminate\Database\Seeder;

class WeightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('weights')->insert([[
            'value' => 0.5,
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'value' => 1.0,
            'created_at' => now(),
            'updated_at' => now(),

        ], [
            'value' => 1.5,
            'created_at' => now(),
            'updated_at' => now(),
        ], [
            'value' => 2.0,
            'created_at' => now(),
            'updated_at' => now(),
        ]]);
    }
}
