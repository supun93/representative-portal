<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingWorkPlaces extends Model
{
    use SoftDeletes;
  
    protected $fillable = ["created_by", "updated_by", "deleted_by"];
    protected $table = 'marketing_work_places';
    protected $primaryKey = 'work_place_id';
    
    protected $appends = ["id", "name"];

    

    public function getIdAttribute()
    {
        return $this->{$this->primaryKey};
    }

    public function getNameAttribute()
    {
        return $this->school_name;
    }
}
