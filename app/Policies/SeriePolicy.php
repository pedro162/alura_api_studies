<?php

namespace App\Policies;

use App\Models\Serie;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SeriePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Serie $serie): bool
    {
        return $user->id === $serie->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Serie $serie): bool
    {
        return $user->id === $serie->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateResponse(User $user, Serie $serie): Response
    {
        return $user->id === $serie->id
            ? Response::allow()
            : Response::deny('You do not own this serie.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateResponse2(User $user, Serie $serie): Response
    {
        /* return $user->id === $serie->id
            ? Response::allow()
            : Response::denyWithStatus(404); */

        return $user->id === $serie->id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateResponse3(?User $user, Serie $serie): bool
    {
        return $user?->id === $serie->id;;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function updateResponse4(?User $user, Serie $serie): bool|null
    {
        if ($user->id == $serie->id) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Serie $serie): bool
    {
        return $user->id === $serie->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Serie $serie): bool
    {
        return $user->id === $serie->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Serie $serie): bool
    {
        return false;
    }
}
