<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Role;
use Faker\Generator as Faker;
use Spatie\Permission\Models\Permission;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' =>'Super Admin',
        'guard_name' => 'api'
    ];
});
$factory->afterCreating(Role::class, function($role){
    $permissions = [
        'View All Users',
        'Edit All Users',
        'Assign Role',
        'Unassign Role',
        'View All Permissions',
        'View All Roles',
        'Create Role'
    ];
    foreach ($permissions as $perm_name) {
        $permission = Permission::updateOrCreate(['name' => $perm_name, 'guard_name' => 'api']);

        $role->givePermissionTo($permission);
    }

});
