<?php

use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        \DB::table('cities')->delete();
        \DB::table('cities')->insert(array (
            84 => 
            array (
                'id' => 15508,
                'text' => 'Bani'
            ),
            103 => 
            array (
                'id' => 15527,
                'text' => 'Mangatarem'
            )
        ));
    }
}