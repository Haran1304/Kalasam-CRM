<?php
session_start();
if (!isset($_SESSION['name']))
?>
<!DOCTYPE html>

<head>
  <title> Add Customer </title>
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

    /* Add a color to the active/current link */
    .topnav a.active {
      background-color: #033E3E;
      color: white;
    }
  </style>
  <script>
    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
      } else {
        alert("Geolocation is not supported by this browser.");
      }
    }

    function showPosition(position) {
      const latitude = position.coords.latitude;
      const longitude = position.coords.longitude;
      document.getElementById("whatsapp_location").value = `${latitude}, ${longitude}`;
    }

    function showError(error) {
      switch (error.code) {
        case error.PERMISSION_DENIED:
          alert("User denied the request for Geolocation.");
          break;
        case error.POSITION_UNAVAILABLE:
          alert("Location information is unavailable.");
          break;
        case error.TIMEOUT:
          alert("The request to get user location timed out.");
          break;
        case error.UNKNOWN_ERROR:
          alert("An unknown error occurred.");
          break;
      }
    }
  </script>
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
      <tr>
        <td>Company Name *</td>
        <td><input type="name" id="comname" name="comname" required></td>
      </tr>
      <tr>
        <td>Contact Person *</td>
        <td><input type="name" id="name" name="name" required></td>
      </tr>
      <tr>
        <td>Phone No *</td>
        <td><input type="name" id="phone" name="phone" required></td>
      </tr>
      <tr>
        <td>Mobile No</td>
        <td><input type="name" id="mobile" name="mobile"></td>
      </tr>
      <tr>
        <td>Email ID</td>
        <td><input type="name" id="email" name="email"></td>
      </tr>
      <tr>
        <td>Serial No </td>
        <td><input type="name" id="serialNo" name="serialNo"></td>
      </tr>
      <tr>
        <td>GST No </td>
        <td><input type="name" id="gstno" name="gstno"></td>
      </tr>
      <tr>
        <td>Reference Person</td>
        <td><input type="name" id="refname" name="refname"></td>
      </tr>
      <tr>
        <td>Tally Pack Details</td>
        <td><input type="name" id="pack" name="pack"></td>
      </tr>
      <tr>
        <td>Bill Type</td>
        <td><select id="billtype" name="billtype">
            <option>Select</option>
            <option value="AMC">AMC</option>
            <option value="NoAMC">No AMC</option>
          </select></td>
      </tr>
      <tr>
        <td>Software</td>
        <td><select id="software" name="software">
            <option value="Tally">Tally</option>
            <option value="Busy">Busy</option>
          </select></td>
      </tr>
      <tr>
        <td>WhatsApp Number</td>
        <td><input type="text" id="whatsapp" name="whatsapp"></td>
      </tr>
      <tr>
        <td>WhatsApp Location</td>
        <td>
          <input type="text" id="whatsapp_location" name="whatsapp_location"
            placeholder="Paste WhatsApp live location link here">

        </td>
      </tr>
      <tr>
        <td>Visiting Card</td>
        <td><input type="file" id="visiting_card" name="visiting_card"></td>
      </tr>
      <tr>
        <td>Owner Number</td>
        <td><input type="text" id="owner_number" name="owner_number"></td>
      </tr>
      <tr>
        <td>Customer Location</td>
        <td><input type="text" id="customer_location" name="customer_location"></td>
      </tr>
      <tr>
        <td>Customer Address</td>
        <td><textarea id="customer_address" name="customer_address"></textarea></td>
      </tr>
      <tr>
        <td>District</td>
        <td><input type="text" id="district" name="district"></td>
      </tr>
      <tr>
        <td>Expiry Date</td>
        <td><input type="date" id="expiry_date" name="expiry_date"></td>
      </tr>
      <tr>
        <td>Auditor Name</td>
        <td><input type="text" id="auditor_name" name="auditor_name"></td>
      </tr>
      <tr>
        <td>Auditor Mobile</td>
        <td><input type="text" id="auditor_mobile" name="auditor_mobile"></td>
      </tr>
      <tr>
        <td>System Engineer Name</td>
        <td><input type="text" id="engineer_name" name="engineer_name"></td>
      </tr>
      <tr>
        <td>System Engineer Mobile</td>
        <td><input type="text" id="engineer_mobile" name="engineer_mobile"></td>
      </tr>
      <tr>
        <td>System Engineer Location</td>
        <td><input type="text" id="engineer_location" name="engineer_location"></td>
      </tr>
      <tr>
        <td><a href="{{route('home1')}}">Home Page</a></td>
        <td align="center"><input type="submit" name="save"></td>
      </tr>
    </table>
  </form>
</body>

</html>