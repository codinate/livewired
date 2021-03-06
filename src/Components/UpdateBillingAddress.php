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

namespace KodeKeep\Livewired\Components;

class UpdateBillingAddress extends Component
{
    use Concerns\InteractsWithTeam;
    use Concerns\InteractsWithUser;

    public ?string $name = null;

    public ?string $address_line_1 = null;

    public ?string $address_line_2 = null;

    public ?string $city = null;

    public ?string $state = null;

    public ?string $zip = null;

    public ?string $country = null;

    public function mount(): void
    {
        $this->setBillingAddress();
    }

    public function updateBillingAddress(): void
    {
        abort_unless($this->user->ownsTeam($this->team), 403);

        $validated = $this->validate([
            'name'           => ['required', 'string', 'max:255'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:255'],
            'state'          => ['required', 'string', 'max:255'],
            'zip'            => ['required', 'string', 'max:25'],
            'country'        => ['required', 'string', 'max:2'],
        ]);

        $this->team->addresses()->updateOrCreate(
            ['type' => 'billing'],
            array_merge($validated, ['type' => 'billing'])
        );

        $this->setBillingAddress();
    }

    public function setBillingAddress(): void
    {
        $addresses = $this->team->addresses()->whereType('billing');

        if ($addresses->count()) {
            $this->fill($addresses->firstOrFail());
        }
    }
}
