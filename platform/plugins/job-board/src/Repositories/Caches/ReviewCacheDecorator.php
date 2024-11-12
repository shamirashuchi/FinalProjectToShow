<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\ReviewInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class ReviewCacheDecorator extends CacheAbstractDecorator implements ReviewInterface
{
}
