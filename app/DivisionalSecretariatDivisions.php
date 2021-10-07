<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class DivisionalSecretariatDivisions extends Model
{
    protected $fillable = [];
    protected $table = 'set_divisional_secretariat_divisions';
    protected $primaryKey = 'id';

    
    public function provinces()
    {
        return $this->belongsTo(Provinces::class,'province_id','id');
    }
    public function district()
    {
        return $this->belongsTo(District::class,'district_id','id');
    }
    /**
     * Get all of the comments for the DivisionalSecretariatDivisions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function similarDivisionsbyDistrict()
    {
        return $this->hasMany(DivisionalSecretariatDivisions::class, 'district_id', 'district_id');
    }


}
