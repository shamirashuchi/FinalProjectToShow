<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\AccountInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class AccountCacheDecorator extends CacheAbstractDecorator implements AccountInterface
{
}
