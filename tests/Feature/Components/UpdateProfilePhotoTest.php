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

use KodeKeep\Livewired\Components\UpdateProfilePhoto;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class UpdateProfilePhotoTest extends TestCase
{
    public function can_update_the_profile_photo()
    {
        $this->actingAs($user = $this->user());

        $component = Livewire::test(UpdateProfilePhoto::class);
        $component->assertSee('www.gravatar.com');

        $user->addMediaFromUrl('https://avatars.io/static/default_128.jpg')->toMediaCollection('photo');

        $user->refresh();

        $component->call('$refresh');
        $component->assertDontSee('www.gravatar.com');
    }
}
