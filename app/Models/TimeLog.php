<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    protected $fillable = ['user_id', 'project_id', 'date', 'hours_spent', 'task_description'];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
