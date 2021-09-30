<?php

namespace App\Policies;

use App\Models\User;
use App\Nova\Link;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinkPolicy
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

    public function update(User $currentUser)
    {
        return  $currentUser->can('edit_settings');
    }

    public function view()
    {
        return true;
    }

    public function viewAny(User $currentUser)
    {
        return  $currentUser->can('edit_settings');
    }

    public function create(User $currentUser){
        return  $currentUser->can('edit_settings');
    }

    public function delete(User $currentUser){
        return  $currentUser->can('edit_settings');
    }

    public function restore(User $currentUser){
        return  $currentUser->can('edit_settings');
    }
    public function forceDelete(User $currentUser){
        return  $currentUser->can('edit_settings');
    }

}
