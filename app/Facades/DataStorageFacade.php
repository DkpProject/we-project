<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Helpers\DataProvider;

class DataStorageFacade extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor() { return DataProvider::class; }
}