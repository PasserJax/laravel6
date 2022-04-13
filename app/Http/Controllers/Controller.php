<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function test1()
    {
        echo "这里phpstorm修改的结果 blog2项目";

    }

    public function blogfun($params)
    {
        $map = [
            'aaa' => 'nnn',
            'vvvv' => '23852975628',
            'yfyfy' => '22',
        ];

        for ($i=0; $i<10; $i++) {
            echo $i;
        }
        var_dump($map);
    }
}
