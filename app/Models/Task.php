<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'deadline', 'user_id', 'assigned_by_id', 'project_id', 'completed'];

    // Relationship To User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship To Owner
    public function assignedBy() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship To Project
    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }
}

