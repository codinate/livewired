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

use KodeKeep\Livewired\Components\ManageNotificationMethods;
use KodeKeep\Livewired\Tests\TestCase;
use KodeKeep\NotificationMethods\Models\NotificationMethod;
use Livewire\Livewire;

class ManageNotificationMethodsTest extends TestCase
{
    /** @test */
    public function can_list_the_recent_notifications()
    {
        $team = $this->team();

        $this->actingAs($team->owner);

        factory(NotificationMethod::class, 10)->states('discord')->create(['notifiable_id' => $team->id]);

        $component = Livewire::test(ManageNotificationMethods::class);

        $team->notificationMethods->each(fn ($method) => $component->assertSee($method->name));
    }

    /** @test */
    public function can_destroy_the_notification_method_if_it_is_the_owner()
    {
        $team = $this->team();

        $this->actingAs($team->owner);

        $notificationMethod = $team->notificationMethods()->create([
            'team_id'             => 1,
            'name'                => $this->faker->name,
            'channel'             => 'discord',
            'discord_url'         => $this->faker->url,
        ]);

        $this->assertDatabaseHas('notification_methods', ['id' => $notificationMethod->id]);

        Livewire::test(ManageNotificationMethods::class)
            ->call('deleteNotificationMethod', $notificationMethod->id);

        $this->assertDatabaseMissing('notification_methods', ['id' => $notificationMethod->id]);
    }
}
