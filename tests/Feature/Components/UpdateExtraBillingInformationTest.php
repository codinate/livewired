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

use KodeKeep\Livewired\Components\UpdateExtraBillingInformation;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class UpdateExtraBillingInformationTest extends TestCase
{
    /** @test */
    public function can_update_the_extra_billing_information()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateExtraBillingInformation::class)
            ->set('extra_billing_information', '...')
            ->call('updateExtraBillingInformation')
            ->assertHasNoErrors('extra_billing_information');
    }

    /** @test */
    public function can_update_the_extra_billing_information_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateExtraBillingInformation::class)
            ->call('updateExtraBillingInformation')
            ->assertHasNoErrors('extra_billing_information');
    }

    /** @test */
    public function cant_update_the_extra_billing_information_if_it_is_longer_than_2048_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateExtraBillingInformation::class)
            ->set('extra_billing_information', str_repeat('x', 2049))
            ->call('updateExtraBillingInformation')
            ->assertHasErrors(['extra_billing_information' => 'max']);
    }
}
