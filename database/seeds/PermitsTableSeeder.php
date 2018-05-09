<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$resources = ['patient', 'user', 'demographicData', 'configuration','medicalCheckup' ];
    	$permission = ['show','index','update','destroy', 'new'];
    	foreach ($resources as $resource) {
    		foreach (permissions as permission) {
    			$name = $resource.'_'.permission;
    			DB::table('permission')->insert(array('name' =>$name));
    		}
    	}
    }
}
