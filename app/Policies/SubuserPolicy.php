<?php

namespace App\Policies;

use App\Models\Subuser;
use App\Models\User;

class SubuserPolicy
{
    /**
     * Determine if the user can view the subuser.
     */
    public function view(User $user, Subuser $subuser): bool
    {
        return $user->organization_id === $subuser->organization_id;
    }

    /**
     * Determine if the user can create a subuser.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can update the subuser.
     */
    public function update(User $user, Subuser $subuser): bool
    {
        return $user->organization_id === $subuser->organization_id && $user->id === $subuser->parent_user_id;
    }

    /**
     * Determine if the user can delete the subuser.
     */
    public function delete(User $user, Subuser $subuser): bool
    {
        return $user->organization_id === $subuser->organization_id && $user->id === $subuser->parent_user_id;
    }

    /**
     * Determine if the user can restore the subuser.
     */
    public function restore(User $user, Subuser $subuser): bool
    {
        return $user->organization_id === $subuser->organization_id && $user->id === $subuser->parent_user_id;
    }

    /**
     * Determine if the user can force delete the subuser.
     */
    public function forceDelete(User $user, Subuser $subuser): bool
    {
        return $user->organization_id === $subuser->organization_id && $user->id === $subuser->parent_user_id;
    }
}
