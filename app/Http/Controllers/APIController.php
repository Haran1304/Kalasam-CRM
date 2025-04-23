<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\KCallRegister;
use App\Models\KstaffDtls;
use App\Models\KCustomerRegister;
use Validator;
use Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class APIController extends Controller
{

    public function index()
    {
        $cpage = KCallRegister::paginate(10);
        return view('Calls/callsreport', compact('cpage'));
        //return json_encode($order);
    }
    public function userregistration(Request $request)
    {
        try {
            $input = $request->all();
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            $result = array();
            $result['success'] = 1;
            $result['data'] = $user;
            return json_encode($result);
        } catch (\Exception $e) {
            $result = array();
            $result['success'] = 0;
            $result['data'] = $e;
            return json_encode($result);
        }
    }
    public function homepage(Request $request)
    {
        $user = User::where('name', '=', $request->name)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loginId', $user->id);
                return redirect('home');
            } else {
                return back()->with('fail', 'Password not matches.');
            }
        } else {
            return back()->with('fail', 'user name is not registered.');
        }
    }
    public function registerform()
    {
        $str_random = Str::random(12);
        return view('register', compact('str_random'));
    }
    public function loginpage()
    {
        $str_random = Str::random(12);
        return view('welcome', compact('str_random'));
    }
    public function home(Request $request)
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }

        $today = date('Y-m-d');

        // Date filter for Next Call date
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if ($fromDate && $toDate) {
            $toDate = \Carbon\Carbon::parse($toDate)->endOfDay(); // Include the end of the selected day
            $callsToday = KCallRegister::whereBetween('Ncalldate', [$fromDate, $toDate])
                ->where('status', 'Pending')
                ->orderBy('Ncalldate', 'desc')
                ->get()
                ->groupBy(function ($item) {
                    return $item['cust_id'] . '-' . $item['billtype'];
                })
                ->map(function ($group) {
                    return $group->first();
                });
        } else {
            $callsToday = KCallRegister::whereDate('Ncalldate', $today)
                ->where('status', 'Pending')
                ->orderBy('Ncalldate', 'desc')
                ->get()
                ->groupBy(function ($item) {
                    return $item['cust_id'] . '-' . $item['billtype'];
                })
                ->map(function ($group) {
                    return $group->first();
                });
        }

        // Filter out calls that are not the latest for each customer
        $latestCalls = KCallRegister::where('status', 'Pending')
            ->orderBy('Ncalldate', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item['cust_id'] . '-' . $item['billtype'];
            })
            ->map(function ($group) {
                return $group->first();
            });

        $callsToday = $callsToday->filter(function ($call) use ($latestCalls) {
            return $call->id == $latestCalls[$call['cust_id'] . '-' . $call['billtype']]->id;
        });

        return view('homepage', compact('data', 'callsToday', 'fromDate', 'toDate'));
    }



    public function homelogout()
    {
        if (Session::has('loginId')) {
            Session::pull('loginId');
        } else {
            return redirect('/');
        }
        return view('welcome')->with('success', 'you logout successfully');
    }
    public function addcust()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        $str_random = Str::random(12);
        return view('Customer/addcustomer', compact('data'));
    }
    // public function custReport()
    // {
    //     $data = array();
    //     if (Session::has('loginId')) {
    //         $data = User::where('id', '=', Session::get('loginId'))
    //         ->first();
    //     } else {
    //         return redirect('/');
    //     }
    //     $calls = KCallRegister::with('custname')
    //         ->with('staffname')
    //         //->whereDay('call_date', now()->day)
    //         //->orwhereDay('Ncalldate',now()->day)
    //         ->get();
    //     //->paginate(10);
    //     $cust = KCustomerRegister::select(
    //         'comname as label',
    //         'comname as value',
    //         'id as values'
    //     )
    //         ->get();
    //     $phoneno = KCallRegister::select(
    //         'phoneno as label',
    //         'phoneno as value',
    //         'phoneno as values'
    //     )
    //         ->groupBy('phoneno')
    //         ->get();
    //     //$phoneno = KCallRegister::distinct()->whereNotNull('phoneno')->get(['phoneno']);

    //     $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
    //     $val = array();
    //     $val['FDate'] = now()->day;
    //     $val['TDate'] = now()->day;
    //     $val['work'] = "All";
    //     $val['status'] = 'All';
    //     $val['billtype'] = 'All';
    //     $val['cust_id'] = '';
    //     $val['phoneno'] = '';
    //     $val['callallocation'] = '';
    //     return view('Calls/callsreport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    // }

    public function custReport()
    {
        $data = [];

        if (Session::has('loginId')) {
            $data = User::where('id', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }

        // Check if user is staff or admin
        if ($data->usertype === "Staff") {
            // Only show calls created by this staff user
            $calls = KCallRegister::with('custname', 'staffname')
                ->where('staff_id', $data->id) // adjust if your column name is different
                ->get();
        } else {
            // Admin sees all calls
            $calls = KCallRegister::with('custname', 'staffname')->get();
        }

        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )->get();

        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();

        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);

        $val = [
            'FDate' => now()->day,
            'TDate' => now()->day,
            'work' => 'All',
            'status' => 'All',
            'billtype' => 'All',
            'cust_id' => '',
            'phoneno' => '',
            'callallocation' => '',
        ];

        return view('Calls/callsreport', compact('calls'), [
            'data' => $data,
            'cust' => $cust,
            'phoneno' => $phoneno,
            'staff' => $staff,
            'val' => $val,
        ]);
    }
    public function addcall()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        $str_random = Str::random(12);
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values',
            'phone as mobile',
            'name as contactperson'
        )
            ->get();
        $data1 = User::all();
        return view('Calls/callregister', compact('data'), ['cust' => $cust, 'data1' => $data1]);
    }
    public function addNewUser(Request $request)
    {
        $test2 = User::where('name', $request->name)
            ->get();
        if (count($test2) > 0) {
            echo "Already available";
            return;
        }
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->confirpassword = $request->password;
            $user->usertype = $request->usertype;
            $res = $user->save();
            if ($res) {
                return view('welcome')->with('success', 'you have register successfully');
            } else {
                return back()->with('fail', 'something wrong');
            }
        } catch (\Exception $e) {
            $result = array();
            $result['success'] = 0;
            $result['data'] = $e;
            return json_encode($result);
        }
    }
    public function addcustomer(Request $request)
    {
        $test2 = KCustomerRegister::where('comname', $request->comname)
            ->get();
        if (count($test2) > 0) {
            echo "Already available";
            return;
        }
        try {
            DB::beginTransaction();
            $cust = new KCustomerRegister;
            $cust->comname = $request->comname;
            $cust->name = $request->name;
            $cust->phone = $request->phone;
            $cust->mobile = $request->mobile;
            $cust->email = $request->email;
            $cust->serialNo = $request->serialNo;
            $cust->gstno = $request->gstno;
            $cust->refname = $request->refname;
            $cust->pack = $request->pack;
            $cust->billtype = $request->billtype;
            $cust->software = $request->software;
            //print_r($cust);
            $cust->save();
            DB::commit();
            $data = array();
            if (Session::has('loginId')) {
                $data = User::where('id', '=', Session::get('loginId'))->first();
            } else {
                return redirect('/');
            }
            $str_random = Str::random(12);
            return view('Customer/addcustomer', compact('str_random'));
        } catch (\Exception $e) {
            $result = array();
            $result['success'] = 0;
            $result['data'] = $e;
            return json_encode($result);
        }

    }
    public function callregister(Request $request)
    {
        try {

            DB::beginTransaction();
            $latestOrderNo = 0;
            $latestOrderNo = KCallRegister::where('cust_id', $request->cust_id)->max('order_no');
            $nextOrderNo = $latestOrderNo ? $latestOrderNo + 1 : 1;

            $calls = new KCallRegister;
            $calls->cust_id = $request->cust_id;
            $calls->order_no = $nextOrderNo;
            $calls->call_date = date('Y-m-d H:i:s');
            $calls->phoneno = $request->phoneno;
            $calls->conperson = $request->conperson;
            $calls->work = $request->work;
            $calls->staff_id = $request->staff_id;
            $calls->callallocation = $request->callallocation;
            $calls->status = $request->status;
            $calls->remarks = $request->remarks;
            $calls->serialNo = $request->serialNo;
            $calls->Ncalldate = $request->Ncalldate;
            $calls->billtype = $request->billtype;
            $calls->software = $request->software;
            $calls->completeperson = $request->completeperson;
            $calls->completeddate = $request->completeddate;
            //print_r($calls);
            $calls->save();
            DB::commit();
            $str_random = Str::random(12);
            $cust = KCustomerRegister::select(
                'comname as label',
                'comname as value',
                'id as values'
            )
                ->get();
            //echo $cust;
            $data1 = User::all();
            $data = array();
            if (Session::has('loginId')) {
                $data = User::where('id', '=', Session::get('loginId'))->first();
            } else {
                return redirect('/');
            }
            return view('Calls/callregister', compact('data'), ['cust' => $cust, 'data1' => $data1]);

        } catch (\Exception $e) {
            $result = array();
            $result['success'] = 0;
            $result['data'] = $e;
            return json_encode($result);
        }
    }
    public function CallsReport(Request $request)
    {
        $val = array();
        $val['FDate'] = $request->FDate;
        $val['TDate'] = $request->TDate;
        $val['work'] = $request->work;
        $val['status'] = $request->status;
        $val['billtype'] = $request->billtype;
        $val['cust_id'] = $request->cust_id;
        $val['phoneno'] = $request->phoneno;
        $val['callallocation'] = $request->callallocation;

        $Sdate = Carbon::parse($request->FDate)->startOfDay(); // Start of the selected day
        $Edate = Carbon::parse($request->TDate)->endOfDay();   // End of the selected day

        $user = Auth::user();
        $query = KCallRegister::query()
            ->where('call_date', '>=', $Sdate)
            ->where('call_date', '<=', $Edate);

        // Filter calls based on user role
        if ($user->usertype === 'Staff') {
            $query->where('staff_id', $user->id); // Show only calls assigned to the logged-in staff
        }

        // Apply additional filters
        if (isset($request->work) && ($request->work != 'All') && ($request->work != null)) {
            $query->where('work', $request->work);
        }
        if (isset($request->status) && ($request->status != 'All') && ($request->status != null)) {
            $query->where('status', $request->status);
        }
        if (isset($request->billtype) && ($request->billtype != 'All') && ($request->billtype != null)) {
            $query->where('billtype', $request->billtype);
        }
        if (isset($request->cust_id) && ($request->cust_id != 'All') && ($request->cust_id != null)) {
            $query->where('cust_id', $request->cust_id);
        }
        if (isset($request->callallocation) && ($request->callallocation != 'All') && ($request->callallocation != null)) {
            $query->where('callallocation', $request->callallocation);
        }
        if (isset($request->phoneno) && ($request->phoneno != 'All') && ($request->phoneno != null)) {
            $query->where('phoneno', $request->phoneno);
        }

        $calls = $query->get();

        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )->get();

        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )->groupBy('phoneno')->get();

        $data = User::all();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);

        return view('Calls/callsreport', [
            'calls' => $calls,
            'data' => $data,
            'cust' => $cust,
            'phoneno' => $phoneno,
            'staff' => $staff,
            'val' => $val,
        ]);
    }
    // public function ledgerreport(Request $request)
    // {
    //     $data = array();
    //     if (Session::has('loginId')) {
    //         $data = User::where('id', '=', Session::get('loginId'))->first();
    //     } else {
    //         return redirect('/');
    //     }
    //     $calls = KCallRegister::distinct()
    //         ->where('status', '=', 'Pending')
    //         ->get(['cust_id', 'billtype', 'phoneno', 'conperson', 'work']);

    //     $cust = KCustomerRegister::select(
    //         'comname as label',
    //         'comname as value',
    //         'id as values'
    //     )
    //         ->get();
    //     $phoneno = KCallRegister::select(
    //         'phoneno as label',
    //         'phoneno as value',
    //         'phoneno as values'
    //     )
    //         ->groupBy('phoneno')
    //         ->get();
    //     $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
    //     $val = array();
    //     $val['FDate'] = now()->day;
    //     $val['TDate'] = now()->day;
    //     $val['work'] = "All";
    //     $val['status'] = 'Pending';
    //     $val['billtype'] = 'TDL';
    //     $val['cust_id'] = '';
    //     $val['phoneno'] = '';
    //     $val['callallocation'] = '';
    //     return view('Calls/ledgerwisereport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    // }

    public function ledreport()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        $calls = KCallRegister::with('custname')
            ->with('staffname')
            ->orderBy('call_date', 'desc')
            ->get()
            ->groupBy(function ($item) {
                return $item['cust_id'] . '-' . $item['billtype'];
            })
            ->map(function ($group) {
                return $group->first();
            });

        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        $val = array();
        $val['FDate'] = now()->day;
        $val['TDate'] = now()->day;
        $val['work'] = "All";
        $val['status'] = 'All';
        $val['billtype'] = 'All';
        $val['cust_id'] = '';
        $val['phoneno'] = '';
        $val['callallocation'] = '';
        return view('Calls/ledgerwisereport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function ledgerwisereport(Request $request)
    {
        $val = array();
        $val['FDate'] = $request->FDate;
        $val['TDate'] = $request->TDate;
        $val['work'] = $request->work;
        $val['status'] = $request->status;
        $val['billtype'] = $request->billtype;
        $val['cust_id'] = $request->cust_id;
        $val['phoneno'] = $request->phoneno;
        $val['callallocation'] = $request->callallocation;
        $Sdate = $request->FDate;
        $Edate = $request->TDate;
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $data = User::all();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        DB::enableQueryLog();
        $query = KCallRegister::query()->where('call_date', '>=', $Sdate)
            ->where('call_date', '<=', $Edate);

        if (isset($request->work) && ($request->work != 'All') && ($request->work != null)) {
            $query->where('work', $request->work);
        }
        if (isset($request->status) && ($request->status != 'All') && ($request->status != null)) {
            $query->where('status', $request->status);
        }
        if (isset($request->billtype) && ($request->billtype != 'All') && ($request->billtype != null)) {
            $query->where('billtype', $request->billtype);
        }
        if (isset($request->cust_id) && ($request->cust_id != 'All') && ($request->cust_id != null)) {
            $query->where('cust_id', $request->cust_id);
        }
        if (isset($request->callallocation) && ($request->callallocation != 'All') && ($request->callallocation != null)) {
            $query->where('callallocation', $request->callallocation);
        }
        if (isset($request->phoneno) && ($request->phoneno != 'All') && ($request->phoneno != null)) {
            $query->where('phoneno', $request->phoneno);
        }

        $calls = $query->orderBy('call_date', 'desc')
            ->get()
            ->groupBy('cust_id')
            ->map(function ($group) {
                return $group->unique('work')->first();
            });

        return view('Calls/ledgerwisereport', ['calls' => $calls, 'data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function UpdateCalls($id, Request $request)
    {


        $calls = KCallRegister::find($id);
        $custid = $calls->cust_id;
        $order_no = $calls->order_no;
        $staffid = $calls->staff_id;
        $cust = KCustomerRegister::find($custid);
        $data1 = User::find($staffid);
        $data2 = User::all();
        $val = array();
        $val['FDate'] = now()->day;
        $val['TDate'] = now()->day;
        $val['work'] = "All";
        $val['status'] = 'Pending';
        $val['billtype'] = 'AMC';
        $val['cust_id'] = '';
        $val['phoneno'] = '';
        $val['callallocation'] = 'All';
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        return view('Calls/editcallsregister', compact('calls'), ['data' => $data, 'cust' => $cust, 'data1' => $data1, 'data2' => $data2, 'staff' => $staff, 'val' => $val]);
    }
    public function updateregister(Request $request)
    {
        try {
            DB::beginTransaction();

            // Check if the call already exists
            $calls1 = KCallRegister::find($request->cust_id);

            if ($calls1) {
                // Retain the existing order_no
                $order_no = $calls1->order_no;
            } else {
                // Generate a new order_no
                $latestOrderNo = KCallRegister::where('cust_id', $request->cust_id)->max('order_no');
                $order_no = $latestOrderNo ? $latestOrderNo : 1;
                $calls1 = new KCallRegister;
            }

            $calls1->cust_id = $request->cust_id;
            // $calls1->call_date = date('Y-m-d H:i:s');
            $calls1->call_date = $request->Ncalldate;
            $calls1->phoneno = $request->phoneno;
            $calls1->conperson = $request->conperson;
            $calls1->work = $request->work;
            $calls1->staff_id = $request->staff_id;
            $calls1->callallocation = $request->callallocation;
            $calls1->status = $request->status;
            $calls1->remarks = $request->remarks;
            $calls1->serialNo = $request->serialNo;
            $calls1->Ncalldate = $request->Ncalldate;
            $calls1->billtype = $request->billtype;
            $calls1->software = $request->software;
            $calls1->completeperson = $request->completeperson;
            $calls1->completeddate = $request->completeddate;
            $calls1->order_no = $order_no;

            $calls1->save();
            DB::commit();

            $val = array();
            $val['FDate'] = now()->day;
            $val['TDate'] = now()->day;
            $val['work'] = "All";
            $val['status'] = "All";
            $val['billtype'] = "All";
            $val['cust_id'] = '';
            $val['phoneno'] = '';
            $val['callallocation'] = 'All';
            $calls = KCallRegister::get();
            $cust = KCustomerRegister::all();
            $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
            $phoneno = KCallRegister::distinct()->whereNotNull('phoneno')->get(['phoneno']);
            $data = array();
            if (Session::has('loginId')) {
                $data = User::where('id', '=', Session::get('loginId'))->first();
            } else {
                return redirect('/');
            }
            return view('Calls/callsreport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
        } catch (\Exception $e) {
            DB::rollBack();
            $result = array();
            $result['success'] = 0;
            $result['data'] = $e;
            return json_encode($result);
        }
    }
    public function service()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        $calls = KCallRegister::with('custname')
            ->with('staffname')
            ->where('billtype', '!=', 'Leads')
            ->where('billtype', '!=', 'TSS')
            ->where('billtype', '!=', 'TDL')
            ->get();
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        $val = array();
        $val['FDate'] = now()->day;
        $val['TDate'] = now()->day;
        $val['work'] = "All";
        $val['status'] = 'All';
        $val['billtype'] = 'All';
        $val['cust_id'] = '';
        $val['phoneno'] = '';
        $val['callallocation'] = '';
        return view('Calls/servicecallsreport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function leads()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        $calls = KCallRegister::with('custname')
            ->with('staffname')
            ->where('billtype', '=', 'Leads')
            ->get();
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        $val = array();
        $val['FDate'] = now()->day;
        $val['TDate'] = now()->day;
        $val['work'] = "All";
        $val['status'] = 'Pending';
        $val['billtype'] = 'Leads';
        $val['cust_id'] = '';
        $val['phoneno'] = '';
        $val['callallocation'] = '';
        return view('Calls/leadscallsreport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function tdl()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        $calls = KCallRegister::with('custname')
            ->with('staffname')
            ->where('billtype', '=', 'TDL')
            ->get();
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        //$phoneno = KCallRegister::distinct()->whereNotNull('phoneno')->get(['phoneno']);

        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        $val = array();
        $val['FDate'] = now()->day;
        $val['TDate'] = now()->day;
        $val['work'] = "All";
        $val['status'] = 'Pending';
        $val['billtype'] = 'TDL';
        $val['cust_id'] = '';
        $val['phoneno'] = '';
        $val['callallocation'] = '';
        return view('Calls/tdlcallsreport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function tss()
    {
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        $calls = KCallRegister::with('custname')
            ->with('staffname')
            ->where('billtype', '=', 'TSS')
            ->get();
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        $val = array();
        $val['FDate'] = now()->day;
        $val['TDate'] = now()->day;
        $val['work'] = "All";
        $val['status'] = 'Pending';
        $val['billtype'] = 'TSS';
        $val['cust_id'] = '';
        $val['phoneno'] = '';
        $val['callallocation'] = '';
        return view('Calls/tsscallsreport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function leadReport(Request $request)
    {
        $val = array();
        $val['FDate'] = $request->FDate;
        $val['TDate'] = $request->TDate;
        $val['work'] = $request->work;
        $val['status'] = $request->status;
        $val['billtype'] = $request->billtype;
        $val['cust_id'] = $request->cust_id;
        $val['phoneno'] = $request->phoneno;
        $val['callallocation'] = $request->callallocation;
        $Sdate = $request->FDate;
        $Edate = $request->TDate;
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $data = User::all();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        DB::enableQueryLog();
        $query = KCallRegister::query()->where('call_date', '>=', $Sdate)
            ->where('call_date', '<=', $Edate);
        if (isset($request->work) && ($request->work != 'All') && ($request->work != null)) {
            $query->where('work', $request->work);
        }
        if (isset($request->status) && ($request->status != 'All') && ($request->status != null)) {
            $query->where('status', $request->status);
        }
        if (isset($request->billtype) && ($request->billtype != 'All') && ($request->billtype != null)) {
            $query->where('billtype', $request->billtype);
        }
        if (isset($request->cust_id) && ($request->cust_id != 'All') && ($request->cust_id != null)) {
            $query->where('cust_id', $request->cust_id);
        }
        if (isset($request->callallocation) && ($request->callallocation != 'All') && ($request->callallocation != null)) {
            $query->where('callallocation', $request->callallocation);
        }
        if (isset($request->phoneno) && ($request->phoneno != 'All') && ($request->phoneno != null)) {
            $query->where('phoneno', $request->phoneno);
        }
        $calls = $query->get();
        return view('Calls/leadscallsreport', ['calls' => $calls, 'data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function tssReport(Request $request)
    {
        $val = array();
        $val['FDate'] = $request->FDate;
        $val['TDate'] = $request->TDate;
        $val['work'] = $request->work;
        $val['status'] = $request->status;
        $val['billtype'] = $request->billtype;
        $val['cust_id'] = $request->cust_id;
        $val['phoneno'] = $request->phoneno;
        $val['callallocation'] = $request->callallocation;
        $Sdate = $request->FDate;
        $Edate = $request->TDate;
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $data = User::all();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        DB::enableQueryLog();
        $query = KCallRegister::query()->where('call_date', '>=', $Sdate)
            ->where('call_date', '<=', $Edate);
        if (isset($request->work) && ($request->work != 'All') && ($request->work != null)) {
            $query->where('work', $request->work);
        }
        if (isset($request->status) && ($request->status != 'All') && ($request->status != null)) {
            $query->where('status', $request->status);
        }
        if (isset($request->billtype) && ($request->billtype != 'All') && ($request->billtype != null)) {
            $query->where('billtype', $request->billtype);
        }
        if (isset($request->cust_id) && ($request->cust_id != 'All') && ($request->cust_id != null)) {
            $query->where('cust_id', $request->cust_id);
        }
        if (isset($request->callallocation) && ($request->callallocation != 'All') && ($request->callallocation != null)) {
            $query->where('callallocation', $request->callallocation);
        }
        if (isset($request->phoneno) && ($request->phoneno != 'All') && ($request->phoneno != null)) {
            $query->where('phoneno', $request->phoneno);
        }
        $calls = $query->get();
        return view('Calls/tsscallsreport', ['calls' => $calls, 'data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function tdlReport(Request $request)
    {
        $val = array();
        $val['FDate'] = $request->FDate;
        $val['TDate'] = $request->TDate;
        $val['work'] = $request->work;
        $val['status'] = $request->status;
        $val['billtype'] = $request->billtype;
        $val['cust_id'] = $request->cust_id;
        $val['phoneno'] = $request->phoneno;
        $val['callallocation'] = $request->callallocation;
        $Sdate = $request->FDate;
        $Edate = $request->TDate;
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $data = User::all();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        DB::enableQueryLog();
        $query = KCallRegister::query()->where('call_date', '>=', $Sdate)
            ->where('call_date', '<=', $Edate);
        if (isset($request->work) && ($request->work != 'All') && ($request->work != null)) {
            $query->where('work', $request->work);
        }
        if (isset($request->status) && ($request->status != 'All') && ($request->status != null)) {
            $query->where('status', $request->status);
        }
        if (isset($request->billtype) && ($request->billtype != 'All') && ($request->billtype != null)) {
            $query->where('billtype', $request->billtype);
        }
        if (isset($request->cust_id) && ($request->cust_id != 'All') && ($request->cust_id != null)) {
            $query->where('cust_id', $request->cust_id);
        }
        if (isset($request->callallocation) && ($request->callallocation != 'All') && ($request->callallocation != null)) {
            $query->where('callallocation', $request->callallocation);
        }
        if (isset($request->phoneno) && ($request->phoneno != 'All') && ($request->phoneno != null)) {
            $query->where('phoneno', $request->phoneno);
        }
        $calls = $query->get();
        return view('Calls/tdlcallsreport', ['calls' => $calls, 'data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function serviceReport(Request $request)
    {
        $val = array();
        $val['FDate'] = $request->FDate;
        $val['TDate'] = $request->TDate;
        $val['work'] = $request->work;
        $val['status'] = $request->status;
        $val['billtype'] = $request->billtype;
        $val['cust_id'] = $request->cust_id;
        $val['phoneno'] = $request->phoneno;
        $val['callallocation'] = $request->callallocation;
        $Sdate = $request->FDate;
        $Edate = $request->TDate;
        $cust = KCustomerRegister::select(
            'comname as label',
            'comname as value',
            'id as values'
        )
            ->get();
        $phoneno = KCallRegister::select(
            'phoneno as label',
            'phoneno as value',
            'phoneno as values'
        )
            ->groupBy('phoneno')
            ->get();
        $data = User::all();
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        DB::enableQueryLog();
        $query = KCallRegister::query()->where('call_date', '>=', $Sdate)
            ->where('call_date', '<=', $Edate);
        if (isset($request->work) && ($request->work != 'All') && ($request->work != null)) {
            $query->where('work', $request->work);
        }
        if (isset($request->status) && ($request->status != 'All') && ($request->status != null)) {
            $query->where('status', $request->status);
        }
        if (($request->billtype = 'All')) {
            $query->where('billtype', '!=', 'Leads')
                ->where('billtype', '!=', 'TSS')
                ->where('billtype', '!=', 'TDL');
        }
        if (isset($request->billtype) && ($request->billtype != 'All') && ($request->billtype != null)) {
            $query->where('billtype', $request->billtype);
        }
        if (isset($request->cust_id) && ($request->cust_id != 'All') && ($request->cust_id != null)) {
            $query->where('cust_id', $request->cust_id);
        }
        if (isset($request->callallocation) && ($request->callallocation != 'All') && ($request->callallocation != null)) {
            $query->where('callallocation', $request->callallocation);
        }
        if (isset($request->phoneno) && ($request->phoneno != 'All') && ($request->phoneno != null)) {
            $query->where('phoneno', $request->phoneno);
        }
        $calls = $query->get();
        return view('Calls/servicecallsreport', ['calls' => $calls, 'data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
    }
    public function alterCalls($id)
    {
        $calls = KCallRegister::find($id);
        $custid = $calls->cust_id;
        $staffid = $calls->staff_id;
        $cust = KCustomerRegister::find($custid);
        $data1 = User::find($staffid);
        $data2 = User::all();
        $val = array();
        $val['FDate'] = now()->day;
        $val['TDate'] = now()->day;
        $val['work'] = "All";
        $val['status'] = 'Pending';
        $val['billtype'] = 'AMC';
        $val['cust_id'] = '';
        $val['phoneno'] = '';
        $val['callallocation'] = 'All';
        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
        $data = array();
        if (Session::has('loginId')) {
            $data = User::where('id', '=', Session::get('loginId'))->first();
        } else {
            return redirect('/');
        }
        return view('Calls/altercallsregister', compact('calls'), ['data' => $data, 'cust' => $cust, 'data1' => $data1, 'data2' => $data2, 'staff' => $staff, 'val' => $val]);
    }

    //view history of customer

    public function viewhistory($cust_id, $billtype)
    {
        $calls = KCallRegister::where('cust_id', $cust_id)
            ->where('billtype', $billtype)
            ->get();
        $customer = KCustomerRegister::find($cust_id);

        return view('Calls/viewhistory', compact('calls', 'customer'));
    }

    public function alterregister(Request $request)
    {
        try {
            // echo $request;
            // exit;
            DB::beginTransaction();
            $id = $request->id;
            $calls1 = KCallRegister::where('id', $id)
                ->update([
                    'cust_id' => $request->cust_id,
                    'phoneno' => $request->phoneno,
                    'conperson' => $request->conperson,
                    'work' => $request->work,
                    'staff_id' => $request->staff_id,
                    'callallocation' => $request->callallocation,
                    'status' => $request->status,
                    'remarks' => $request->remarks,
                    'serialNo' => $request->serialNo,
                    'Ncalldate' => $request->Ncalldate,
                    'billtype' => $request->billtype,
                    'software' => $request->software,
                    'completeperson' => $request->completeperson,
                    'completeddate' => $request->completeddate,
                ]);
            DB::commit();
            $val = array();
            $val['FDate'] = now()->day;
            $val['TDate'] = now()->day;
            $val['work'] = "All";
            $val['status'] = 'Pending';
            $val['billtype'] = 'AMC';
            $val['cust_id'] = '';
            $val['phoneno'] = '';
            $val['callallocation'] = 'All';
            $calls = KCallRegister::get();
            $cust = KCustomerRegister::all();
            $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);
            $phoneno = KCallRegister::distinct()->whereNotNull('phoneno')->get(['phoneno']);
            $data = array();
            if (Session::has('loginId')) {
                $data = User::where('id', '=', Session::get('loginId'))->first();
            } else {
                return redirect('/');
            }
            return view('Calls/callsreport', compact('calls'), ['data' => $data, 'cust' => $cust, 'phoneno' => $phoneno, 'staff' => $staff, 'val' => $val]);
        } catch (\Exception $e) {
            $result = array();
            $result['success'] = 0;
            $result['data'] = $e;
            return json_encode($result);
        }
    }

    public function editcall($id)
    {
        $call = KCallRegister::with('custname', 'staffname')->find($id);
        if (!$call) {
            return redirect()->back()->with('error', 'Call not found.');
        }

        $staff = KCallRegister::distinct()->whereNotNull('callallocation')->get(['callallocation']);

        return view('Calls/editcall', compact('call', 'staff'));
    }

    public function updatecall(Request $request, $id)
    {
        $call = KCallRegister::find($id);
        if (!$call) {
            return redirect()->back()->with('error', 'Call not found.');
        }

        $call->status = $request->status;
        $call->remarks = $request->remarks;
        $call->Ncalldate = $request->Ncalldate;
        $call->completeperson = $request->completeperson;
        $call->completeddate = $request->completeddate;
        $call->save();

        return redirect()->route('ledreport')->with('success', 'Call updated successfully.');
    }

}



