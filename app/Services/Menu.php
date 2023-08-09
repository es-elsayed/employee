<?php
namespace App\Services;

class Menu
{
    static function nav()
    {
        return [
            [
                'label' => 'Dashboard',
                'url' => route('admin.dashboard'),
                'isActive' => request()->routeIs('admin.dashboard'),
                'isVisible' => true,
            ],
            [
                'label' => 'Permissions',
                'url' => route('admin.permissions.index'),
                'isActive' => request()->routeIs('admin.permissions.*'),
                'isVisible' => request()->user()?->can('permissions-read'),
            ],
            [
                'label' => 'Roles',
                'url' => route('admin.roles.index'),
                'isActive' => request()->routeIs('admin.roles.*'),
                'isVisible' => request()->user()?->can('roles-read'),
            ],
            [
                'label' => 'Users',
                'url' => route('admin.users.index'),
                'isActive' => request()->routeIs('admin.users.*'),
                'isVisible' => request()->user()?->can('users-read'),
            ],
            // [
            //     'label' => 'Categories',
            //     'url' => route('admin.categories.index'),
            //     'isActive' => request()->routeIs('admin.categories.*'),
            //     'isVisible' => request()->user()?->can('categories-read'),
            // ],
            // [
            //     'label' => 'Products',
            //     'url' => route('admin.products.index'),
            //     'isActive' => request()->routeIs('admin.products.*'),
            //     'isVisible' => request()->user()?->can('products-read'),
            // ],
        ];
    }
}
