<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name','buildings','units','available_units','file', 'description', 'location','location_features','photos', 'viewed_number', 'active'];

    public function infos() {
        return $this->hasMany(ProjectInfos::class, 'project_id');
    }
}
