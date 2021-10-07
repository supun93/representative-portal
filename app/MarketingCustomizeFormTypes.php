<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingCustomizeFormTypes extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["created_by", "updated_by", "deleted_by"];
    protected $table = 'marketing_customize_form_types';
    protected $primaryKey = 'type_id';

    protected $appends = ['fields'];

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
        $link = '<a href="'.route('marketing-form-type-fields.list', $this->type_id).'" data-title="Fields List" 
        data-toggle="popover" data-trigger="hover" 
        data-placement="right"
        data-html="true"
        data-content="'.$data.'" class="btn btn-secondary btn-xs"><span class="badge badge-secondary" style="font-size:14px">Fields List ('.$x.')</span></a>';
        return $link;
    }

    /**
     * Get all of the comments for the MarketingCustomizeFormTypes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fieldsList()
    {
        return $this->hasMany(MarketingCustomizeFormTypeFields::class, 'type_id', 'type_id');
    }
}
