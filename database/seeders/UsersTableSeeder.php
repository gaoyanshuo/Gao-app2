<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(50)->create();

        $user = User::find(1);
        $user->name = 'gao';
        $user->email = 'gaoyanshuo9388@yahoo.com';
        $user->password = bcrypt('111111');
        $user->is_admin = true;
        $user->save();
    }
}
