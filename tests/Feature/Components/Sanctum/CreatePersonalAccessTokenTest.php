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

namespace KodeKeep\Livewired\Tests\Feature\Components\Sanctum;

use KodeKeep\Livewired\Components\Sanctum\CreatePersonalAccessToken;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class CreatePersonalAccessTokenTest extends TestCase
{
    /** @test */
    public function can_create_the_personal_token()
    {
        $this->actingAs($this->user());

        Livewire::test(CreatePersonalAccessToken::class)
            ->set('name', '...')
            ->call('createPersonalAccessToken')
            ->assertEmitted('refreshPersonalAccessTokens')
            ->assertHasNoErrors();
    }

    /** @test */
    public function cant_create_the_personal_token_if_the_name_is_empty()
    {
        $this->actingAs($this->user());

        Livewire::test(CreatePersonalAccessToken::class)
            ->call('createPersonalAccessToken')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_create_the_personal_token_if_the_name_is_longer_than_255_characters()
    {
        $this->actingAs($this->user());

        Livewire::test(CreatePersonalAccessToken::class)
            ->set('name', str_repeat('x', 256))
            ->call('createPersonalAccessToken')
            ->assertHasErrors(['name' => 'max']);
    }
}
