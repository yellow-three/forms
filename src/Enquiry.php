<?php

namespace YellowThree\VoyagerForms;

use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    protected $fillable = [
        'form_id',
        'data',
        'mailto',
        'ip_address',
        'files_keys'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function setMailToAttribute($value)
    {
        $this->attributes['mailto'] = serialize($value);
    }

    public function getMailToAttribute($value)
    {
        return unserialize($value);
    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = serialize($value);
    }

    public function getDataAttribute($value)
    {
        return unserialize($value);
    }

    public function setFilesKeysAttribute($value)
    {
        $this->attributes['files_keys'] = serialize($value);
    }

    public function getFilesKeysAttribute($value)
    {
        return unserialize($value);
    }
}
