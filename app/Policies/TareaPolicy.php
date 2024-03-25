<?php

namespace App\Policies;

use App\Models\Tarea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TareaPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tarea $tarea): bool
    {
        //
    }

    public function modifyEmployeeTask(User $user, Tarea $tarea): bool
    {
        return $user->hasRole('super-admin') ? true : false;
    }


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('super-admin') ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tarea $tarea): bool
    {
        return  $user->hasRole('super-admin') || $tarea->user_id === $user->id ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasRole('super-admin') ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Tarea $tarea): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Tarea $tarea): bool
    {
        //
    }
}
