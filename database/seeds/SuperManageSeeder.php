<?php

use Illuminate\Database\Seeder;
use App\Manager;

class SuperManageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $managers = new Manager();

        $superManager = $managers->where(['account' => 'admin'])->first();

        if (!$superManager) {
            $managers->create([
                    'account' => 'admin',
                    'password' => 'dddddd'
                ]
            );
        }
    }
}
