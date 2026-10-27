<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class GameOwnershipTest extends TestCase
{
    use RefreshDatabase;

    public function test_other_user_cannot_see_or_change_a_game(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $game = new Game(['title' => 'Mario Kart', 'platform' => 'Switch']);
        $game->user_id = $owner->id;
        $game->save();

        $this->actingAs($other)->get('/games')->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('games/index')
                ->has('games', 0));

        $this->actingAs($other)->patch('/games/'.$game->id.'/toggle')
            ->assertForbidden();

        $this->assertDatabaseHas('games', ['id' => $game->id, 'completed' => false]);
    }

}
