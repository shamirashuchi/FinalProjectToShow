<?php

namespace Botble\JobBoard\Repositories\Caches;

use Botble\JobBoard\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\Support\Repositories\Caches\CacheAbstractDecorator;

class AccountActivityLogCacheDecorator extends CacheAbstractDecorator implements AccountActivityLogInterface
{
    public function getAllLogs(int $accountId, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
