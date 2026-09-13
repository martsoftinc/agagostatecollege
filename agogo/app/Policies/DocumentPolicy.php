<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function view(User $user, Document $document): bool
    {
        return $document->user_id === $user->id
            || $document->visibility === 'public'
            || $document->sharedWithUsers->contains($user);
    }

    public function download(User $user, Document $document): bool
    {
        // Currently same as view. You can make it stricter later if needed.
        return $this->view($user, $document);
    }

    public function update(User $user, Document $document): bool
    {
        return $document->user_id === $user->id;   // only owner
    }

    public function delete(User $user, Document $document): bool
    {
        return $document->user_id === $user->id;   // only owner
    }
}