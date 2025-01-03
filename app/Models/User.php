<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens , Notifiable , HasRoles , SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en',
        'email',
        'password',
        'fcm_token',
        'usrename',
        'phone',
        'ID_code',
        'passport_code',
        'salary',
        'location_ar',
        'location_en',
        'date_of_brith',
        'join_date',
        'country_id',
        'gender_id',
        'reigon_id',
        'material_status_id',
        'work_type_id',
        'contract_type_id',
        'directory_id',
        'status_user_id',
        'department_id',
        'photo',
        'is_directory',
        'code_auth',
        'expire_time',
        'last_login',
        'google_id',
        'facebook_id',
        'twitter_id',
        'apple_id',
        'enable_notification',
        'ip',
        'user_agent',

    ];

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

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function getCountry() {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function getGender() {
        return $this->hasOne(Lookup::class, 'id', 'gender_id');
    }

    public function getReigon() {
        return $this->hasOne(Lookup::class, 'id', 'reigon_id');
    }

    public function getMaterialStatus() {
        return $this->hasOne(Lookup::class, 'id', 'material_status_id');
    }

    public function getWorkType() {
        return $this->hasOne(Lookup::class, 'id', 'work_type_id');
    }

    public function getContractType() {
        return $this->hasOne(Lookup::class, 'id', 'contract_type_id');
    }

    public function getStatusUser() {
        return $this->hasOne(Lookup::class, 'id', 'status_user_id');
    }

    public function getDirectory() {
        return $this->hasOne(User::class , 'id' , 'is_directory');
    }

    public function getDepartment() {
        return $this->hasOne(Department::class , 'id' , 'department_id');
    }

    public function getVacations()
    {
        return $this->hasMany(Vacation::class);
    }

    /**
     * Calculate the total number of sick leave days taken by the user.
     *
     * This function retrieves all vacation records of type "Sick Leave" for the user,
     * then sums the number of days (including both start and end dates) for each record.
     *
     * @return int Total number of sick leave days.
     */
    public function getSickLeave() {
        $sickID = getIDLookups('TV-Sick');
        $vacations =  Vacation::where('user_id', $this->id)->where('type_vacation_id', $sickID)->get();
        $count = 0;
        foreach ($vacations as $vacation){
            $count+= Carbon::parse($vacation->start_date)->diffInDays(Carbon::parse($vacation->end_date)) + 1;
        }
        return $count;
    }

    public function getAnnualLeave() {
        $sickID = getIDLookups('TV-Sick');
        $vacations =  Vacation::where('user_id', $this->id)->where('type_vacation_id'  ,'!=',  $sickID)->get();
        $count = 0;
        foreach ($vacations as $vacation){
            $count+= Carbon::parse($vacation->start_date)->diffInDays(Carbon::parse($vacation->end_date)) + 1;
        }
        return $count;

    }
}
