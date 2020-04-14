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

use KodeKeep\Livewired\Components\EnableTwoFactorAuth;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;
use PragmaRX\Google2FALaravel\Facade as Google2FA;

class EnableTwoFactorAuthTest extends TestCase
{
    /** @test */
    public function can_enable_two_factor_authentication()
    {
        $this->actingAs($user = $this->user());

        $this->assertEmpty($user->uses_two_factor_auth);
        $this->assertEmpty($user->two_factor_secret);
        $this->assertEmpty($user->two_factor_reset_code);

        Google2FA::shouldReceive('generateSecretKey')
            ->andReturn('secretKey');

        Google2FA::shouldReceive('getQRCodeInline')
            ->with('Laravel', $user->email, 'secretKey', 128)
            ->andReturn('qrCode');

        Google2FA::shouldReceive('verifyKey')
            ->with('secretKey', 123456)
            ->andReturn(true);

        Livewire::test(EnableTwoFactorAuth::class)
            ->set('otp', 123456)
            ->call('enableTwoFactorAuth')
            ->assertEmitted('refreshTwoFactorAuth');

        $user = $user->fresh();

        $this->assertTrue((bool) $user->uses_two_factor_auth);
        $this->assertNotEmpty($user->two_factor_secret);
        $this->assertNotEmpty($user->two_factor_reset_code);
    }
}
