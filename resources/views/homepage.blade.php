<?php
session_start();
if (!isset($_SESSION['name']))
?>
<!DOCTYPE html>
<html>

<head>
  <title>Home Page</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
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
  </style>
</head>

<body>
  <div class="topnav">
    <a class="active" href="{{route('home1')}}">Home Page</a>
    <a href="{{route('addcall')}}">Call Register</a>
    <a href="{{route('ledreport')}}">Customer report</a>
    <a href="{{route('custReport')}}">Calls Report</a>
    <a href="{{route('leads')}}">Leads Report</a>
    <a href="{{route('service')}}">Service Report</a>
    <a href="{{route('tdl')}}">TDL Report</a>
    <a href="{{route('tss')}}">TSS Report</a>
    <a href="{{route('addcust')}}">Add Customer</a>
    <a href="{{route('logout')}}">LogOut</a>
  </div>
  <center>
    <h1 style="color:blue;" align="center">WELCOME TO HOME PAGE</h1>
    <h2>Today Pending Calls</h2>

    <div class="container mt-5">
      <form method="GET" action="{{ route('home1') }}">
        <div class="row mb-3">
          <div class="col">
            <input type="date" class="form-control" name="from_date" value="{{ request('from_date') }}"
              placeholder="From Date">
          </div>
          <div class="col">
            <input type="date" class="form-control" name="to_date" value="{{ request('to_date') }}"
              placeholder="To Date">
          </div>
          <div class="col">
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('home1') }}" class="btn btn-secondary">Reset</a>
          </div>
        </div>
      </form>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>SNo</th>
            <th>Customer Name</th>
            <th>Phone No</th>
            <th>Contact Person</th>
            <th>Call Date</th>
            <th>Bill Type</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php $i = 1; @endphp
          @foreach($callsToday as $call)
        <tr>
        <td>{{ $i++ }}</td>
        <td>{{ $call->custname ? $call->custname->comname : 'N/A' }}</td>
        <td>{{ $call->phoneno }}</td>
        <td>{{ $call->conperson }}</td>
        <td>{{ \Carbon\Carbon::parse($call->call_date)->format('Y-m-d H:i:s') }}</td>
        <td>{{ $call->billtype }}</td>
        <td>{{ $call->status }}</td>
        <td>
          <a class="btn btn-primary"
          href="{{ route('viewhistory', ['cust_id' => $call->cust_id, 'billtype' => $call->billtype]) }}">Details</a>
          <a class="btn btn-success" href="{{ route('editcalls', $call->id) }}">Edit</a>
        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
    </div>
  </center>
</body>

</html>
<script>
  var data = @json($callsToday);
  console.log(data);
</script>