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

use KodeKeep\Livewired\Components\UpdateBillingAddress;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class UpdateBillingAddressTest extends TestCase
{
    /** @test */
    public function can_create_a_billing_address()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('name', $this->faker->name)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasNoErrors();
    }

    /** @test */
    public function can_update_a_billing_address()
    {
        $team  = $this->team();

        $this->actingAs($team->owner);

        $team->addresses()->create([
            'type'           => 'billing',
            'name'           => $this->faker->name,
            'address_line_1' => $this->faker->address,
            'address_line_2' => $this->faker->address,
            'city'           => $this->faker->city,
            'state'          => $this->faker->stateAbbr,
            'zip'            => $this->faker->postcode,
            'country'        => $this->faker->countryCode,
        ]);

        Livewire::test(UpdateBillingAddress::class)
            ->set('name', $this->faker->name)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasNoErrors();
    }

    /** @test */
    public function cant_update_the_name_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('name', str_repeat('x', 256))
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['name' => 'max']);
    }

    /** @test */
    public function cant_update_the_name_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('name', null)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['name' => 'required']);
    }

    /** @test */
    public function cant_update_the_address_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', str_repeat('x', 256))
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['address_line_1' => 'max']);
    }

    /** @test */
    public function cant_update_the_address_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', null)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['address_line_1' => 'required']);
    }

    /** @test */
    public function cant_update_the_address_line_2_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', str_repeat('x', 256))
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['address_line_2' => 'max']);
    }

    /** @test */
    public function cant_update_the_city_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', str_repeat('x', 256))
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['city' => 'max']);
    }

    /** @test */
    public function cant_update_the_city_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', null)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['city' => 'required']);
    }

    /** @test */
    public function cant_update_the_state_if_it_is_longer_than_255_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', str_repeat('x', 256))
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['state' => 'max']);
    }

    /** @test */
    public function cant_update_the_state_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', null)
            ->set('zip', $this->faker->postcode)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['state' => 'required']);
    }

    /** @test */
    public function cant_update_the_zip_if_it_is_longer_than_25_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', str_repeat('x', 26))
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['zip' => 'max']);
    }

    /** @test */
    public function cant_update_the_zip_if_it_isempty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', null)
            ->set('country', $this->faker->countryCode)
            ->call('updateBillingAddress')
            ->assertHasErrors(['zip' => 'required']);
    }

    /** @test */
    public function cant_update_the_country_if_it_is_longer_than_2_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', str_repeat('x', 3))
            ->call('updateBillingAddress')
            ->assertHasErrors(['country' => 'max']);
    }

    /** @test */
    public function cant_update_the_country_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateBillingAddress::class)
            ->set('address_line_1', $this->faker->address)
            ->set('address_line_2', $this->faker->address)
            ->set('city', $this->faker->city)
            ->set('state', $this->faker->stateAbbr)
            ->set('zip', $this->faker->postcode)
            ->set('country', null)
            ->call('updateBillingAddress')
            ->assertHasErrors(['country' => 'required']);
    }
}
