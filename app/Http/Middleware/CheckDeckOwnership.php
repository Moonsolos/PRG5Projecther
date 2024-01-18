<?php

namespace App\Http\Middleware;

use App\Models\Deck;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckDeckOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(Request): (Response) $next
     * @return RedirectResponse|mixed|Response
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $deckId = $request->route('deck');
        $deck = Deck::find($deckId)->first();

        if ($deck->user_id !== Auth::id()) {
            return redirect()->route('decks.index')->with('error', 'You do not have permission to edit this deck.');
        }

        return $next($request);
    }
}
