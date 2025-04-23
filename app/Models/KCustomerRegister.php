<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KCustomerRegister extends Model
{
    use HasFactory;
    protected $fillable=[
        'comname',
        'name',
        'phone',
        'mobile',
        'email',
        'serialNo',
        'gstno',
        'refname',
        'pack',
        'type',
    ];
    public function custname()
    {
        return $this->hasOne(KCallRegister::class,'cust_id','id');
    }
    public function mycust()
    {
        return $this->hasMany(KCallRegister::class,'cust_id','id');
    }
    public function custnames()
    {
        return $this->hasMany(KCallRegister::class, 
        'cust_id',
        'Date',
        'phoneno',
        'conperson',
        'work',
        'staff_id',
        'status',
        'remarks',
        'completeperson',
        'completeddate',);
    }
}