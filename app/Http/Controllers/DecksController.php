<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Deck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class DecksController extends Controller
{
    public function index(): View
    {
        $decks = Deck::all();
        return view('decks.index', compact('decks'));
    }

    public function create(): View
    {
        return view('decks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'colors' => 'required|array',
            'colors.*' => 'in:green,red,black,blue,yellow,purple',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');

        $user = Auth::user();

        $user->decks()->create([
            'name' => $request->input('name'),
            'colors' => implode(',', $request->input('colors')),
            'thumbnail' => $thumbnailPath,
        ]);

        return redirect()->route('decks.index')->with('success', 'Deck created successfully!');
    }

    public function edit(Deck $deck): View|RedirectResponse
    {
        if (Gate::allows('edit-deck', $deck)) {
            return view('decks.edit', compact('deck'));
        } else {
            return redirect()->route('decks.index')->with('error', 'You do not have permission to edit this deck.');
        }
    }

    public function update(Request $request, Deck $deck): RedirectResponse
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to update a deck.');
        }

        if (Auth::user()->id !== $deck->user_id) {
            return redirect()->route('decks.index')->with('error', 'You do not have permission to update this deck.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'colors' => 'required|array',
            'colors.*' => 'in:green,red,black,blue,yellow,purple',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $deck->update([
            'name' => $request->input('name'),
            'colors' => implode(',', $request->input('colors')),
        ]);

        if ($request->hasFile('thumbnail')) {
            Storage::disk('public')->delete($deck->thumbnail);

            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $deck->update(['thumbnail' => $thumbnailPath]);
        }

        return redirect()->route('decks.index')->with('success', 'Deck updated successfully!');
    }

    public function delete(Deck $deck): RedirectResponse
    {
        if (Auth::user()->id !== $deck->user_id) {
            dd('kurwa');
            return redirect()->route('decks.index')->with('error', 'You do not have permission to delete this deck.');
        }

        $deck->delete();

        return redirect()->route('decks.index')->with('success', 'Deck deleted successfully!');
    }
}
