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

use KodeKeep\Livewired\Components\LeaveTeam;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class LeaveTeamTest extends TestCase
{
    /** @test */
    public function can_leave_the_team_if_it_is_a_member()
    {
        $user = $this->user();
        $team = $this->team();
        $team->addMember($user, 'member', []);

        $this->actingAs($user);

        $this->assertDatabaseHas('team_users', [
            'team_id'         => $user->id,
            'user_id'         => $team->id,
            'role'            => 'member',
        ]);

        Livewire::test(LeaveTeam::class, compact('team'))
            ->call('leaveTeam')
            ->assertEmitted('refreshTeams');

        $this->assertDatabaseMissing('team_users', [
            'team_id'         => $user->id,
            'user_id'         => $team->id,
            'role'            => 'member',
        ]);
    }
}
