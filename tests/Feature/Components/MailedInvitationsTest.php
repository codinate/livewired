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

use KodeKeep\Livewired\Components\MailedInvitations;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class MailedInvitationsTest extends TestCase
{
    /** @test */
    public function can_cancel_an_invitation()
    {
        $user = $this->user();
        $team = $this->team();

        $invitation = $this->createInvitation($team, $user);

        $this->actingAs($user);

        $this->assertDatabaseHas('team_invitations', [
            'id'      => $invitation->id,
            'user_id' => $team->id,
        ]);

        $this->actingAs($team->owner);

        Livewire::test(MailedInvitations::class)
            ->call('cancelInvitation', $invitation->id);

        $this->assertDatabaseMissing('team_invitations', [
            'id'      => $invitation->id,
            'user_id' => $team->id,
        ]);
    }
}
