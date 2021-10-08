<?php

namespace App\Policies;

use App\Models\User;
use App\Nova\Link;
use Illuminate\Auth\Access\HandlesAuthorization;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $currentUser, Role $role)
    {
        return  $currentUser->can('manage_users') && $role->id != 1;
    }

    public function view()
    {
        return true;
    }

    public function viewAny(User $currentUser)
    {
        return  $currentUser->can('manage_users');
    }

    public function create(User $currentUser){
        return  $currentUser->can('manage_users');
    }

    public function delete(User $currentUser, Role $role){
        return  $currentUser->can('manage_users') && $role->id != 1;
    }

    public function restore(User $currentUser){
        return  $currentUser->can('manage_users');
    }
    public function forceDelete(User $currentUser){
        return  $currentUser->can('manage_users');
    }

}
