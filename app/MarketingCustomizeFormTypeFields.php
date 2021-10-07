<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingCustomizeFormTypeFields extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["created_by", "updated_by", "deleted_by"];
    protected $table = 'marketing_customize_form_type_fields';
    protected $primaryKey = 'type_field_id';
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
   
    public function customizeFormType()
    {
        return $this->hasOne(MarketingCustomizeFormTypes::class, 'type_id', 'type_id');
    }
    public function representativeFieldsList()
    {
        return $this->hasMany(MarketingRepresentativeCustomizeFields::class, 'type_field_id', 'type_field_id');
    }
}
