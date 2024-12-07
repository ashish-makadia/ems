<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project;
class Task extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table='tasks';
    protected $appends = [
        'task_edit_url','team_members_name'
    ];


    public function getTaskEditUrlAttribute()
    {
        return route('task.edit', ['task' => $this->attributes['id']]);
    }
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function getTeamMembersNameAttribute()
    {
        $team_members = $this->attributes['team_members'];
        $member = [];
        $mm = "";
        if(!empty($team_members)){
            $teams = json_decode($team_members);
            foreach($teams as $tm){
                $emplloyee = Employee::find($tm);
                $member[] = $emplloyee?$emplloyee->name:'';
            }
           $mm =  implode(", ",$member);
        }
        return $mm;
    }

}
