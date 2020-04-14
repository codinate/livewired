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

use KodeKeep\Livewired\Components\UpdatePassword;
use KodeKeep\Livewired\Tests\TestCase;
use KodeKeep\ValidationRules\Rules\CurrentPassword;
use Livewire\Livewire;

class UpdatePasswordTest extends TestCase
{
    /** @test */
    public function can_update_the_password_if_the_current_password_is_valid()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdatePassword::class)
            ->set('current_password', 'password')
            ->set('password', 'new_password')
            ->set('password_confirmation', 'new_password')
            ->call('updatePassword')
            ->assertHasNoErrors();
    }

    /** @test */
    public function cant_update_the_password_if_the_current_password_is_invalid()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdatePassword::class)
            ->set('current_password', 'invalid-current-password')
            ->set('password', 'new_password')
            ->set('password_confirmation', 'new_password')
            ->call('updatePassword')
            ->assertHasErrors(['current_password' => strtolower(CurrentPassword::class)]);
    }

    /** @test */
    public function cant_update_the_password_if_the_new_password_confirmation_is_missing()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdatePassword::class)
            ->set('current_password', 'password')
            ->set('password', 'new_password')
            ->call('updatePassword')
            ->assertHasErrors(['password' => 'confirmed']);
    }

    /** @test */
    public function cant_update_the_password_if_the_new_password_confirmation_does_not_match()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdatePassword::class)
            ->set('current_password', 'password')
            ->set('password', 'new_password')
            ->set('password_confirmation', 'new_password_mismatch')
            ->call('updatePassword')
            ->assertHasErrors(['password' => 'confirmed']);
    }

    /** @test */
    public function cant_update_the_password_if_the_new_password_is_shorther_than_8_characters()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdatePassword::class)
            ->set('current_password', 'password')
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->call('updatePassword')
            ->assertHasErrors(['password' => 'min']);
    }
}
