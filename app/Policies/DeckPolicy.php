<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Deck;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeckPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any decks.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can edit the deck.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Deck  $deck
     * @return mixed
     */
    public function editDeck(User $user, Deck $deck)
    {
        return $user->id === $deck->user_id;
    }
}

