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

use KodeKeep\Livewired\Components\TeamSwitcher;
use KodeKeep\Livewired\Tests\TestCase;
use KodeKeep\Livewired\Tests\User;
use KodeKeep\Teams\Models\Team;
use Livewire\Livewire;

class TeamSwitcherTest extends TestCase
{
    /** @test */
    public function renders_the_team_name()
    {
        $user  = factory(User::class)->create();
        $teams = factory(Team::class, 5)->create(['owner_id' => $user->id]);

        $teams->each(function ($team) use ($user) {
            $team->addMember($user, 'owner', []);
        });

        $user->switchToTeam($currentTeam = $teams->first());

        $this->actingAs($user);

        Livewire::test(TeamSwitcher::class)
            ->assertSee($currentTeam->name)
            ->assertSee($teams[1]->name)
            ->assertSee($teams[2]->name)
            ->assertSee($teams[3]->name)
            ->assertSee($teams[4]->name);
    }

    /** @test */
    public function can_switch_to_an_owned_team()
    {
        $user  = factory(User::class)->create();
        $teams = factory(Team::class, 5)->create(['owner_id' => $user->id]);

        $teams->each(fn ($team) => $team->addMember($user, 'owner', []));

        $user->switchToTeam($firstTeam = $teams->first());

        $lastTeam = $teams->last();

        $this->actingAs($user);

        Livewire::test(TeamSwitcher::class)
            ->assertSee($firstTeam->name)
            ->call('switchTeam', $lastTeam->id)
            ->assertSee($lastTeam->name.' is active')
            ->assertSee($firstTeam->name);
    }
}
