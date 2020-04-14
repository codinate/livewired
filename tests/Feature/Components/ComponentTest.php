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

use Illuminate\View\View;
use KodeKeep\Livewired\Components\Component;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;

class ComponentTest extends TestCase
{
    /** @test */
    public function can_call_before_and_after_hooks_through_extension(): void
    {
        $this->actingAs($this->team()->owner);

        Livewire::test(ComponentThatExtends::class)
            ->assertSet('calls', 0)
            ->call('doSomething')
            ->assertSet('calls', 3);
    }

    /** @test */
    public function can_call_before_and_after_hooks_through_macros(): void
    {
        $this->actingAs($this->team()->owner);

        ComponentThatMacros::macro('beforeDoSomething', fn () => $this->calls++);
        ComponentThatMacros::macro('afterDoSomething', fn () => $this->calls++);

        Livewire::test(ComponentThatExtends::class)
            ->assertSet('calls', 0)
            ->call('doSomething')
            ->assertSet('calls', 3);
    }
}

class ComponentThatExtends extends Component
{
    public int $calls = 0;

    public function doSomething()
    {
        $this->calls++;
    }

    public function beforeDoSomething()
    {
        $this->calls++;
    }

    public function afterDoSomething()
    {
        $this->calls++;
    }

    public function render(): View
    {
        return view('livewired::create-notification-method');
    }
}

class ComponentThatMacros extends Component
{
    public int $calls = 0;

    public function doSomething()
    {
        $this->calls++;
    }

    public function render(): View
    {
        return view('livewired::create-notification-method');
    }
}
