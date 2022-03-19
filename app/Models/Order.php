<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['project_id','status_id', 'info_id', 'info_status','client_name', 'client_phone', 'client_email', 'viewed'];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }
    public function info() {
        return $this->belongsTo(ProjectInfos::class, 'info_id');
    }
}
