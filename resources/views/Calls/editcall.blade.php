<?php
session_start();
if (!isset($_SESSION['name']))
?>
<!DOCTYPE html>

<head>
    <title> Call Register</title>
    <style>
        .css-serial {
            counter-reset: serial-number;
            /* Set the serial number counter to 0 */
        }

        .topnav {
            background-color: #1569C7;
            overflow: hidden;
        }

        /* Style the links inside the navigation bar */
        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        /* Change the color of links on hover */
        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        /* Add a color to the active/current link */
        .topnav a.active {
            background-color: #033E3E;
            color: white;
        }
    </style>
</head>

<body>
    <form class="form" method="POST" name="login" action="{{ route('updatecall', $call->id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="topnav">
            <a href="{{ route('home1') }}">Home Page</a>
            <a href="{{ route('addcall') }}">Call Register</a>
            <a href="{{ route('custReport') }}">Calls Report</a>
            <a href="{{ route('leads') }}">Leads Report</a>
            <a href="{{ route('service') }}">Service Report</a>
            <a href="{{ route('tdl') }}">TDL Report</a>
            <a href="{{ route('tss') }}">TSS Report</a>
            <a href="{{ route('addcust') }}">Add Customer</a>
            <a href="{{ route('logout') }}">LogOut</a>
        </div>
        <h1 align="center"> KALASAM INFO TECH </h1>
        <h2 align="center"> Call Register </h2>
        <table border=1 align="center">
            <tr>
                <td>Company Name</td>
                <td>
                    <select name="cust_id" id="cust_id" cols="25" readonly>
                        <option value="{{ $call->cust_id }}">{{ $call->custname->comname }}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Phone No</td>
                <td><input type="text" id="phoneno" name="phoneno" value="{{ $call->phoneno }}" readonly></td>
            </tr>
            <tr>
                <td>Contact Person</td>
                <td><input type="text" id="conperson" name="conperson" value="{{ $call->conperson }}" readonly></td>
            </tr>
            <tr>
                <td>Work</td>
                <td><input type="text" id="work" name="work" value="{{ $call->work }}" readonly></td>
            </tr>
            <tr>
                <td>Staff name</td>
                <td>
                    <select name="staff_id" id="staff_id" readonly>
                        <option value="{{ $call->staff_id }}">{{ $call->staffname->name }}</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Call Allocation</td>
                <td>
                    <select name="callallocation" id="callallocation" readonly>
                        <option value="{{ $call->callallocation }}">{{ $call->callallocation }}</option>
                        @foreach($staff as $row)
                            <option value="{{ $row->callallocation }}">{{ $row->callallocation }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <select name="status" id="status">
                        <option value="Pending" {{ $call->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ $call->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Remarks</td>
                <td><textarea id="remarks" name="remarks" rows="4" cols="50">{{ $call->remarks }}</textarea></td>
            </tr>
            <tr>
                <td>Serial No</td>
                <td><input type="text" id="serialNo" name="serialNo" value="{{ $call->serialNo }}" readonly></td>
            </tr>
            <tr>
                <td>Call Back Date</td>
                <td><input type="datetime-local" id="Ncalldate" name="Ncalldate" value="{{ $call->Ncalldate }}"></td>
            </tr>
            <tr>
                <td>Bill Type</td>
                <td><input type="text" id="billtype" name="billtype" value="{{ $call->billtype }}" readonly></td>
            </tr>
            <tr>
                <td>Software</td>
                <td><input type="text" id="software" name="software" value="{{ $call->software }}" readonly></td>
            </tr>
            <tr>
                <td>Complete Person</td>
                <td><input type="text" id="completeperson" name="completeperson" value="{{ $call->completeperson }}">
                </td>
            </tr>
            <tr>
                <td>Completed Date</td>
                <td><input type="datetime-local" id="completeddate" name="completeddate"
                        value="{{ $call->completeddate }}"></td>
            </tr>
            <tr>
                <td></td>
                <td align="center"><input type="submit" name="save" value="Save"></td>
            </tr>
        </table>
    </form>
</body>
<script>
    var data = @json($call);
    console.log(data);
</script>

</html>