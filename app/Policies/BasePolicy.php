<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BasePolicy
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

    public function viewAny()
    {
        return true;
    }

    public function view()
    {
        return true;
    }

    public function create(){
        return true;
    }

    public function update(){
        return true;
    }

    public function delete(){
        return false;
    }

    public function restore(){
        return true;
    }
    public function forceDelete(){
        return false;
    }
}
