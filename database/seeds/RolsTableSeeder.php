<?php

use Illuminate\Database\Seeder;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert(array(
           'name' =>'administrador',          
    	));
    	DB::table('rols')->insert(array(
           'name' =>'recepcionista',          
    	));
    	DB::table('rols')->insert(array(
           'name' =>'pediatra',          
    	));
    }
}
