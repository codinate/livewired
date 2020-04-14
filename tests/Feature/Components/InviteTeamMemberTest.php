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

use Illuminate\Support\Facades\Mail;
use KodeKeep\Livewired\Components\InviteTeamMember;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class InviteTeamMemberTest extends TestCase
{
    /** @test */
    public function can_invite_an_existing_user()
    {
        Mail::fake();

        $this->actingAs($this->team()->owner);

        InviteTeamMember::macro('inviteExistingUser', fn () => $this->emit('inviteExistingUser'));

        Livewire::test(InviteTeamMember::class)
            ->set('email', $this->user()->email)
            ->set('role', 'member')
            ->call('inviteTeamMember')
            ->assertEmitted('refreshTeamMembers')
            ->assertEmitted('inviteExistingUser');
    }

    /** @test */
    public function can_invite_a_new_user()
    {
        Mail::fake();

        $this->actingAs($this->team()->owner);

        InviteTeamMember::macro('inviteNewUser', fn () => $this->emit('inviteNewUser'));

        Livewire::test(InviteTeamMember::class)
            ->set('email', 'hello@world.com')
            ->set('role', 'member')
            ->call('inviteTeamMember')
            ->assertEmitted('refreshTeamMembers')
            ->assertEmitted('inviteNewUser');
    }

    /** @test */
    public function cant_invite_a_new_user_if_the_email_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(InviteTeamMember::class)
            ->call('inviteTeamMember')
            ->assertHasErrors(['email' => 'required']);
    }

    /** @test */
    public function cant_invite_a_new_user_if_the_email_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(InviteTeamMember::class)
            ->set('email', 'invalid')
            ->call('inviteTeamMember')
            ->assertHasErrors(['email' => 'email']);
    }

    /** @test */
    public function cant_invite_a_new_user_if_the_email_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(InviteTeamMember::class)
            ->set('email', 'hello@world.com'.str_repeat('x', 255))
            ->call('inviteTeamMember')
            ->assertHasErrors(['email' => 'max']);
    }

    /** @test */
    public function cant_invite_a_user_if_it_is_already_on_the_team()
    {
        $team = $this->team();

        $this->actingAs($team->owner);

        InviteTeamMember::macro('whenEmailAlreadyOnTeam', fn () => $this->emit('whenEmailAlreadyOnTeam'));

        Livewire::test(InviteTeamMember::class)
            ->set('email', $team->owner->email)
            ->call('inviteTeamMember')
            ->assertEmitted('whenEmailAlreadyOnTeam');
    }

    /** @test */
    public function can_not_invite_a_user_if_it_is_already_invited_to_team()
    {
        $user = $this->user();
        $team = $this->team();

        $this->createInvitation($team, $user);

        $this->actingAs($team->owner);

        InviteTeamMember::macro('whenEmailAlreadyInvited', fn () => $this->emit('whenEmailAlreadyInvited'));

        Livewire::test(InviteTeamMember::class)
            ->set('email', $user->email)
            ->call('inviteTeamMember')
            ->assertEmitted('whenEmailAlreadyInvited');
    }
}
