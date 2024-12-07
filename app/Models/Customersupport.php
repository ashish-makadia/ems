<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
class Customersupport extends Model
{
    use HasFactory;
    protected $table='customersupports';
   	protected $guarded=['id'];
   	 protected $appends = [
       'team_members_name','status_name'
    ];
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
    public function user()
    {
        return $this->belongsTo(User::class, 'assined_by', 'id');
    }

    public function getStatusNameAttribute(){
        $status = $this->attributes['status'];
        $customerstatus = config("projectstatus.customerstatus");
        return $customerstatus[$status]??"";
    }
}
