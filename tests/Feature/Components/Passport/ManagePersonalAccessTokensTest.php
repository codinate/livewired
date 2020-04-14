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

namespace KodeKeep\Livewired\Tests\Feature\Components\Passport;

use Illuminate\Support\Facades\Hash;
use KodeKeep\Livewired\Components\Passport\ManagePersonalAccessTokens;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class ManagePersonalAccessTokensTest extends TestCase
{
    /** @test */
    public function can_list_the_personal_access_tokens()
    {
        $this->actingAs($user = $this->makeUser());

        $this->createToken($user);
        $this->createToken($user);

        $this->assertCount(2, $user->tokens);

        $component = Livewire::test(ManagePersonalAccessTokens::class);

        $user->tokens->each(fn ($token) => $component->assertSee($token->name));
    }

    /** @test */
    public function can_destroy_the_user_if_it_is_the_owner()
    {
        $this->actingAs($user = $this->makeUser());

        $token = $this->createToken($user);

        $this->assertDatabaseHas('oauth_access_tokens', ['id' => $token->id]);

        Livewire::test(ManagePersonalAccessTokens::class)
            ->call('deletePersonalAccessToken', $token->id);

        $this->assertDatabaseMissing('oauth_access_tokens', ['id' => $token->id]);
    }

    protected function makeUser(): UserWithPassport
    {
        $user = new UserWithPassport();

        $user->forceFill([
            'name'     => $this->faker->name,
            'email'    => $this->faker->safeEmail,
            'password' => Hash::make('password'),
        ])->save();

        return $user;
    }
}
