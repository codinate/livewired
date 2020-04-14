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

use KodeKeep\Livewired\Components\Component;
use KodeKeep\Livewired\Components\Concerns\InteractsWithUser;

class CreatePersonalAccessToken extends Component
{
    use InteractsWithUser;

    public ?string $name = null;

    public ?string $accessToken = null;

    public function createPersonalAccessToken(): void
    {
        $this->validate([
            'name' => ['required', 'max:255'],
        ]);

        $this->accessToken = $this->user->createToken($this->name)->plainTextToken;

        $this->emit('refreshPersonalAccessTokens');
    }
}
