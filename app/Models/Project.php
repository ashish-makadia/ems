<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
class Project extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = [
        'project_edit_url','project_show_url','team_members_name'
    ];

    public function getProjectEditUrlAttribute()
    {
        return route('project.edit', ['project' => $this->attributes['id']]);
    }
    public function getProjectShowUrlAttribute()
    {
        return route('project.show', ['project' => $this->attributes['id']]);
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
    public function task(){
        return $this->hasMany(Task::class, 'project_id', 'id');
    }
    public function projectattachment(){
        return $this->hasMany(ProjectAttachment::class, 'project_id', 'id');
    }
}
