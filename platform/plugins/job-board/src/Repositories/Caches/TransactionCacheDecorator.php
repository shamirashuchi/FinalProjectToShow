<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\TransactionInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class TransactionCacheDecorator extends CacheAbstractDecorator implements TransactionInterface
{
}
