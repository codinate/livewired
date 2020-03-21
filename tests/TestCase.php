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

namespace KodeKeep\Livewired\Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use KodeKeep\Addresses\Providers\AddressesServiceProvider;
use KodeKeep\Livewired\Providers\LivewiredServiceProvider;
use KodeKeep\NotificationMethods\Providers\NotificationMethodsServiceProvider;
use KodeKeep\Teams\Contracts\TeamInvitation;
use KodeKeep\Teams\Providers\TeamsServiceProvider;
use Laravel\Sanctum\SanctumServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Livewire\LivewireServiceProvider;
use Mpociot\VatCalculator\VatCalculatorServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use PragmaRX\Google2FALaravel\ServiceProvider as TwoFactorServiceProvider;
use Ramsey\Uuid\Uuid;
use Spatie\PersonalDataExport\PersonalDataExportServiceProvider;

abstract class TestCase extends Orchestra
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/database/factories');

        $this->loadLaravelMigrations(['--database' => 'testbench']);

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testbench');

        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);

        $app['config']->set('auth.providers.users.model', User::class);

        $app['config']->set('teams.models.team', Team::class);

        $app['config']->set('teams.models.user', User::class);

        $app['config']->set('personal-data-export.disk', 'local');

        $app['config']->set('notification-methods.channels', [
            'discord' => [
                'properties' => [
                    'discord_url' => ['nullable', 'url', 'required_if:channel,discord'],
                ],
            ],
            'mail' => [
                'properties' => [
                    'mail_address' => ['nullable', 'email', 'required_if:channel,mail'],
                ],
            ],
            'nexmo' => [
                'properties' => [
                    'nexmo_api_key'    => ['nullable', 'string', 'required_if:channel,nexmo'],
                    'nexmo_api_secret' => ['nullable', 'string', 'required_if:channel,nexmo'],
                    'nexmo_from'       => ['nullable', 'integer', 'required_if:channel,nexmo'],
                    'nexmo_to'         => ['nullable', 'integer', 'required_if:channel,nexmo'],
                ],
            ],
            'pushbullet' => [
                'properties' => [
                    'pushbullet_token' => ['nullable', 'string', 'required_if:channel,pushbullet'],
                ],
            ],
            'pushover' => [
                'properties' => [
                    'pushover_user'  => ['nullable', 'string', 'required_if:channel,pushover'],
                    'pushover_token' => ['nullable', 'string', 'required_if:channel,pushover'],
                ],
            ],
            'slack' => [
                'properties' => [
                    'slack_url' => ['nullable', 'url', 'required_if:channel,slack'],
                ],
            ],
            'webhook' => [
                'properties' => [
                    'webhook_url' => ['nullable', 'url', 'required_if:channel,webhook'],
                ],
            ],
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            AddressesServiceProvider::class,
            SanctumServiceProvider::class,
            LivewiredServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationMethodsServiceProvider::class,
            PersonalDataExportServiceProvider::class,
            TeamsServiceProvider::class,
            TwoFactorServiceProvider::class,
            VatCalculatorServiceProvider::class,
        ];
    }

    protected function user(): User
    {
        $user = new User();

        $user->forceFill([
            'name'     => $this->faker->name,
            'email'    => $this->faker->safeEmail,
            'password' => Hash::make('password'),
        ])->save();

        return $user;
    }

    protected function team(): Team
    {
        $user = $this->user();

        $team = Team::create([
            'owner_id' => $user->id,
            'name'     => $this->faker->name,
            'slug'     => $this->faker->slug,
        ]);

        $team->addMember($user, 'owner', []);

        return $team;
    }

    protected function createToken(User $user): PersonalAccessToken
    {
        $token = $user->createToken('dummy')->accessToken;

        $user->refresh();

        return $token;
    }

    protected function createInvitation(Team $team, User $user): TeamInvitation
    {
        return $team->invitations()->create([
            'id'           => Uuid::uuid4(),
            'user_id'      => $user->id,
            'role'         => 'member',
            'permissions'  => [],
            'email'        => $user->email,
            'accept_token' => Str::random(40),
            'reject_token' => Str::random(40),
        ]);
    }
}
