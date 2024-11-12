<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\JobShiftInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class JobShiftCacheDecorator extends CacheAbstractDecorator implements JobShiftInterface
{
}
