<?php

namespace App\Policies;

use App\Models\User;
use App\Nova\Link;
use Illuminate\Auth\Access\HandlesAuthorization;

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

    public function update(User $currentUser, Link $link)
    {
        return  $currentUser->can('manage_users');
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

    public function delete(User $currentUser, User $user){
        return  $currentUser->can('manage_users');
    }

    public function restore(User $currentUser){
        return  $currentUser->can('manage_users');
    }
    public function forceDelete(User $currentUser){
        return  $currentUser->can('manage_users');
    }

}
