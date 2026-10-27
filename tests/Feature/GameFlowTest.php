<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class GameFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/games')->assertRedirect('/login');
    }

    public function test_game_is_saved_for_logged_in_user_and_sent_to_react(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $this->actingAs($owner)->post('/games', [
            'title' => 'Minecraft', 'platform' => 'PC', 'user_id' => $other->id,
        ])->assertRedirect('/games');
        $this->assertDatabaseHas('games', [
            'title' => 'Minecraft', 'user_id' => $owner->id, 'completed' => false,
        ]);
        $this->get('/games')->assertInertia(fn (Assert $page) => $page
            ->component('games/index')->has('games', 1)
            ->where('games.0.title', 'Minecraft')->where('games.0.completed', false));
    }

    public function test_empty_title_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())->from('/games')->post('/games', [
            'title' => '', 'platform' => 'PC',
        ])->assertRedirect('/games')->assertSessionHasErrors(['title' => 'Vul een titel in.']);
        $this->assertDatabaseCount('games', 0);
    }

    public function test_title_longer_than_eighty_characters_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())->post('/games', [
            'title' => str_repeat('a', 81), 'platform' => 'PC',
        ])->assertSessionHasErrors('title');
        $this->assertDatabaseCount('games', 0);
    }

    public function test_unknown_platform_is_rejected(): void
    {
        $this->actingAs(User::factory()->create())->post('/games', [
            'title' => 'Minecraft', 'platform' => 'invalid',
        ])->assertSessionHasErrors('platform');
        $this->assertDatabaseCount('games', 0);
    }
}
