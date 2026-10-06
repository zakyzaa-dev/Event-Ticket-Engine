<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Hanni Pham',
                'email' => 'hannibanni@newjeans.com',
                'password' => bcrypt('hannihan1234')
            ],
            [
                'name' => 'Kang Haering',
                'email' => 'haeringkang@newjeans.com',
                'password' => bcrypt('kangkang@1234')
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        };
    }
}
