<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketingRepresentativeCourses extends Model
{
    use SoftDeletes;
    
    protected $fillable = ["created_by", "updated_by", "deleted_by"];
    protected $table = 'marketing_representative_courses';
    protected $primaryKey = 'id';

   
    /**
     * Get the user associated with the MarketingRepresentativeCourses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function course()
    {
        return $this->hasOne(Courses::class, 'course_id', 'course_id');
    }

    public function batchType()
    {
        return $this->hasOne(BatchTypes::class, 'id', 'batch_type');
    }

    public function representative()
    {
        return $this->hasOne(User::class, 'marketing_representative_id', 'm_r_inc_id');
    }
}
