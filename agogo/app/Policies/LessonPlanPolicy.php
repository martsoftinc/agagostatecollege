<?php

namespace App\Policies;

use App\Models\LessonPlan;
use App\Models\User;

class LessonPlanPolicy
{
    public function view(User $user, LessonPlan $lessonPlan): bool
    {
        // Public plans → anyone can view
        if ($lessonPlan->visibility === 'public') {
            return true;
        }

        // Owner can always view
        if ($lessonPlan->user_id === $user->id) {
            return true;
        }

        // Shared private plans
        return $lessonPlan->sharedWithUsers()
            ->where('users.id', $user->id)
            ->exists();
    }

    public function update(User $user, LessonPlan $lessonPlan): bool
    {
        // Owner
        if ($lessonPlan->user_id === $user->id) {
            return true;
        }

        // Shared with edit permission
        return $lessonPlan->sharedWithUsers()
            ->where('users.id', $user->id)
            ->wherePivot('permission', 'edit')
            ->exists();
    }

    public function delete(User $user, LessonPlan $lessonPlan): bool
    {
        return $lessonPlan->user_id === $user->id;
    }
}