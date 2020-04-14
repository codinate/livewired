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

use KodeKeep\Livewired\Components\CreateTeam;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class CreateTeamTest extends TestCase
{
    /** @test */
    public function can_create_the_team()
    {
        $this->actingAs($this->user());

        Livewire::test(CreateTeam::class)
            ->set('name', '...')
            ->call('createTeam')
            ->assertHasNoErrors();
    }

    /** @test */
    public function cant_create_the_team_if_the_name_is_empty()
    {
        $this->actingAs($this->user());

        Livewire::test(CreateTeam::class)
            ->call('createTeam')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_create_the_team_if_the_name_is_longer_than_255_characters()
    {
        $this->actingAs($this->user());

        Livewire::test(CreateTeam::class)
            ->set('name', str_repeat('x', 256))
            ->call('createTeam')
            ->assertHasErrors(['name' => 'max']);
    }
}
