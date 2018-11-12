<?php

namespace App\Policies;

use App\User;
use App\Import;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImportPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if($user->isAdmin()) {
            return true;
        }
        return false;
    }
    
    /**
     * Determine whether the user can view the import.
     *
     * @param  \App\User  $user
     * @param  \App\Import  $import
     * @return mixed
     */
    public function view(User $user, Import $import)
    {
        return false;
    }

    /**
     * Determine whether the user can create imports.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the import.
     *
     * @param  \App\User  $user
     * @param  \App\Import  $import
     * @return mixed
     */
    public function update(User $user, Import $import)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the import.
     *
     * @param  \App\User  $user
     * @param  \App\Import  $import
     * @return mixed
     */
    public function delete(User $user, Import $import)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the import.
     *
     * @param  \App\User  $user
     * @param  \App\Import  $import
     * @return mixed
     */
    public function restore(User $user, Import $import)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the import.
     *
     * @param  \App\User  $user
     * @param  \App\Import  $import
     * @return mixed
     */
    public function forceDelete(User $user, Import $import)
    {
        return false;
    }
}
