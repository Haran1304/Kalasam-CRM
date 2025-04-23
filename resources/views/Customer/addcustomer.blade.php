<?php
    session_start();
    if(!isset($_SESSION['name']))
?>
<!DOCTYPE html>
<head>
  <title> Add Customer </title>
  <style>
    .topnav {
  background-color:#306EFF;
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
<form class="form" method="POST" name="login" action="{{route('customer')}}">
{{csrf_field()}}
<div class="topnav">
<a href="{{route('home1')}}">Home Page</a>
 <a href="{{route('addcall')}}">Call Register</a>
 <a href="{{route('custReport')}}">Calls Report</a>
 <a href="{{route('leads')}}">Leads Report</a>
 <a href="{{route('service')}}">Service Report</a>
 <a href="{{route('tdl')}}">TDL Report</a>
 <a href="{{route('tss')}}">TSS Report</a>
 <a class="active" href="{{route('addcust')}}">Add Customer</a>
 <a href="{{route('logout')}}">LogOut</a>
</div>
<h1 align="center"> KALASAM INFO TECH </h1>
<h2 align="center"> Add Customer </h2>
<table border=1 align="center">
  <tr><td>Company Name *</td><td><input type="name" id="comname" name="comname" required></td></tr>
  <tr><td>Contact Person *</td><td><input type="name" id="name" name="name" required></td></tr>
  <tr><td>Phone No *</td><td><input type="name" id="phone" name="phone" required></td></tr>
  <tr><td>Mobile No</td><td><input type="name"  id="mobile" name="mobile"></td></tr>
  <tr><td>Email ID</td><td><input type="name"  id="email" name="email"></td></tr>
  <tr><td>Serial No </td><td><input type="name"  id="serialNo" name="serialNo"></td></tr>
  <tr><td>GST No </td><td><input type="name"  id="gstno" name="gstno"></td></tr>
  <tr><td>Reference Person</td><td><input type="name"  id="refname" name="refname"></td></tr>
  <tr><td>Tally Pack Details</td><td><input type="name"  id="pack" name="pack"></td></tr>
  <tr><td>Bill Type</td><td><select id="billtype" name="billtype">
        <option>Select</option>
        <option value="AMC">AMC</option>
        <option value="NoAMC">No AMC</option> 
</select></td></tr>
<tr><tr><td>Software</td><td><select id="software" name="software">
        <option value="Tally">Tally</option>
        <option value="Busy">Busy</option> 
 </select></td></tr>
  <tr><td><a href="{{route('home1')}}">Home Page</a></td><td align="center"><input type="submit" name="save"></td></tr>
</table>
</form>
</body>
</html>