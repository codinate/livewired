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

use KodeKeep\Livewired\Components\UpdateTeamName;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class UpdateTeamNameTest extends TestCase
{
    /** @test */
    public function can_update_the_team_name()
    {
        $team = $this->team();

        $this->actingAs($team->owner);

        $this->assertDatabaseHas('teams', [
            'id'   => $team->id,
            'name' => $team->name,
            'slug' => $team->slug,
        ]);

        Livewire::test(UpdateTeamName::class)
            ->set('name', 'new name')
            ->set('slug', 'new slug')
            ->call('updateTeamName')
            ->assertHasNoErrors('name');

        $this->assertDatabaseHas('teams', [
            'id'   => $team->id,
            'name' => 'new name',
            'slug' => 'new slug',
        ]);
    }

    /** @test */
    public function cant_update_the_name_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateTeamName::class)
            ->set('name', null)
            ->call('updateTeamName')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_update_the_name_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateTeamName::class)
            ->set('name', str_repeat('x', 512))
            ->call('updateTeamName')
            ->assertHasErrors(['name' => 'max']);
    }

    /** @test */
    public function cant_update_the_slug_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateTeamName::class)
            ->set('slug', null)
            ->call('updateTeamName')
            ->assertHasErrors(['slug' => 'required']);
    }

    /** @test */
    public function cant_update_the_slug_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateTeamName::class)
            ->set('slug', str_repeat('x', 512))
            ->call('updateTeamName')
            ->assertHasErrors(['slug' => 'max']);
    }
}
