<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name'];


    public function permessions() {
        return $this->belongsToMany(Permession::class, 'roles_permessions', 'role_id')->withTimestamps();
    }
}
