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

use KodeKeep\Livewired\Components\Sanctum\UpdatePersonalAccessToken;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class UpdatePersonalAccessTokenTest extends TestCase
{
    /** @test */
    public function can_update_the_name()
    {
        $this->actingAs($user = $this->user());

        Livewire::test(UpdatePersonalAccessToken::class)
            ->call('editPersonalAccessToken', $this->createToken($user)->id)
            ->call('updatePersonalAccessToken')
            ->assertHasNoErrors('name');
    }

    /** @test */
    public function cant_update_the_name_if_it_is_empty()
    {
        $this->actingAs($user = $this->user());

        Livewire::test(UpdatePersonalAccessToken::class)
            ->call('editPersonalAccessToken', $this->createToken($user)->id)
            ->set('name', null)
            ->call('updatePersonalAccessToken')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_update_the_name_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($user = $this->user());

        Livewire::test(UpdatePersonalAccessToken::class)
            ->call('editPersonalAccessToken', $this->createToken($user)->id)
            ->set('name', str_repeat('x', 256))
            ->call('updatePersonalAccessToken')
            ->assertHasErrors(['name' => 'max']);
    }
}
