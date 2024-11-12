<?php

namespace Botble\JobBoard\Facades;

use Botble\JobBoard\Supports\JobBoardHelper;
use Illuminate\Support\Facades\Facade;

class JobBoardHelperFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return JobBoardHelper::class;
    }
}
