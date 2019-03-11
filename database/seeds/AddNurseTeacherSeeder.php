<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class AddNurseTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new Role();
        $administrator->name = 'nurse_teacher';
        $administrator->display_name = '护理老师';
        $administrator->description = '编写护理方案';
        $administrator->save();
    }
}
