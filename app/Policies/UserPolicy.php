<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

    public function update(User $currentUser, User $user)
    {
        return ($currentUser->id == $user->id) || (!$user->hasRole('Founder') &&  $currentUser->can('manage_users'));
    }

    public function view()
    {
        return true;
    }

    public function viewAny()
    {
        return true;
    }

    public function create(User $currentUser){
        return $currentUser->can('manage_users');
    }

    public function delete(User $currentUser, User $user){
        return  !$user->hasRole('Founder') && $currentUser->can('manage_users');
    }

    public function restore(User $currentUser){
        return $currentUser->can('manage_users');
    }
    public function forceDelete(User $currentUser){
        return $currentUser->can('manage_users');
    }

}
