<?php

namespace App\Console\Commands\Elasticsearch;

use App\Model\User;
use Illuminate\Console\Command;

class SyncOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:sync-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 获取 Elasticsearch 对象
        $es = app('es');

            // 使用 chunkById 避免一次性加载过多数据
       User::chunkById(100, function ($users) use ($es) {
                $this->info(sprintf('正在同步 ID 范围为 %s 至 %s 的数据', $users->first()->id, $users->last()->id));
                // 初始化请求体
                $req = ['body' => []];
                // 遍历订单
                foreach ($users as $user) {
                    // 将订单模型转为 Elasticsearch 所用的数组
                    $data = $user->toESArray();

                    $req['body'][] = [
                        'index' => [
                            '_index' => 'yonghu',
                            '_id'    => $data['id'],
                            '_type' => '_doc',
                        ],
                    ];
                    $req['body'][] = $data;
                }
                try {

                    // 使用 bulk 方法批量创建
                    $res = $es->bulk($req);
                    var_dump($res);exit;
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }
            });
        $this->info('同步完成');
    }
}
