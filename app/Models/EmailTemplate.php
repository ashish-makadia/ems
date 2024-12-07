<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TemplateType;


class EmailTemplate extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $appends = [
        'email_template_edit_url','email_template_type'
    ];

    public function getEmailTemplateEditUrlAttribute()
    {
        return route('email-template.edit', ['email_template' => $this->attributes['id']]);
    }

    // public function templatetype()
    // {
    //     return $this->belongsTo(TemplateType::class, 'template_type_id', 'id');
    // }
    public function getEmailTemplateTypeAttribute(){
        return config('projectstatus.template_type')[$this->attributes['template_type_id']]??'';
    }
}

