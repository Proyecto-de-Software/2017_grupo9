<?php

use Illuminate\Database\Seeder;

class PermitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$resources = ['patient', 'user', 'demographicData', 'configuration','medicalCheckup' ];
    	$permits = ['show','index','update','destroy', 'new'];
    	foreach ($resources as $resource) {
    		foreach ($permits as $permit) {
    			$name = $resource.'_'.$permit;
    			DB::table('permits')->insert(array('name' =>$name));
    		}
    	}
    }
}
