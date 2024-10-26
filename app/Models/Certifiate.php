<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certifiate extends Model
{
    use HasFactory , SoftDeletes;
    protected $table = "certifiates";
    protected $fillable = [
       'name','start_date' , 'end_date', 'note' ,'document','user_id'
    ];

    public function users(){
        return $this->belongsTo(User::class , 'user_id');
    }
}
