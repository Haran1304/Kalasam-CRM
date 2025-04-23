<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KCallRegister;
use App\Models\KstaffDtls;
use App\Models\KCustomerRegister;
use Illuminate\Support\Facades\DB;

class TypeaheadController extends Controller
{
    public function index()
    {
       $cust    = KCustomerRegister::select(
            'name as label',
            'name as value',
            'id as values')
        ->get();
        //  $data = array();
        // foreach ($cust as $cust1)
        // {
        //     $data[] = $cust1->label;
        // }
        //echo json_encode($data);
        //$data1 = json_encode($data);
        //echo $cust1;
       return view('calls/jquerycallreport',compact('cust'));
    
    }
    public function autocompleteSearch(Request $request)
    {
        DB::enableQueryLog();

        $query = $request->get('query');
        //$filterResult = KCustomerRegister::where('comname', 'LIKE', '%'. $query. '%')->get();
        //$filterResult = KCustomerRegister::where('phone', 'LIKE', '%'. $query. '%')->get();
        
       // echo $filterResult;
       $filterResult = KCustomerRegister::select('comname as label,id as value')
       ->where('comname', 'LIKE', '%'. $query. '%')
       ->get();
    // ->orderBy('created_at', 'desc')
    // ->get();
    //dd(\DB::getQueryLog());
        return response()->json($filterResult);
    } 
}
