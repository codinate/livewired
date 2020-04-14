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

namespace KodeKeep\Livewired\Tests\Feature\Components\Passport;

use Illuminate\Foundation\Auth\User as BaseUser;
use Laravel\Passport\HasApiTokens;

class UserWithPassport extends BaseUser
{
    use HasApiTokens;

    protected $table = 'users';
}
