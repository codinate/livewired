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

use KodeKeep\Livewired\Components\UpdateVatId;
use KodeKeep\Livewired\Tests\TestCase;
use KodeKeep\ValidationRules\Rules\VatId;
use Livewire\Livewire;

class UpdateVatIdTest extends TestCase
{
    /** @test */
    public function can_update_the_vat_id()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateVatId::class)
            ->set('vat_id', 'DE315110518')
            ->call('updateVatId')
            ->assertHasNoErrors('vat_id');
    }

    /** @test */
    public function can_update_the_vat_id_if_it_is_empty()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateVatId::class)
            ->assertSet('vat_id', null)
            ->call('updateVatId')
            ->assertHasNoErrors('vat_id');
    }

    /** @test */
    public function cant_update_the_vat_id_if_it_is_longer_than_50_characters()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateVatId::class)
            ->set('vat_id', str_repeat('x', 64))
            ->call('updateVatId')
            ->assertHasErrors(['vat_id' => 'max']);
    }

    /** @test */
    public function cant_update_the_vat_id_if_it_is_invalid()
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(UpdateVatId::class)
            ->set('vat_id', 'invalid-vat-id')
            ->call('updateVatId')
            ->assertHasErrors(['vat_id' => \strtolower(VatId::class)]);
    }
}
