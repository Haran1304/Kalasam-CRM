<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KCallRegister extends Model
{
    use HasFactory;
    protected $fillable = [
        'cust_id',
        'order_no',
        'call_date',
        'phoneno',
        'conperson',
        'work',
        'staff_id',
        'status',
        'remarks',
        'completeperson',
        'completeddate',
    ];
    public function custname()
    {
        return $this->hasOne(KCustomerRegister::class, 'id', 'cust_id');
    }
    public function staffname()
    {
        return $this->hasOne(User::class, 'id', 'staff_id');
    }
    public function mycust()
    {
        return $this->hasMany(KCustomerRegister::class, 'id', 'cust_id');
    }
    public function custnames()
    {
        return $this->hasMany(KCustomerRegister::class);
    }
}
