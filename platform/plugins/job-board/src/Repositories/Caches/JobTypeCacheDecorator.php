<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\JobTypeInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class JobTypeCacheDecorator extends CacheAbstractDecorator implements JobTypeInterface
{
}
