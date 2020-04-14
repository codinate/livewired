<?php

declare(strict_types=1);

/*
 * This file is part of kodekeep/livewired.
 *
 * (c) KodeKeep <hello@kodekeep.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KodeKeep\Livewired\Tests\Feature\Components;

use KodeKeep\Livewired\Components\ManageTeams;
use KodeKeep\Livewired\Tests\TestCase;
use KodeKeep\Teams\Models\Team;
use Livewire\Livewire;

class ManageTeamsTest extends TestCase
{
    /** @test */
    public function can_list_the_available_teams()
    {
        $this->actingAs($user = $this->user());

        factory(Team::class, 10)
            ->create(['owner_id' => $user->id])
            ->each(fn ($team) => $team->addMember($user, 'owner', []));

        $component = Livewire::test(ManageTeams::class);

        $user->ownedTeams->each(fn ($method) => $component->assertSee($method->name));
    }

    /** @test */
    public function can_destroy_the_team_if_it_is_the_owner()
    {
        $team = $this->team();

        $this->actingAs($team->owner);

        $this->assertDatabaseHas('teams', ['id' => $team->id]);

        Livewire::test(ManageTeams::class)
            ->call('deleteTeam', $team->id);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }

    /** @test */
    public function can_switch_to_another_team()
    {
        $this->actingAs($user = $this->user());

        factory(Team::class, 10)
            ->create(['owner_id' => $user->id])
            ->each(fn ($team) => $team->addMember($user, 'owner', []));

        $component = Livewire::test(ManageTeams::class);

        $component->call('switchTeam', 2);

        $this->assertDatabaseHas('users', ['current_team_id' => 2]);

        $component->call('switchTeam', 3);

        $this->assertDatabaseHas('users', ['current_team_id' => 3]);
    }
}
