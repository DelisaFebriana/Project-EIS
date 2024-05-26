<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        
            $data = [
                'name' => 'delisa',
                'email'    => 'dls123@gmail.com',
                'password'    => 'delisa26',
            ];
            $this->db->table('users')->insert($data);
    }
}
