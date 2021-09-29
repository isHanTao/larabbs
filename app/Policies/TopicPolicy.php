<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;

class TopicPolicy extends Policy
{
    public function update(User $user, Topic $topic)
    {
         return $topic->user_id == $user->id || $user->can('manage_contents');
//        return true;
    }

    public function destroy(User $user, Topic $topic)
    {
        return $topic->user_id == $user->id || $user->can('manage_contents');
    }
    public function view()
    {
        return true;
    }
    public function create(){
        return true;
    }
}
