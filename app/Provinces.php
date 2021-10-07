<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $fillable = ["created_by", "updated_by","deleted_by"];
    protected $table = 'set_provinces';
    
    
}
