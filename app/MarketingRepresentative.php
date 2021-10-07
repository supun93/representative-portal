<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MarketingRepresentative extends Model
{
    use SoftDeletes;
 
    protected $fillable = ["created_by", "updated_by", "deleted_by"];
    protected $table = 'marketing_representative';
    protected $primaryKey = 'marketing_representative_id';
    
}
