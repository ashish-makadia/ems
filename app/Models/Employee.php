<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = [
        'employee_edit_url','employee_show_url','designation','team_lead_edit_url'
    ];
    public static $uploadFolderName = 'employee';
    public function getEmployeeEditUrlAttribute()
    {
        return route('employee.edit', ['employee' => $this->attributes['id']]);
    }
    public function getTeamLeadEditUrlAttribute()
    {
        return route('team-lead.edit', ['team_lead' => $this->attributes['id']]);
    }
    public function getEmployeeShowUrlAttribute()
    {
        return route('employee.show', ['employee' => $this->attributes['id']]);
    }
    public function getDesignationAttribute()
    {
    //     $desigArr = $this->attributes['designation_id'];
    //     $designation = [];
    //     $desgName = "";
    //     if(!empty($desigArr)){
    //         $empDesign = json_decode($desigArr);
    //         foreach($empDesign as $desg){
    //             if($desg == 7 || $desg == 8 || $desg == 9){
    //                 $desig = config('projectstatus.designation');
    //                 $designation[] = $desig?$desig[$desg]:'';
    //             }
    //         }
    //        $desgName =  implode(", ",$designation);
    //     }
    //     return $desgName;
    }
    public function designation(){
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
}
