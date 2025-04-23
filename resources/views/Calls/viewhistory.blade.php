<?php
session_start();
if (!isset($_SESSION['name']))
?>
<!DOCTYPE html>

<head>
    <title> Calls History </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .topnav {
            background-color: #306EFF;
            overflow: hidden;
        }

        .topnav a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            font-size: 17px;
        }

        .topnav a:hover {
            background-color: #ddd;
            color: black;
        }

        .topnav a.active {
            background-color: #033E3E;
            color: white;
        }

        .container {
            max-width: 1900px;
        }
    </style>
</head>

<body>
    <form class="form" method="post" name="calReport" action="{{route('CallsReport')}}">
        {{csrf_field()}}
        <div class="topnav">
            <a href="{{route('home1')}}">Home Page</a>
            <a href="{{route('addcall')}}">Call Register</a>
            <a class="active" href="{{route('ledreport')}}">Customer report</a>
            <a href="{{route('custReport')}}">Calls Report</a>
            <a href="{{route('leads')}}">Leads Report</a>
            <a href="{{route('service')}}">Service Report</a>
            <a href="{{route('tdl')}}">TDL Report</a>
            <a href="{{route('tss')}}">TSS Report</a>
            <a href="{{route('addcust')}}">Add Customer</a>
            <a href="{{route('logout')}}">LogOut</a>
        </div>

        <div class="container mt-5">
            <h1>Call History for {{ $customer->comname }}</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>SNo</th>
                        <!-- <th>Date</th> -->
                        <th>Company Name</th>
                        <th>Phone No</th>
                        <th>Contact Person</th>
                        <th>Call Date</th>
                        <th>Work</th>
                        <th>Call Allocated Person</th>

                        <th>Serial No</th>
                        <th>Next Call Date</th>
                        <th>Bill Type</th>
                        <th>Status</th>
                        <th>Completed Person</th>
                        <th>Completed Date</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach($calls as $call)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $customer->comname }}</td>
                            <td>{{ $call->phoneno }}</td>
                            <td>{{ $call->conperson }}</td>
                            <td>{{ $call->call_date }}</td>
                            <td>{{ $call->work }}</td>
                            <td>{{ $call->callallocation }}</td>
                            <td>{{ $call->serialNo }}</td>
                            <td>{{ $call->Ncalldate }}</td>
                            <td>{{ $call->billtype }}</td>
                            <td>{{ $call->status }}</td>
                            <td>{{ $call->completeddate ? $call->completeddate : 'N/A'}}</td>
                            <td>{{ $call->completeperson ? $call->completeperson : 'N/A' }}</td>
                            <td>{{ $call->remarks }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <a href="{{ route('ledreport') }}" class="btn btn-primary">Back to Report</a>
        </div>
</body>


</html>