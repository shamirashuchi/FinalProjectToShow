<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\JobApplicationInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class JobApplicationCacheDecorator extends CacheAbstractDecorator implements JobApplicationInterface
{
}
