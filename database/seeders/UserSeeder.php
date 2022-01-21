<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = "Andres";
        $user->email = "aagilli20@gmail.com";
        $user->email_verified_at = "2021-10-06 19:11:51";
        $user->password = '$2y$10$hkAZW1vxeHFkgz18M61r1.Vq/kA9ngqm.abX36s/uK6O8Yp4r6Ni2';
        $user->phone = "3424621793";
        $user->address = "Uruguay 2796";
        $user->city = "Santa Fe";
        $user->level = 1;
        // migra el objeto a la db
        $user->save();
    }
}
