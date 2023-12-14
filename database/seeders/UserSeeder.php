<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // An admin should be able to register users, add books and manage book loans.
    // A user should be able to borrow an available book.
    // An admin should be able to approve the book loan and issue the book to the user.
    // Users should be able to extend the book loan if they cannot return it within the
    // specified return date.
    // Otherwise, an admin should be able to receive the book back from the user.
    // For this code challenge, think over and above.
    // To meet your additional requirements, normalise the database further to meet your
    // needs

    private $permissions = [
        'add_user',
        'edit_user',
        'delete_user',
        'view_user',
        'add_role',
        'delete_role',
        'view_role',
        'add_permission',
        'edit_permission',
        'delete_permission',
        'view_permission',
        'view_profile',
        'edit_profile',
        'add_books',
        'edit_books',
        'delete_books',
        'view_books',
        'add_category',
        'edit_category',
        'delete_category',
        'view_category',
        'approve_book_loan',
        'view_book_loan',
        'view_book_loan_history',
        'extend_book_loan',
        'add_book_loan',
        'mark_book_loan_returned',

    ];










    public function run(): void
    {
        //create permissions
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        //create users

        $adminUser = new User();

        $adminUser->name = 'Administator';
        $adminUser->email = 'admin@library.com';
        $adminUser->password = Hash::make('password');

        $adminUser->save();

        $role = Role::create(['name' => 'admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $adminUser->assignRole([$role->id]);


        $user = new User();

        $user->name = 'User';

        $user->email = 'johndoe@library.com';

        $user->password = Hash::make('password');

        $user->save();

        $role = Role::create(['name' => 'user']);

        //add permissions to user role with the following permissions
        $userPermissions = [
            'view_profile',
            'edit_profile',
            'view_books',
            'view_category',
            'add_book_loan',
            'view_book_loan',
            'view_book_loan_history',
            'extend_book_loan',
            'mark_book_loan_returned',
        ];

        $permissions = Permission::whereIn('name', $userPermissions)->pluck('id', 'id')->all();




        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);








    }
}