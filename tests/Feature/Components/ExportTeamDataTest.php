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

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use KodeKeep\Livewired\Components\ExportTeamData;
use KodeKeep\Livewired\Tests\TestCase;
use Livewire\Livewire;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;

class ExportTeamDataTest extends TestCase
{
    /** @test */
    public function it_can_export_the_profile_data()
    {
        Route::personalDataExports('personal-data-exports');

        Event::fake();

        $this->actingAs($this->team()->owner);

        Livewire::test(ExportTeamData::class)->call('exportTeamData');

        Event::assertDispatched(CreatePersonalDataExportJob::class);
    }
}
