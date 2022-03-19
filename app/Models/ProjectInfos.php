<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectInfos extends Model
{
    protected $table = 'project_infos';
    protected $fillable = ['project_id', 'round', 'space', 'rooms', 'photos','price', 'description','features', 'status'];

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
