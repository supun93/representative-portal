<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogActivity extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['representative_id', 'ip', 'agent'];
    protected $table = 'marketing_representative_log_activities';
    protected $primaryKey = 'id';
}
