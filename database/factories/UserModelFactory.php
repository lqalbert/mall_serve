<?php
use App\Models\Role;

/*
 * user_basic 表数据生成 
 * 普通员工
 * 
 */
 
 /** @var \Illuminate\Database\Eloquent\Factory $fatctory */

$factory->define(App\Models\User::class, function (Faker\Generator $faker){
   static $password = null;
   static $roleNames = ['sale-staff', 'sale-captain', 'sale-manager'];
   
   if (empty($password)) {
       $password = bcrypt('123456');
   }
   $index = array_rand($roleNames);
   $role = Role::where('name',  $roleNames[$index])->firstOrFail();
   
   return [
       'account'=> $faker->unique()->firstName,
       'password' => $password,
       'role_id' => $role->id
   ];
});


        