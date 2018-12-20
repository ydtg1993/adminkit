<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Role();
        if (!$model->where('name', '超级管理员')->first()) {
            $model->create([
                'name' => '超级管理员'
            ]);
        }
    }
}
