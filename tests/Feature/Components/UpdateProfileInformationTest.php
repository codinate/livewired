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

use KodeKeep\Livewired\Components\UpdateProfileInformation;
use KodeKeep\Livewired\Tests\TestCase;
use KodeKeep\Livewired\Tests\User;
use Livewire\Livewire;

class UpdateProfileInformationTest extends TestCase
{
    /** @test */
    public function can_update_the_name_and_email()
    {
        $this->actingAs($user = $this->user());

        Livewire::test(UpdateProfileInformation::class)
            ->set('name', $user->name)
            ->set('email', $user->email)
            ->call('updateProfileInformation')
            ->assertHasNoErrors(['name', 'email']);
    }

    /** @test */
    public function can_update_the_name()
    {
        $this->actingAs($user = $this->user());

        Livewire::test(UpdateProfileInformation::class)
            ->set('name', $user->name)
            ->call('updateProfileInformation')
            ->assertHasNoErrors(['name', 'email']);
    }

    /** @test */
    public function can_update_the_email()
    {
        $this->actingAs($user = $this->user());

        Livewire::test(UpdateProfileInformation::class)
            ->set('email', $user->email)
            ->call('updateProfileInformation')
            ->assertHasNoErrors(['name', 'email']);
    }

    /** @test */
    public function cant_update_the_name_if_it_is_empty()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdateProfileInformation::class)
            ->set('name', null)
            ->call('updateProfileInformation')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_update_the_name_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdateProfileInformation::class)
            ->set('name', str_repeat('x', 256))
            ->call('updateProfileInformation')
            ->assertHasNoErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_update_the_email_if_it_is_invalid()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdateProfileInformation::class)
            ->set('email', 'invalid-email')
            ->call('updateProfileInformation')
            ->assertHasNoErrors(['email' => 'required']);
    }

    /** @test */
    public function cant_update_the_email_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->user());

        Livewire::test(UpdateProfileInformation::class)
            ->set('email', 'hello@'.str_repeat('x', 256).'.de')
            ->call('updateProfileInformation')
            ->assertHasNoErrors(['email' => 'required']);
    }

    /** @test */
    public function cant_update_the_email_if_it_is_already_used_by_another_user()
    {
        $user  = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        $this->actingAs($user);

        Livewire::test(UpdateProfileInformation::class)
            ->set('email', $user2->email)
            ->call('updateProfileInformation')
            ->assertHasNoErrors(['email' => 'required']);
    }
}
