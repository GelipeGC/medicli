<?php

namespace Database\Factories;

use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    public function configure()
    {
        return $this->afterCreating(function($role){
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
    }

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>'Super Admin',
            'guard_name' => 'api'
        ];
    }
}
