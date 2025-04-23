<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KCustomerRegister;

class customercontroller extends Controller
{
    //
    public function index()
    {
        $customer = KCustomerRegister::all();
        return view('showAllCustomer')->with('comname',$comname);
    }
}
