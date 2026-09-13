<?php

namespace App\Policies;

use App\Models\Sewa;
use App\Models\Admin;

class SewaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Admin $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Admin $user, Sewa $sewa): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Admin $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Admin $user, Sewa $sewa): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Admin $user, Sewa $sewa): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Admin $user, Sewa $sewa): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Admin $user, Sewa $sewa): bool
    {
        //
    }
}
