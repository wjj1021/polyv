<?php

namespace Wjj1021\Polyv\Facades;

use Illuminate\Support\Facades\Facade;

class Polyv extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'polyv';
    }
}
