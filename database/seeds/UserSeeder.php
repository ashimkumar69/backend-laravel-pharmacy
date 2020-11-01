<?php


use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $user = User::create([
            'name' => "sa",
            'email' => 'sa@sa.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->userdetail()->create();

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'User']);
        $user->assignRole('Super Admin');
    }
}
