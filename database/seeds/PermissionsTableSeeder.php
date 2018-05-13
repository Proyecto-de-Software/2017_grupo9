<?php

use Illuminate\Database\Seeder;
use App\Permission;
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
    	$permissions = ['show','index','update','destroy', 'new'];
    	foreach ($resources as $resource) {
    		foreach ($permissions as $permission) {
    			$name = $resource.'_'.$permission;
    			DB::table('permissions')->insert(array('name' =>$name));
    		}
    	}
    }
}
