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

use KodeKeep\Livewired\Components\UpdateNotificationMethod;
use KodeKeep\Livewired\Tests\TestCase;
use KodeKeep\NotificationMethods\Models\NotificationMethod;
use Livewire\Livewire;
use Livewire\Testing\TestableLivewire;

class UpdateNotificationMethodTest extends TestCase
{
    /** @test */
    public function cant_update_the_notification_method_if_the_name_is_empty()
    {
        $this
            ->createComponent('discord')
            ->set('name', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_name_it_is_longer_than_255_characters()
    {
        $this
            ->createComponent('discord')
            ->set('name', str_repeat('x', 256))
            ->assertSet('name', str_repeat('x', 256))
            ->call('updateNotificationMethod')
            ->assertHasErrors(['name' => 'max']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_channel_is_empty()
    {
        $this
            ->createComponent('discord')
            ->set('channel', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['channel' => 'required']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_channel_is_invalid()
    {
        $this
            ->createComponent('discord')
            ->set('channel', 'invalid')
            ->call('updateNotificationMethod')
            ->assertHasErrors(['channel' => 'in']);
    }

    /** @test */
    public function can_update_the_notification_method_if_the_channel_is_discord()
    {
        $this
            ->createComponent('discord')
            ->set('name', '...')
            ->set('channel', 'discord')
            ->set('discord_url', $this->faker->url)
            ->call('updateNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_discord_url_is_empty()
    {
        $this
            ->createComponent('discord')
            ->set('name', '...')
            ->set('channel', 'discord')
            ->set('discord_url', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['discord_url' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_discord_url_is_invalid()
    {
        $this
            ->createComponent('discord')
            ->set('name', '...')
            ->set('channel', 'discord')
            ->set('discord_url', 'invalid')
            ->call('updateNotificationMethod')
            ->assertHasErrors(['discord_url' => 'url']);
    }

    /** @test */
    public function can_update_the_notification_method_if_the_channel_is_mail()
    {
        $this
            ->createComponent('mail')
            ->set('name', '...')
            ->set('channel', 'mail')
            ->set('mail_address', $this->faker->safeEmail)
            ->call('updateNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_mail_address_is_empty()
    {
        $this
            ->createComponent('mail')
            ->set('name', '...')
            ->set('channel', 'mail')
            ->set('mail_address', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['mail_address' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_mail_address_is_invalid()
    {
        $this
            ->createComponent('mail')
            ->set('name', '...')
            ->set('channel', 'mail')
            ->set('mail_address', 'invalid')
            ->call('updateNotificationMethod')
            ->assertHasErrors(['mail_address' => 'email']);
    }

    /** @test */
    public function can_update_the_notification_method_if_the_channel_is_nexmo()
    {
        $this
            ->createComponent('nexmo')
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_api_key', $this->faker->url)
            ->set('nexmo_api_secret', $this->faker->url)
            ->set('nexmo_from', $this->faker->numberBetween(1, 100))
            ->set('nexmo_to', $this->faker->numberBetween(1, 100))
            ->call('updateNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_nexmo_api_key_is_empty()
    {
        $this
            ->createComponent('nexmo')
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_api_key', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['nexmo_api_key' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_nexmo_api_secret_is_empty()
    {
        $this
            ->createComponent('nexmo')
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_api_secret', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['nexmo_api_secret' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_nexmo_from_is_empty()
    {
        $this
            ->createComponent('nexmo')
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_from', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['nexmo_from' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_nexmo_from_is_invalid()
    {
        $this
            ->createComponent('nexmo')
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_from', 'invalid')
            ->call('updateNotificationMethod')
            ->assertHasErrors(['nexmo_from' => 'integer']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_nexmo_to_is_empty()
    {
        $this
            ->createComponent('nexmo')
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_to', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['nexmo_to' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_nexmo_to_is_invalid()
    {
        $this
            ->createComponent('nexmo')
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_to', 'invalid')
            ->call('updateNotificationMethod')
            ->assertHasErrors(['nexmo_to' => 'integer']);
    }

    /** @test */
    public function can_update_the_notification_method_if_the_channel_is_pushbullet()
    {
        $this
            ->createComponent('pushbullet')
            ->set('name', '...')
            ->set('channel', 'pushbullet')
            ->set('pushbullet_token', $this->faker->url)
            ->call('updateNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function can_update_the_notification_method_if_the_channel_is_pushover()
    {
        $this
            ->createComponent('pushover')
            ->set('name', '...')
            ->set('channel', 'pushover')
            ->set('pushover_user', 'invalid')
            ->set('pushover_token', 'invalid')
            ->call('updateNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_pushover_user_is_empty()
    {
        $this
            ->createComponent('pushover')
            ->set('name', '...')
            ->set('channel', 'pushover')
            ->set('pushover_user', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['pushover_user' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_pushover_token_is_empty()
    {
        $this
            ->createComponent('pushover')
            ->set('name', '...')
            ->set('channel', 'pushover')
            ->set('pushover_token', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['pushover_token' => 'requiredif']);
    }

    /** @test */
    public function can_update_the_notification_method_if_the_channel_is_slack()
    {
        $this
            ->createComponent('slack')
            ->set('name', '...')
            ->set('channel', 'slack')
            ->set('slack_url', $this->faker->url)
            ->call('updateNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_slack_url_is_empty()
    {
        $this
            ->createComponent('slack')
            ->set('name', '...')
            ->set('channel', 'slack')
            ->set('slack_url', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['slack_url' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_slack_url_is_invalid()
    {
        $this
            ->createComponent('slack')
            ->set('name', '...')
            ->set('channel', 'slack')
            ->set('slack_url', 'invalid')
            ->call('updateNotificationMethod')
            ->assertHasErrors(['slack_url' => 'url']);
    }

    /** @test */
    public function can_update_the_notification_method_if_the_channel_is_webhook()
    {
        $this
            ->createComponent('webhook')
            ->set('name', '...')
            ->set('channel', 'webhook')
            ->set('webhook_url', $this->faker->url)
            ->call('updateNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_webhook_url_is_empty()
    {
        $this
            ->createComponent('webhook')
            ->set('name', '...')
            ->set('channel', 'webhook')
            ->set('webhook_url', null)
            ->call('updateNotificationMethod')
            ->assertHasErrors(['webhook_url' => 'requiredif']);
    }

    /** @test */
    public function cant_update_the_notification_method_if_the_webhook_url_is_invalid()
    {
        $this
            ->createComponent('webhook')
            ->set('name', '...')
            ->set('channel', 'webhook')
            ->set('webhook_url', 'invalid')
            ->call('updateNotificationMethod')
            ->assertHasErrors(['webhook_url' => 'url']);
    }

    private function createComponent(string $state): TestableLivewire
    {
        $team = $this->team();

        $this->actingAs($team->owner);

        $notificationMethod = factory(NotificationMethod::class)
            ->states($state)
            ->create(['notifiable_id' => $team->id]);

        return Livewire::test(UpdateNotificationMethod::class)->call('editNotificationMethod', $notificationMethod->id);
    }
}
