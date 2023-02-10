<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class TestController
{
    public static $status_type;

    public function __construct($status_type)
    {
        self::$status_type = $status_type;
    }

    public static function getName()
    {
        
        return self::$status_type;

    }

    public static function setName($status_type)
    {
        
        return self::$status_type = $status_type;

    }


}
