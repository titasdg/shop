<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'title' => 'Nemokamas pristatymas',
            'value' => 30,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
