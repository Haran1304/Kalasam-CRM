<?php
session_start();
if (!isset($_SESSION['name']))
?>
<!DOCTYPE html>

<head>
  <title> Call Register</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" /> -->
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <style>
    .topnav {
      background-color: #306EFF;
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

    .topnav a.active {
      background-color: #033E3E;
      color: white;
    }

    .container {
      max-width: 600px;
    }
  </style>
</head>

<body>
  <form class="form" method="POST" name="login" action="{{route('callRegister')}}" id="callRegisterForm">
    {{csrf_field()}}
    <div class="topnav">
      <a href="{{route('home1')}}">Home Page</a>
      <a class="active" href="{{route('addcall')}}">Call Register</a>
      <a href="{{route('custReport')}}">Calls Report</a>
      <a href="{{route('leads')}}">Leads Report</a>
      <a href="{{route('service')}}">Service Report</a>
      <a href="{{route('tdl')}}">TDL Report</a>
      <a href="{{route('tss')}}">TSS Report</a>
      <a href="{{route('addcust')}}">Add Customer</a>
      <a href="{{route('logout')}}">LogOut</a>
    </div>
    <div classs="form-group">
      <h3 align="center">CALL REGISTER </h3>
    </div>
    <table border=1 align="center">
      <div class="container mt-5">
        <!-- <tr><td>Date</td><td><input type="date" id="Date" name="Date"></td></tr> -->
        <div classs="form-group">
          <tr>
            <td>Company Name *</td>
            <td><input type="text" id="customer" name="search" placeholder="Search" class="form-control" value="" />
              <input type="hidden" id="abc" name="cust_id" placeholder="Search" class="form-control" value="" />
              <a href="{{route('addcust')}}">Add Customer</a>
            </td>
          </tr>
        </div>

        <div classs="form-group">
          <tr>
            <td>Phone No *</td>
            <td><input type="name" id="phoneno" name="phoneno" required></td>
            </td>
          </tr>
        </div>
        <div classs=" form-group">
          <tr>
            <td>Contact Person *</td>
            <td><input type="name" id="conperson" name="conperson" required></td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Work</td>
            <td><select id="work" name="work">
                <option value="Tally Support">Tally Support</option>
                <option value="TSS Renewal">TSS Renewal</option>
                <option value="AMC Renewal">AMC Renewal</option>
                <option value="TDL Customization">TDL Customization</option>
                <option value="TDL Demo">TDL Demo</option>
                <option value="TDL Support">TDL Support</option>
                <option value="New Project">New Project </option>
                <option value="New Pack">New Pack</option>
                <option value="Tally Conversation">Tally Conversation</option>
                <option value="Release update">Release update</option>
                <option value="Busy Support">Busy Support</option>
                <option value="Busy Customization">Busy Customization</option>
              </select>
            </td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Staff name</td>
            <td><select name="staff_id" id="staff_id">
                <option value="{{$data->id}}">{{$data->name}}
              </select>
            </td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Call Allocation *</td>
            <td><select name="callallocation" id="callallocation" required>
                @foreach($data1 as $row)
          <Option value="{{$row->id}}">{{$row->name}}
          @endforeach
              </select>
            </td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Status</td>
            </td>
            <td><select name="status" id="status">
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
              </select>
            </td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Remarks *</td>
            <td><textarea id="remarks" name="remarks" rows="4" cols="50" required></textarea></td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>SerialNo</td>
            <td><input type="name" id="serialNo" name="serialNo" rows="4" cols="50"></textarea></td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Call Back Date</td>
            <td><input type="datetime-local" id="date" name="Ncalldate" name="Ncalldate"></textarea></td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Bill Type</td>
            <td><select id="billtype" name="billtype">
                <option value="AMC">AMC</option>
                <option value="Free Support">Free Support</option>
                <option value="Billing">Billing</option>
                <option value="TSS">TSS</option>
                <option value="Leads">Leads</option>
                <option value="TDL">TDL</option>
              </select></td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Completeperson</td>
            <td><input type="name" id="completeperson" name="completeperson"></td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td>Completeddate</td>
            <td><input type="datetime-local" id="completeddate" name="completeddate"></td>
          </tr>
        </div>
        <div classs="form-group">
          <tr>
            <td></td>
            <td><input type="submit" name="save"></td>
          </tr>
        </div>
      </div>
    </table>
  </form>
</body>

</html>
<script type="text/javascript">
  $(document).ready(function () {
    var cname = @json($cust);
    console.log(cname);

    $('#customer').autocomplete({
      source: cname,
      select: function (event, ui) {
        $('#customer').val(ui.item.label);
        $('#abc').val(ui.item.values);
        $('#phoneno').val(ui.item.mobile);
        $('#conperson').val(ui.item.contactperson);
        console.log(ui.item.values);

        return false;
      }
    });

    // Add event listener to the form to reload the page after submission
    $('#callRegisterForm').on('submit', function (e) {
      e.preventDefault(); // Prevent the default form submission
      var form = $(this);
      $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (response) {
          // Handle the response here
          console.log(response);
          location.reload(); // Reload the page after successful submission
        },
        error: function (error) {
          // Handle the error here
          console.log(error);
        }
      });
    });
  });
</script>