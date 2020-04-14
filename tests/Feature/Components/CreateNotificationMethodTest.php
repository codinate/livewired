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

use KodeKeep\Livewired\Components\CreateNotificationMethod;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class CreateNotificationMethodTest extends TestCase
{
    /** @test */
    public function cant_create_the_notification_method_if_the_name_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_name_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', str_repeat('x', 256))
            ->call('createNotificationMethod')
            ->assertHasErrors(['name' => 'max']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_channel_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('channel', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['channel' => 'required']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_channel_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('channel', 'invalid')
            ->call('createNotificationMethod')
            ->assertHasErrors(['channel' => 'in']);
    }

    /** @test */
    public function can_create_the_notification_method_if_the_channel_is_discord()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'discord')
            ->set('discord_url', $this->faker->url)
            ->call('createNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_discord_url_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'discord')
            ->set('discord_url', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['discord_url' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_discord_url_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'discord')
            ->set('discord_url', 'invalid')
            ->call('createNotificationMethod')
            ->assertHasErrors(['discord_url' => 'url']);
    }

    /** @test */
    public function can_create_the_notification_method_if_the_channel_is_mail()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'mail')
            ->set('mail_address', $this->faker->safeEmail)
            ->call('createNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_mail_address_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'mail')
            ->set('mail_address', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['mail_address' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_mail_address_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'mail')
            ->set('mail_address', 'invalid')
            ->call('createNotificationMethod')
            ->assertHasErrors(['mail_address' => 'email']);
    }

    /** @test */
    public function can_create_the_notification_method_if_the_channel_is_nexmo()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_api_key', $this->faker->url)
            ->set('nexmo_api_secret', $this->faker->url)
            ->set('nexmo_from', $this->faker->numberBetween(1, 100))
            ->set('nexmo_to', $this->faker->numberBetween(1, 100))
            ->call('createNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_nexmo_api_key_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_api_key', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['nexmo_api_key' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_nexmo_api_secret_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_api_secret', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['nexmo_api_secret' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_nexmo_from_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_from', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['nexmo_from' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_nexmo_from_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_from', 'invalid')
            ->call('createNotificationMethod')
            ->assertHasErrors(['nexmo_from' => 'integer']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_nexmo_to_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_to', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['nexmo_to' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_nexmo_to_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'nexmo')
            ->set('nexmo_to', 'invalid')
            ->call('createNotificationMethod')
            ->assertHasErrors(['nexmo_to' => 'integer']);
    }

    /** @test */
    public function can_create_the_notification_method_if_the_channel_is_pushbullet()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'pushbullet')
            ->set('pushbullet_token', $this->faker->url)
            ->call('createNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function can_create_the_notification_method_if_the_channel_is_pushover()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'pushover')
            ->set('pushover_user', 'invalid')
            ->set('pushover_token', 'invalid')
            ->call('createNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_pushover_user_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'pushover')
            ->set('pushover_user', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['pushover_user' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_pushover_token_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'pushover')
            ->set('pushover_token', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['pushover_token' => 'requiredif']);
    }

    /** @test */
    public function can_create_the_notification_method_if_the_channel_is_slack()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'slack')
            ->set('slack_url', $this->faker->url)
            ->call('createNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_slack_url_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'slack')
            ->set('slack_url', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['slack_url' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_slack_url_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'slack')
            ->set('slack_url', 'invalid')
            ->call('createNotificationMethod')
            ->assertHasErrors(['slack_url' => 'url']);
    }

    /** @test */
    public function can_create_the_notification_method_if_the_channel_is_webhook()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'webhook')
            ->set('webhook_url', $this->faker->url)
            ->call('createNotificationMethod')
            ->assertEmitted('refreshNotificationMethods');
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_webhook_url_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'webhook')
            ->set('webhook_url', null)
            ->call('createNotificationMethod')
            ->assertHasErrors(['webhook_url' => 'requiredif']);
    }

    /** @test */
    public function cant_create_the_notification_method_if_the_webhook_url_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(CreateNotificationMethod::class)
            ->set('name', '...')
            ->set('channel', 'webhook')
            ->set('webhook_url', 'invalid')
            ->call('createNotificationMethod')
            ->assertHasErrors(['webhook_url' => 'url']);
    }
}
