<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(array(
           'name' =>'administrador',          
    	));
    	DB::table('roles')->insert(array(
           'name' =>'recepcionista',          
    	));
    	DB::table('roles')->insert(array(
           'name' =>'pediatra',          
    	));
    }
}
