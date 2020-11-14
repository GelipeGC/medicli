<?php

namespace Database\Seeders;

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        $this->fecthRelations();
        $this->createSuperAdmin();
    }
    protected function fecthRelations()
    {
        $this->roles = Role::all();
    }
    protected function createSuperAdmin()
    {
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('secret123'),
        ]);
        $superAdminRole = Role::where('name', "Super Admin")->first();
        $user->assignRole($superAdminRole);
    }
}
