<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\Support\Repositories\Caches\CacheAbstractDecorator;
use Botble\JobBoard\Repositories\Interfaces\InvoiceInterface;

class InvoiceCacheDecorator extends CacheAbstractDecorator implements InvoiceInterface
{
}
