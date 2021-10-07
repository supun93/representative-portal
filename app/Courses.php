<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Courses extends Model
{
    use SoftDeletes;
    
    protected $fillable = [];
    protected $table = 'courses';
    protected $primaryKey = 'course_id';

}
