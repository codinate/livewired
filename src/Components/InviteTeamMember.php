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

namespace KodeKeep\Livewired\Components;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Str;
use KodeKeep\Teams\Contracts\Team;
use Ramsey\Uuid\Uuid;

class InviteTeamMember extends Component
{
    use Concerns\InteractsWithTeam;

    public ?string $email = null;

    public ?string $role = 'member';

    public $permissions = [];

    public function inviteTeamMember(): void
    {
        $this->validate([
            'email' => ['required', 'email', 'max:255'],
            'role'  => ['required', 'string', 'in:owner,member'],
        ]);

        if ($this->emailAlreadyOnTeam($this->team)) {
            $this->whenEmailAlreadyOnTeam();

            return;
        }

        if ($this->emailAlreadyInvited($this->team)) {
            $this->whenEmailAlreadyInvited();

            return;
        }

        $userClass = config('auth.providers.users.model');

        $invitedUser = $userClass::where('email', $this->email)->first();

        $invitation = $this->createInvitation($invitedUser);

        $invitation->user_id
            ? $this->inviteExistingUser($invitation)
            : $this->inviteNewUser($invitation);

        $this->reset();

        $this->emit('refreshTeamMembers');
    }

    protected function emailAlreadyOnTeam(Team $team): bool
    {
        return $team->members()->where('email', $this->email)->exists();
    }

    protected function emailAlreadyInvited(Team $team): bool
    {
        return $team->invitations()->where('email', $this->email)->exists();
    }

    protected function createInvitation(?Authenticatable $invitedUser)
    {
        return $this->team->invitations()->create([
            'id'           => Uuid::uuid4(),
            'user_id'      => $invitedUser ? $invitedUser->id : null,
            'role'         => $this->role,
            'permissions'  => $this->permissions,
            'email'        => $this->email,
            'accept_token' => Str::random(40),
            'reject_token' => Str::random(40),
        ]);
    }
}
