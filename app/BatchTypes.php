<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BatchTypes extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["created_by", "updated_by"];
    protected $table = 'batch_types';

    
}
