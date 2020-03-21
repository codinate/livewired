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

use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Support\Str;
use KodeKeep\Addresses\Concerns\HasAddresses;
use KodeKeep\NotificationMethods\Concerns\HasNotificationMethods;
use KodeKeep\Teams\Concerns\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\PersonalDataExport\ExportsPersonalData;
use Spatie\PersonalDataExport\PersonalDataSelection;

class User extends BaseUser implements ExportsPersonalData
{
    use HasAddresses;
    use HasApiTokens;
    use HasNotificationMethods;
    use HasTeams;

    public function selectPersonalData(PersonalDataSelection $personalData): void
    {
        $personalData->add('user.json', ['name' => $this->name, 'email' => $this->email]);
    }

    public function personalDataExportName(): string
    {
        return 'personal-data-'.Str::slug($this->name).'.zip';
    }
}
