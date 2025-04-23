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
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
    /* body {
        font-family: Helvetica, sans-serif;
      } */
    .topnav {
      background-color: #306EFF;
      /*#1569C7,#151B54 */
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
      /*#04AA6D;*/
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
      <a class="active" href="{{route('custReport')}}">Calls Report</a>
      <a href="{{route('leads')}}">Leads Report</a>
      <a href="{{route('service')}}">Service Report</a>
      <a href="{{route('tdl')}}">TDL Report</a>
      <a href="{{route('tss')}}">TSS Report</a>
      <a href="{{route('addcust')}}">Add Customer</a>
      <a href="{{route('logout')}}">LogOut</a>
    </div>
    <div class="container mt-5">
      <div classs="form-group">
        <h3 align="center"> CALL REPORT </h3>
        <label>From Date:</label><input type="date" id="FDate" name="FDate" value="{{$val['FDate']}}">
        <label>To Date:</label><input type="date" id="TDate" name="TDate" value="{{$val['TDate']}}">
        <label>Customer Name</label><input type="text" id="customer" name="search" placeholder="Search"
          class="form-control" value="" />
        <input type="hidden" id="abc" name="cust_id" placeholder="Search" class="form-control" value="" />

        <script type="text/javascript">
          $(document).ready(function () {
            var cname = @json($cust);
            $('#customer').autocomplete({
              source: cname, // URL to fetch suggestions
              minLength: 1, // Minimum characters required before autocomplete starts
              select: function (event, ui) {
                // Handle the selected item (ui.item.value)
                console.log(ui, "All");
                $('#abc').val(ui.item.values);

              }
            });
          });
        </script>
        <label>Customer Phone No</label><input type="text" id="phone" name="search" placeholder="Search"
          class="form-control" value="" />
        <input type="hidden" id="phone1" name="phoneno" placeholder="Search" class="form-control" value="" />
        <script type="text/javascript">
          $(document).ready(function () {
            var phne = @json($phoneno);
            $('#phone').autocomplete({
              source: phne, // URL to fetch suggestions
              minLength: 1, // Minimum characters required before autocomplete starts
              select: function (event, ui) {
                // Handle the selected item (ui.item.value)
                console.log(ui, "All");
                $('#phone1').val(ui.item.values);
              }
            });
          });
        </script>
        <label> Call Status</label><select name="status" id="status" cols="25">
          <option value="{{$val['status']}}">{{$val['status']}}</option>
          <option value="All">All</option>
          <option value="Pending">Pending</option>
          <option value="Completed">Completed</option>
        </select>
      </div>
    </div class="form-group">
    <label> Work </label><select name="work" id="work" cols="25">
      <option value="{{$val['work']}}">{{$val['work']}}</option>
      <option value="All">All</option>
      <option value="Tally Support">Tally Support</option>
      <option value="Busy Support">Busy Support</option>
      <option value="Busy Customization">Busy Customization</option>
      <option value="TSS Renewal">TSS Renewal</option>
      <option value="AMC Renewal">AMC Renewal</option>
      <option value="TDL Customization">TDL Customization</option>
      <option value="TDL Support">TDL Support</option>
      <option value="New Project">New Project </option>
      <option value="New Pack">New Pack</option>
      <option value="Tally Conversation">Tally Conversation</option>
      <option value="Release update">Release update</option>
    </select>
    <label> Bill Type</label><select name="billtype" id="billtype" cols="25">
      <option value="{{$val['billtype']}}">{{$val['billtype']}}</option>
      <option value="All">All</option>
      <option value="AMC">AMC</option>
      <option value="Free Support">Free Support</option>
      <option value="Billing">Billing</option>
      <option value="TSS">TSS</option>
      <option value="TDL">TDL</option>
      <option value="Leads">Leads</option>
    </select>
    <label> Call Attend Person </label><select name="callallocation" id="callallocation" cols="25">
      <option value="{{$val['callallocation']}}">{{$val['callallocation']}}</option>
      @foreach($staff as $row)
      <option value="{{$row->callallocation}}">{{$row->callallocation}}
  @endforeach
    </select>
    </select>
    <input type="submit" name="submit">
    </div>
    <div class="form-group">
      <table border=1 class="css-serial">
        <tr>
          <th>Action</th>
          <th>SNo</th>
          <th>Date</th>
          <th>Company Name</th>
          <th>Phone No</th>
          <th>Contact Person</th>
          <th>Work</th>
          <th>Create by</th>
          <th>Call Allocated Person</th>
          <th>Status</th>
          <th>Remarks</th>
          <th>Serial No</th>
          <th>Next Call Date</th>
          <th>Bill Type</th>
          <th>Completed Person</th>
          <th>Completed Date</th>
          <th>Action</th>
          <th>Action</th>
          <th>Action</th>
        </tr>
        @php
      $i = 1;
    @endphp
        @foreach($calls as $row)
      <tr>
        <td>
        <input type="checkbox" id="checkbox" name="checkboxval[]" value='{{$row->id}}'>
        </td>
        <td>{{$i++}}</td>
        <td>{{$row->call_date}}</td>
        <td>{{$row->custname->comname}}</td>
        <td>{{$row->phoneno}}</td>
        <td>{{$row->conperson}}</td>
        <td>{{$row->work}}</td>
        <td>{{$row->staffname->name}}</td>
        <td>{{$row->callallocation}}</td>
        <td>{{$row->status}}</td>
        <td>{{$row->remarks}}</td>
        <td>{{$row->custname->serialNo}}</td>
        <td>{{$row->Ncalldate}}</td>
        <td>{{$row->billtype}}</td>
        <td>{{$row->completeperson}}</td>
        <td>{{$row->completeddate}}</td>
        <td><a href="{{route('editcalls', [$row->id])}}">Edit</a></td>
        <td><a href="{{route('alter', [$row->id])}}">Update</a></td>
        <td><a href="{{route('delete', [$row->id])}}">Delete</a></td>
      </tr>
    @endforeach
      </table>
  </form>
</body>

</html>
<script>
  $(document).ready(function () {
    // Add a click event listener to all elements with the class "my-div"
    $(".pagination_div").click(function () {
      // Get the text content of the clicked div
      var divValue = $(this).text();
      $('#pageno').val(divValue)
      $("#mysubmit").click();
    });
    $(".mycheckbox").click(function () {
      $("#mysubmit").click();
    });
  });




</script>

<script>
  console.log(@json($data), "All Calls");
</script>