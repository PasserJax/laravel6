<?php

namespace App\Console\Commands\Elasticsearch;

use Illuminate\Console\Command;

class CreateUserIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:create-index {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建 Elasticsearch 索引';
    protected $index;

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
        //删除之前创建的索引
        $this->index = $this->argument('index');
        if ($this->existIndex()) {
            $this->deleteIndex();
            $this->info('已删除索引：'.$this->index);
        }
        //创建索引
        app('es')->indices()->create([
            'index' => $this->index,
            'body' => [
                'settings' =>[
                    //分区数
                    'number_of_shards' => 5,
                    //副文本
                    'number_of_replicas' =>1
                ]
            ]
        ]);
        $this->info('已创建索引：'.$this->index);
    }

    /**
     * @desc 检测索引
     * @method existIndex
     * @return bool
     * @time 2020/8/7 17:05
     */
    public function existIndex(){
        return app('es')->indices()->exists(['index' => $this->index]);
    }

    /**
     * @desc 删除索引
     * @method deleteIndex
     * @return array
     * @time 2020/8/7 17:05
     */
    public function deleteIndex(){
        return app('es')->indices()->delete(['index' => $this->index]);
    }
}
