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

use Illuminate\Support\Str;
use KodeKeep\Livewired\Components\DisableTwoFactorAuth;
use KodeKeep\Livewired\Tests\TestCase;
use KodeKeep\Livewired\Tests\User;
use Livewire\Livewire;

class DisableTwoFactorAuthTest extends TestCase
{
    /** @test */
    public function can_disable_two_factor_authentication()
    {
        $this->actingAs($user = factory(User::class)->create());

        $user->forceFill([
            'two_factor_secret'   => Str::random(40),
            'uses_two_factor_auth'=> true,
        ])->save();

        $this->assertNotEmpty($user->fresh()->two_factor_secret);
        $this->assertTrue((bool) $user->fresh()->uses_two_factor_auth);

        Livewire::test(DisableTwoFactorAuth::class)
            ->call('disableTwoFactorAuth')
            ->assertEmitted('refreshTwoFactorAuth');

        $this->assertEmpty($user->fresh()->two_factor_secret);
        $this->assertFalse((bool) $user->fresh()->uses_two_factor_auth);
    }
}
