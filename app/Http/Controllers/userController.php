<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class userController extends Controller
{
    //
    public function index()
    {
        $staff = User::all();
        return view('showAllusers')->with('name',$name);
    }
    public function destroy($id)
    {
        
    }
}
