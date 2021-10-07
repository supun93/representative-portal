<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingRepresentativeCustomizeFields extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["created_by", "updated_by", "deleted_by"];
    protected $table = 'marketing_representative_customize_fields';
    protected $primaryKey = 'representative_customize_field_id';

    /**
     * Get the user associated with the MarketingRepresentativeCustomizeFields
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function designationField()
    {
        return $this->hasOne(MarketingDesignationFields::class, 'designation_field_id', 'designation_field_id');
    }
    public function formTypeField()
    {
        return $this->hasOne(MarketingCustomizeFormTypeFields::class, 'type_field_id', 'type_field_id');
    }
    
}
