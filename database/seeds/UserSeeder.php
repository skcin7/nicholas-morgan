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
//        factory(App\User::class, 1)->create();

        $admins = factory(App\User::class, 1)->states('admin')->make();
        $regularUsers = factory(App\User::class, 10)->states('regularUser')->make();
    }
}
