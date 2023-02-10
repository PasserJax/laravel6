<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Class User
 * @package App\Model
 */
class User extends Model
{
    protected $table = 'user';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'brief_introduction', 'age','created_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
//        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function toESArray(): array
    {
        // 只取出需要的字段
        $arr = Arr::only($this->toArray(), [
            'id',
            'user_name',
            'age',
            'created_at',
            'brief_introduction',
        ]);

        return $arr;
    }
}
