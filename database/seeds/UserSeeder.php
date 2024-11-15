<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
                'username' => 'DOH123',
                'password' => bcrypt('DOH123'),
                'level' => 'doctor',
                'facility_id' => '1',
                'fname' => 'Jimmy',
                'mname' => 'Baron',
                'lname' => 'Lomocso',
                'title' => '',
                'contact' => '09162072427',
                'email' => 'jimmy.lomocso@gmail.com',
                'muncity' => '63',
                'province' => '2',
                'accreditation_no' => '1234',
                'accreditation_validity' => '2030-12-02',
                'license_no' => '4567',
                'prefix' => '',
                'picture' => '',
                'designation' => '',
                'status' => 'active'
            ]
        );
        DB::table('users')->insert([
                'username' => 'DOH124',
                'password' => bcrypt('DOH124'),
                'level' => 'doctor',
                'facility_id' => '2',
                'fname' => 'Ronadit',
                'mname' => 'Capala',
                'lname' => 'Arriesgado',
                'title' => '',
                'contact' => '418-7633',
                'email' => 'kpnurses@gmail.com',
                'muncity' => '64',
                'province' => '2',
                'accreditation_no' => '1244',
                'accreditation_validity' => '2020-11-12',
                'license_no' => '23457',
                'prefix' => '',
                'picture' => '',
                'designation' => '',
                'status' => 'active'
            ]
        );
    }
}
