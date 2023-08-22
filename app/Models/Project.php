<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'deadline', 'user_id', 'completed'];

    // Relationship To Project Manager
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    //One Project has many tasks
    public function tasks() {
        return $this->hasMany(Task::class, 'project_id');
    }

    //One Project has many resources
    public function resources() {
        return $this->hasMany(Resources::class, 'project_id');
    }

}
