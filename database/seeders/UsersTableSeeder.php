<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    public function run()
    {

        \DB:: table('company')->insert([
            'id' => 1,
            'company_name' => 'RTMI Company',
            'address' => 'Amfana Village Macanhan Carmen, Cagayan de Oro City, Misamis Oriental, Philippines, 9000',
            'contact_no' => '9363572098',
            'email' => 'admin',
            'password' => bcrypt('admin123'),
            'description' => 'Best Bus in the City',
        ]);

        \DB:: table('users')->insert([
            'company_id' => 1,
            'name' => 'RTMI Company',
            'email' => 'admin',
            'password' => bcrypt('admin123'),
            'user_type' => 1,
        ]);

        \DB:: table('company')->insert([
            'id' => 2,
            'company_name' => 'VANILLA Company',
            'address' => 'Amfana Village Macanhan Carmen, Cagayan de Oro City, Misamis Oriental, Philippines, 9000',
            'contact_no' => '9363572098',
            'email' => 'admin1',
            'password' => bcrypt('admin123'),
            'description' => 'Best Bus in the City of El Salvador',
        ]);

        \DB:: table('users')->insert([
            'company_id' => 2,
            'name' => 'VANILLA Company',
            'email' => 'admin1',
            'password' => bcrypt('admin123'),
            'user_type' => 1,
        ]);

        
    }
}
