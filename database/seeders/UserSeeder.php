<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Provider\en_US\PhoneNumber;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();


        User::create([
            'name' => 'Mohammed Ameen',
            'username' => 'mohammed',
            'email' => 'mohammed@gmail.test',
            'mobile' => $faker->e164PhoneNumber(),
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('24682468'),
            'status' => 1,
        ]);

        User::create([
            'name' => 'Ahmed Mahfouz',
            'username' => 'ahmed',
            'email' => 'ahmed@gmail.test',
            'mobile' => $faker->e164PhoneNumber(),
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('24682468'),
            'status' => 1,
        ]);

        User::create([
            'name' => 'Fady Ibrahim',
            'username' => 'fady',
            'email' => 'fady@gmail.test',
            'mobile' => $faker->e164PhoneNumber() ,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('24682468'),
            'status' => 1,
        ]);



    }
}
