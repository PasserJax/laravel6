<?php

namespace App\Console\Commands\Elasticsearch;

use Illuminate\Console\Command;

class CreatezMapping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'es:create_mapping {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建Elasticsearch映射';

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

        $this->index = $this->argument('index');
        $params = $this->getParams();
        app('es')->indices()->putMapping($params);
        $this->info('已创建映射：'.$this->index);
    }

    public function getParams(){
        $params = [
            'index'=>$this->index,
            'type'=>'_doc',
            'custom'=>['include_type_name'=>true],
            'body'=>[
                '_doc'=>[
                    'properties'=>[

                    ]
                ]
            ]
        ];
        switch ($this->index){
            case 'orders_copy':
                $params['body']['_doc']['properties'] = [
                    'id'=>['type'=>'integer'],
                    'order_no'=>['type'=>'keyword'],
                    'order_amount'=>['type'=>'scaled_float','scaling_factor'=>100],
                    'order_status'=>['type'=>'byte'],
                    'created_at'=>['type'=>'keyword'],
                    'user_name'=>['type'=>'text',"analyzer"=>"ik_max_word", "search_analyzer"=>"ik_smart_synonym"],
                    'consignee'=>['type'=>'text',"analyzer"=>"ik_max_word", "search_analyzer"=>"ik_smart_synonym"],
                    'store_name'=>['type'=>'text',"analyzer"=>"ik_max_word", "search_analyzer"=>"ik_smart_synonym"],
                    'addresses'=>['type'=>'text',"analyzer"=>"ik_max_word", "search_analyzer"=>"ik_smart_synonym"],
                    'goods'=>[
                        'type'=>'nested',
                        'properties'=>[
                            'goods_name'=>['type'=>'text',"analyzer"=>"ik_max_word", "search_analyzer"=>"ik_smart_synonym",'copy_to'=>'goodsName'],
                            'goods_spec'=>['type'=>'text',"analyzer"=>"ik_max_word", "search_analyzer"=>"ik_smart_synonym",'copy_to'=>'goodsSpec'],
                            'goods_price'=>['type'=>'scaled_float','scaling_factor'=>100]
                        ]
                    ],
                    'properties'=>[
                        'type'=>'nested',
                        'properties'=>[
                            'name'=>['type'=>'keyword','copy_to'=>'properties_name'],
                            'value'=>['type'=>'keyword','copy_to'=>'properties_value'],
                            'search_value'=>['type'=>'keyword']
                        ]
                    ]
                ];
                break;
            case 'orders':
                $params['body']['_doc']['properties'] = [
                    'id'=>['type'=>'integer'],
                    'user_name'=>['type'=>'keyword'],
                    'age'=>['type'=>'byte'],
                    'created_at'=>['type'=>'date'],
                    'brief_introduction'=>['type'=>'text'],
                ];
                break;
        }
        return $params;
    }
}
