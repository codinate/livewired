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

class TeamSwitcher extends Component
{
    use Concerns\InteractsWithUser;

    public function switchTeam(string $id): void
    {
        $team = $this->user->teams()->findOrFail($id);

        abort_unless($this->user->onTeam($team), 404);

        $this->user->switchToTeam($team);
    }
}
