<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KCustomerRegister extends Model
{
    use HasFactory;
    protected $fillable = [
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
        'whatsapp',
        'whatsapp_location',
        'visiting_card',
        'owner_number',
        'customer_location',
        'customer_address',
        'district',
        'expiry_date',
        'auditor_name',
        'auditor_mobile',
        'engineer_name',
        'engineer_mobile',
        'engineer_location',
    ];
    public function custname()
    {
        return $this->hasOne(KCallRegister::class, 'cust_id', 'id');
    }
    public function mycust()
    {
        return $this->hasMany(KCallRegister::class, 'cust_id', 'id');
    }
    public function custnames()
    {
        return $this->hasMany(
            KCallRegister::class,
            'cust_id',
            'Date',
            'phoneno',
            'conperson',
            'work',
            'staff_id',
            'status',
            'remarks',
            'completeperson',
            'completeddate',
        );
    }
}