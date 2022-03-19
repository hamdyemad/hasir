<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['status_id','project_id', 'name', 'email', 'type', 'phone', 'notes','viewed'];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
