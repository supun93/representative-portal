<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingDesignationFields extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["created_by", "updated_by", "deleted_by"];
    protected $table = 'marketing_designation_fields';
    protected $primaryKey = 'designation_field_id';

    protected $appends = ['input'];
    /**
     * Get the user associated with the MarketingCustomizeFormTypeFields
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

    public function getInputAttribute()
    {
        if($this->input_type == 1){
            return "Text Field";
        }else if($this->input_type == 2){
            return "Textarea Field";
        }else if($this->input_type == 3){
            return "Date Field";
        }else if($this->input_type == 4){
            return "Number Field";
        }else if($this->input_type == 5){
            return "Email Address Field";
        }
    }
    public function designation()
    {
        return $this->hasOne(MarketingWorkPlaceDesignations::class, 'designation_id', 'designation_id');
    }
}
