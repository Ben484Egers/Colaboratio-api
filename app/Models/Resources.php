<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['url', 'project_id'];

    // Relationship To Project
    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
