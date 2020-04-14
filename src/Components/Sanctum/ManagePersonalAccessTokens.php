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

namespace KodeKeep\Livewired\Components\Sanctum;

use Illuminate\Support\Collection;
use KodeKeep\Livewired\Components\Component;
use KodeKeep\Livewired\Components\Concerns\InteractsWithUser;

class ManagePersonalAccessTokens extends Component
{
    use InteractsWithUser;

    protected $listeners = [
        'refreshPersonalAccessTokens' => '$refresh',
    ];

    public function deletePersonalAccessToken(string $id): void
    {
        $this->user->tokens()->findOrFail($id)->delete();

        $this->emit('refreshPersonalAccessTokens');
    }

    public function getTokensProperty(): Collection
    {
        return $this->user->tokens;
    }
}
