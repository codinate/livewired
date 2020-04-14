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

use KodeKeep\Livewired\Components\UpdateTeamMember;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class UpdateTeamMemberTest extends TestCase
{
    /** @test */
    public function can_update_the_name()
    {
        $team = $this->team();

        $this->actingAs($team->owner);

        Livewire::test(UpdateTeamMember::class)
            ->call('editTeamMember', $team->owner->id)
            ->set('role', 'member')
            ->call('updateTeamMember')
            ->assertEmitted('refreshTeamMembers');

        $this->assertSame('member', $team->members->first()->pivot->role);
    }
}
