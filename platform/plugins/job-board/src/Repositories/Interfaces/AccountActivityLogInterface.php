<?php

namespace Botble\JobBoard\Repositories\Interfaces;

use Botble\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface AccountActivityLogInterface extends RepositoryInterface
{
    /**
     * @param int $accountId
     * @param int $paginate
     * @return Collection
     */
    public function getAllLogs(int $accountId, $paginate = 10);
}
