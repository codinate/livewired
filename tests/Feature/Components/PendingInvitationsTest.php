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

namespace KodeKeep\Livewired\Feature\Components;

use Illuminate\Foundation\Testing\RefreshDatabase;
use KodeKeep\Livewired\Components\PendingInvitations;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

/**
 * @covers \KodeKeep\Livewired\Components\PendingInvitations
 */
class PendingInvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_accept_an_invitation()
    {
        $user = $this->user();
        $team = $this->team();

        $this->actingAs($user);

        $invitation = $this->createInvitation($team, $user);

        $this->assertDatabaseHas('team_invitations', [
            'id'      => $invitation->id,
            'user_id' => $team->id,
        ]);

        $this->assertDatabaseMissing('team_users', [
            'team_id' => $user->id,
            'user_id' => $team->id,
            'role'    => 'member',
        ]);

        Livewire::test(PendingInvitations::class)
            ->call('acceptInvitation', $invitation->id);

        $this->assertDatabaseHas('team_users', [
            'team_id' => $user->id,
            'user_id' => $team->id,
            'role'    => 'member',
        ]);
    }

    /** @test */
    public function can_reject_an_invitation()
    {
        $user = $this->user();
        $team = $this->team();

        $this->actingAs($user);

        $invitation = $this->createInvitation($team, $user);

        $this->assertDatabaseHas('team_invitations', [
            'id'      => $invitation->id,
            'user_id' => $team->id,
        ]);

        $this->assertDatabaseMissing('team_users', [
            'team_id' => $user->id,
            'user_id' => $team->id,
            'role'    => 'member',
        ]);

        Livewire::test(PendingInvitations::class)
            ->call('rejectInvitation', $invitation->id);

        $this->assertDatabaseMissing('team_users', [
            'team_id' => $user->id,
            'user_id' => $team->id,
            'role'    => 'member',
        ]);
    }
}
