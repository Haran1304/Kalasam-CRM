<?php
session_start();
if (!isset($_SESSION['name']))
?>
<!DOCTYPE html>

<head>
  <title> Calls Report </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
  <center>
    <form class="form container" method="post" name="calReport" action="{{route('ledgerwisereport')}}">
      {{csrf_field()}}
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
      <div class="container mt-5">
        <div class="form-group">
          <h3 class="text-center">LEDGER REPORT</h3>
          <div class="row mb-3">
            <div class="col-md-3">
              <label for="FDate">From Date:</label>
              <input type="date" id="FDate" name="FDate" class="form-control" value="{{$val['FDate']}}">
            </div>
            <div class="col-md-3">
              <label for="TDate">To Date:</label>
              <input type="date" id="TDate" name="TDate" class="form-control" value="{{$val['TDate']}}">
            </div>
            <div class="col-md-3">
              <label for="customer">Customer Name</label>
              <input type="text" id="customer" name="search" placeholder="Search" class="form-control" value="" />
              <input type="hidden" id="abc" name="cust_id" class="form-control" value="" />
            </div>
            <div class="col-md-3">
              <label for="phone">Customer Phone No</label>
              <input type="text" id="phone" name="search" placeholder="Search" class="form-control" value="" />
              <input type="hidden" id="phone1" name="phoneno" class="form-control" value="" />
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-3">
              <label for="status">Call Status</label>
              <select name="status" id="status" class="form-select">
                <option value="{{$val['status']}}">{{$val['status']}}</option>
                <option value="All">All</option>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="work">Work</label>
              <select name="work" id="work" class="form-select">
                <option value="{{$val['work']}}">{{$val['work']}}</option>
                <option value="All">All</option>
                <option value="Tally Support">Tally Support</option>
                <option value="Busy Support">Busy Support</option>
                <option value="Busy Customization">Busy Customization</option>
                <option value="TSS Renewal">TSS Renewal</option>
                <option value="AMC Renewal">AMC Renewal</option>
                <option value="TDL Customization">TDL Customization</option>
                <option value="TDL Support">TDL Support</option>
                <option value="New Project">New Project</option>
                <option value="New Pack">New Pack</option>
                <option value="Tally Conversation">Tally Conversation</option>
                <option value="Release update">Release update</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="billtype">Bill Type</label>
              <select name="billtype" id="billtype" class="form-select">
                <option value="{{$val['billtype']}}">{{$val['billtype']}}</option>
                <option value="All">All</option>
                <option value="AMC">AMC</option>
                <option value="Free Support">Free Support</option>
                <option value="Billing">Billing</option>
                <option value="TSS">TSS</option>
                <option value="TDL">TDL</option>
                <option value="Leads">Leads</option>
              </select>
            </div>
            <div class="col-md-3">
              <label for="callallocation">Call Attend Person</label>
              <select name="callallocation" id="callallocation" class="form-select">
                <option value="{{$val['callallocation']}}">{{$val['callallocation']}}</option>
                @foreach($staff as $row)
          <option value="{{$row->callallocation}}">{{$row->callallocation}}</option>
        @endforeach
              </select>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12 text-center">
              <input type="submit" name="submit" class="btn btn-primary">
            </div>
          </div>
        </div>
        <div class="form-group">
          <table class="table table-bordered css-serial">
            <thead>
              <tr>

                <th>SNo</th>
                <th>Date</th>
                <th>Company Name</th>
                <th>Phone No</th>
                <th>Contact Person</th>
                <th>Work</th>
                <!-- <th>Create by</th>
                <th>Call Allocated Person</th> -->
                <th>Status</th>
                <th>Remarks</th>
                <!-- <th>Serial No</th> -->
                <th>Next Call Date</th>
                <th>Bill Type</th>
                <!-- <th>Completed Person</th>
                <th>Completed Date</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @php
        $i = 1;
      @endphp
              @foreach($calls as $row)
            <tr>

            <td>{{$i++}}</td>
            <td>{{$row->call_date}}</td>
            <td>{{$row->custname->comname}}</td>
            <td>{{$row->phoneno}}</td>
            <td>{{$row->conperson}}</td>
            <td>{{$row->work}}</td>
            <!-- <td>{{$row->staffname->name}}</td>
          <td>{{$row->callallocation}}</td> -->
            <td>{{$row->status}}</td>
            <td>{{$row->remarks}}</td>
            <!-- <td>{{$row->custname->serialNo}}</td> -->
            <td>{{$row->Ncalldate}}</td>
            <td>{{$row->billtype}}</td>
            <!-- <td>{{$row->completeperson}}</td>
          <td>{{$row->completeddate}}</td> -->
            <td>
              <a class="btn btn-primary" href="{{ route('editcall', $row->id) }}">Edit</a>
              <a class="btn btn-primary"
              href="{{ route('viewhistory', ['cust_id' => $row->cust_id, 'billtype' => $row->billtype]) }}">Details</a>
            </td>
            </tr>
        @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </form>
  </center>
</body>

</html>
<script>
  $(document).ready(function () {
    $(".pagination_div").click(function () {
      var divValue = $(this).text();
      $('#pageno').val(divValue)
      $("#mysubmit").click();
    });
    $(".mycheckbox").click(function () {
      $("#mysubmit").click();
    });
  });
</script>