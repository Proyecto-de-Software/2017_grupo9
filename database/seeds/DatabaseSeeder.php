<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PatientsTableSeeder::class);
        $this->call(RolsTableSeeder::class);
        $this->call(PermitsTableSeeder::class);
       // $this->call(DemographicDatasTableSeeder::class);
    }
}

?>