<?php
    session_start();
    if(!isset($_SESSION['name']))
?>
<!DOCTYPE html>
<head>
  <title> Add Customer </title>
  <style>
  .css-serial {
       counter-reset: serial-number; /* Set the serial number counter to 0 */
   }
   .topnav {
  background-color: #333;
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
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>
<form method="post" name="calReport" action="{{route('CallsReport')}}">
{{csrf_field()}}
<div class="topnav">
 <a href="{{route('home1')}}">Home Page</a>
 <a href="{{route('addcall')}}">Call Register</a>
 <a class="active" href="{{route('custReport')}}">Calls Report</a>
 <a href="{{route('addcust')}}">Add Customer</a>
 <a href="{{route('logout')}}">LogOut</a>
</div>
<h1 align="center"> KALASAM INFO TECH </h1>
<h2 align="center"> Calls Report </h2>
<label>From Date:</label><input type="date" id="FDate" name="FDate">
<label>To Date:</label><input type="date" id="TDate" name="TDate" >
<label>Customer Name</label><select name="cust_id" id= "cust_id" cols="25">
<option>All</option>
       @foreach($cust as $row)
           <Option value ="{{$row->id}}">{{$row->comname}}
        @endforeach     
</select> 
<label>Customer Phone No</label><select name="phoneno" id= "phoneno" cols="25">
<option>All</option>
        @foreach($phoneno as $row)
           <option value ="{{$row->phoneno}}">{{$row->phoneno}}
        @endforeach        
</select> 
<label> Call Status</label><select name="status" id= "status" cols="25">
         <option>All</option>
         <option value="Pending">Pending</option>
         <option value="Completed">Completed</option>      
</select>
<br/>  <br/>  
<label> Work </label><select name="work" id= "work" cols="25">
         <option>All</option>
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
<label> Bill Type</label><select name="billtype" id= "billtype" cols="25">
        <option>All</option>
        <option value="AMC">AMC</option>
        <option value="Free Support">Free Support</option> 
        <option value="Billing">Billing</option>      
</select>  
<label> Software</label><select name="software" id= "software" cols="25">
        <option>All</option>
        <option value="Tally">Tally</option>
        <option value="Busy">Busy</option>       
</select>  
<input type="submit" name="submit">
<br/><br/>
<table border=1 class="css-serial">
 <tr><th>SNo</th>
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
</tr>
@php
 $i = 1;
@endphp
 @foreach($calls as $row)
 <tr>
 <td>{{$i++}}</td>
 <td>{{$row->Date}}</td>
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
 <td>{{$row->custname->billtype}}</td>
 <td>{{$row->completeperson}}</td>
 <td>{{$row->completeddate}}</td> 
 <td><a href="{{route('editcalls',[$row->id])}}">Edit</a></td>
</tr>
 @endforeach   
</table>
{!! $report->links() !!}
</form>
</body>
</html>