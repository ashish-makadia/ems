<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table='work_log';
    protected $appends = [
        'work_log_edit_url'
    ];

    public function getWorkLogEditUrlAttribute()
    {
        return route('work_log.edit', ['work_log' => $this->attributes['id']]);
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }
}
