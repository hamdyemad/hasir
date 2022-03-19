<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    protected $table = 'statuses_history';
    protected $fillable = ['user_id', 'order_id','status_id'];
}
