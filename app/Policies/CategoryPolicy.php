<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
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
        return $currentUser->can('manage_contents');
    }

    public function view()
    {
        return true;
    }

    public function viewAny()
    {
        return true;
    }

    public function create(){
        return false;
    }

    public function delete(){
        return false;
    }

    public function restore(){
        return false;
    }
    public function forceDelete(){
        return false;
    }

}
