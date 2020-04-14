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

use KodeKeep\Livewired\Components\Sanctum\ManagePersonalAccessTokens;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class ManagePersonalAccessTokensTest extends TestCase
{
    /** @test */
    public function can_list_the_personal_access_tokens()
    {
        $this->actingAs($user = $this->user());

        $this->createToken($user);
        $this->createToken($user);

        $this->assertCount(2, $user->tokens);

        $component = Livewire::test(ManagePersonalAccessTokens::class);

        $user->tokens->each(fn ($token) => $component->assertSee($token->name));
    }

    /** @test */
    public function can_destroy_the_user_if_it_is_the_owner()
    {
        $this->actingAs($user = $this->user());

        $token = $this->createToken($user);

        $this->assertDatabaseHas('personal_access_tokens', ['id' => $token->id]);

        Livewire::test(ManagePersonalAccessTokens::class)
            ->call('deletePersonalAccessToken', $token->id);

        $this->assertDatabaseMissing('personal_access_tokens', ['id' => $token->id]);
    }
}
