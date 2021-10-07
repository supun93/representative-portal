<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $table = 'marketing_representative';
    protected $primaryKey = 'marketing_representative_id';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function district(): HasOne
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function province(): HasOne
    {
        return $this->hasOne(Provinces::class, 'id', 'province_id');
    }

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function division(): HasOne
    {
        return $this->hasOne(DivisionalSecretariatDivisions::class, 'id', 'division_id');
    }

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function workPlace(): HasOne
    {
        return $this->hasOne(MarketingWorkPlaces::class, 'work_place_id', 'current_workplace');
    }

    /**
     * Get the user associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function designation(): HasOne
    {
        return $this->hasOne(MarketingWorkPlaceDesignations::class, 'designation_id', 'designation_id');
    }

    public function designationFieldsList()
    {
        $designationId = $this->designation_id;
        return $this->hasMany(MarketingRepresentativeCustomizeFields::class, 'marketing_representative_id', 'marketing_representative_id')
        ->with('designationField:designation_field_id,field_name,required')
        ->whereHas('designationField', function ($e) use($designationId){
            $e->where('designation_id', $designationId);
        });
    }
    public function contactFieldsList()
    {
        $representativeId = Auth::user()->marketing_representative_id;
        $types = MarketingCustomizeFormTypes::with(['fieldsList.representativeFieldsList'])->whereHas('fieldsList', function($e) use($representativeId){
            $e->whereHas('representativeFieldsList', function($e) use($representativeId){
                $e->where('marketing_representative_id', $representativeId);
            });
        })->where('category', 'Contact Details')->get();
        return $types;
    }
    public function bankFieldsList()
    {
        $representativeId = Auth::user()->marketing_representative_id;
        $types = MarketingCustomizeFormTypes::with(['fieldsList.representativeFieldsList'])->whereHas('fieldsList', function($e) use($representativeId){
            $e->whereHas('representativeFieldsList', function($e) use($representativeId){
                $e->where('marketing_representative_id', $representativeId);
            });
        })->where('category', 'Bank Details')->get();
        return $types;
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseDetails(): HasMany
    {
        return $this->hasMany(MarketingRepresentativeCourses::class, 'm_r_inc_id', 'marketing_representative_id');
    }
    
}
