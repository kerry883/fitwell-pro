<?php

namespace App\Policies;

use App\Models\Program;
use App\Models\User;
use App\Enums\ProgramAssignmentStatus;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProgramPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        // Anyone can browse the list of programs
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Program $program)
    {
        // Allow the trainer who owns the program to view it
        if ($user->id === $program->trainer_id) {
            return true;
        }

        // Allow a client with an 'active' assignment to view the program content
        return $user->programAssignments()
                    ->where('program_id', $program->id)
                    ->where('status', ProgramAssignmentStatus::ACTIVE)
                    ->exists();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        // Only trainers can create programs
        return $user->isTrainer();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Program $program)
    {
        // Only the trainer who owns the program can update it
        return $user->id === $program->trainer_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Program $program)
    {
        // Only the trainer who owns the program can delete it
        return $user->id === $program->trainer_id;
    }

    /**
     * Determine whether a client can enroll in the program.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Program  $program
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function enroll(User $user, Program $program)
    {
        // Prevent the trainer from enrolling in their own program
        if ($user->id === $program->trainer_id) {
            return false;
        }

        // Prevent a client from enrolling if they already have an assignment (regardless of status)
        return !$user->programAssignments()
                     ->where('program_id', $program->id)
                     ->exists();
    }
}
