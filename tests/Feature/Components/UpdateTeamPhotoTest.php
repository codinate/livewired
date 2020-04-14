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

use KodeKeep\Livewired\Components\UpdateTeamPhoto;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class UpdateTeamPhotoTest extends TestCase
{
    public function can_update_the_profile_photo()
    {
        $team = $this->team();

        $this->actingAs($team->owner);

        $component = Livewire::test(UpdateTeamPhoto::class);
        $component->assertSee('www.gravatar.com');

        $team->addMediaFromUrl('https://avatars.io/static/default_128.jpg')->toMediaCollection('photo');

        $team->owner->refresh();
        $team->refresh();

        $component->call('$refresh');
        $component->assertDontSee('www.gravatar.com');
    }
}
