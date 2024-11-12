<?php

namespace Botble\JobBoard\Repositories\Eloquent;

use Botble\JobBoard\Repositories\Interfaces\AccountActivityLogInterface;
use Botble\Support\Repositories\Eloquent\RepositoriesAbstract;

class AccountActivityLogRepository extends RepositoriesAbstract implements AccountActivityLogInterface
{
    public function getAllLogs(int $accountId, $paginate = 10)
    {
        return $this->model
            ->where('account_id', $accountId)
            ->latest('created_at')
            ->paginate($paginate);
    }
}
