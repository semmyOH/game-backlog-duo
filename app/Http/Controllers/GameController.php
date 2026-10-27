<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class GameController extends Controller
{
    public function index(Request $request): Response
    {
        $games = Game::where('user_id', $request->user()->id)
            ->latest('id')
            ->get(['id', 'title', 'platform', 'completed']);

        return Inertia::render('games/index', ['games' => $games]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:80'],
            'platform' => ['required', 'in:PC,PlayStation,Xbox,Switch'],
        ], [
            'title.required' => 'Vul een titel in.',
            'title.max' => 'Gebruik maximaal 80 tekens.',
            'platform.required' => 'Kies een platform.',
            'platform.in' => 'Kies een platform uit de lijst.',
        ]);

        $game = new Game($data);
        $game->user_id = $request->user()->id;
        $game->save();

        return to_route('games.index');
    }

    public function toggle(Request $request, Game $game): RedirectResponse
    {
        abort_unless((int) $game->user_id === (int) $request->user()->id, 403);

        // TODO 1: draai de boolean om. Nu blijft de waarde nog hetzelfde.
        $game->completed = $game->completed;
        $game->save();

        return to_route('games.index');
    }
}
