<?php

namespace App\Http\Controllers;

use App\Events\OrderShipped;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Log;

class IndexController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // 一元可买多少瓶可乐
    public $base_num = 1;

    // 多少个瓶盖可换一瓶可乐
    public $base_bottle_cap_num = 3;

    const TRUE = false;
    public function index()
    {


        var_dump(true === false);exit;
        $this->byCola();

        $class = TestController::class;
        $name = call_user_func([$class, 'getName']);
        echo "这里phpstorm修改的结果 blog2项目 ".$name;

    }

    public function byCola($money = 10)
    {
        $total_cola_num = 0;

        $cola_num = $money * $this->base_num;

        $total_cola_num += $cola_num;


        while ($cola_num) {
            $cola_num = $this->bottleCapToCola($cola_num);
            $total_cola_num += $cola_num;
        }

        echo $money . ' 元可以喝到 '. $total_cola_num . ' 瓶可乐';
        exit();
    }

    // 瓶盖换可乐
    public function bottleCapToCola($bottle_cap_num)
    {
        $cola_num = 0;
        if ($bottle_cap_num >= 0 && $this->base_bottle_cap_num) {
            $cola_num = intval($bottle_cap_num / $this->base_bottle_cap_num);
        }

        return $cola_num;
    }


    public function blogfun($params)
    {
        for ($i=0; $i<10; $i++) {
            echo $i;
        }
    }

    public function laravelFunction()
    {
        $res = $this->index();
        echo 222;

    }
}
