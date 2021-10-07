<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'set_districts';
    protected $with = [];
    

    public function provinces()
    {
        return $this->belongsTo(Provinces::class,'province_id','id');
    }
    
    public function similarDistricts()
    {
        return $this->hasMany(District::class, 'province_id', 'province_id');
    }
}
