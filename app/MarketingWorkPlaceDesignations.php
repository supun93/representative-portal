<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingWorkPlaceDesignations extends Model
{
    use SoftDeletes;
  
    protected $fillable = ["created_by", "updated_by", "deleted_by"];
    protected $table = 'marketing_work_place_designations';
    protected $primaryKey = 'designation_id';
    
    protected $appends = ["id", "name", 'fields'];

    public function getFieldsAttribute(){
        $data = '';
        $x = 0;
        foreach($this->fieldsList as $item){
            $x++;
            $data = $data . $item->field_name;
            if($this->fieldsList->count() > $x){
                $data = $data . '<br/>';
            }
        }
        if($x == 0){
            $data = "<span class='badge badge-danger'>No fields</span>";
        }
        $link = '<a href="'.route('marketing-designations-fields.list', $this->designation_id).'" data-title="Fields List" 
        data-toggle="popover" data-trigger="hover" 
        data-placement="right"
        data-html="true"
        data-content="'.$data.'" class="btn btn-secondary btn-xs"><span class="badge badge-secondary" style="font-size:14px">Fields List ('.$x.')</span></a>';
        return $link;
    }

    public function getIdAttribute()
    {
        return $this->{$this->primaryKey};
    }
 
    public function getNameAttribute()
    {
        return $this->school_name;
    }


    public function fieldsList()
    {
        return $this->hasMany(MarketingDesignationFields::class, 'designation_id', 'designation_id');
    }

    
}
