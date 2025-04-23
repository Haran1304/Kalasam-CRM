<?php
session_start();
if (isset($_SESSION['name']))
  header('location:homepage.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      font-family: sans-serif;
      background: -webkit-linear-gradient(to right, #155799, #159957);
      background: linear-gradient(to right, #155799, #159957);
      color: whitesmoke;
    }

    h1 {
      text-align: center;
    }

    form {
      width: 35rem;
      margin: auto;
      color: whitesmoke;
      backdrop-filter: blur(16px) saturate(180%);
      -webkit-backdrop-filter: blur(16px) saturate(180%);
      background-color: rgba(11, 15, 13, 0.582);
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.125);
      padding: 20px 25px;
    }

    input[type=text],
    input[type=password] {
      width: 100%;
      margin: 10px 0;
      border-radius: 5px;
      padding: 15px 18px;
      box-sizing: border-box;
    }

    button {
      background-color: #030804;
      color: white;
      padding: 14px 20px;
      border-radius: 5px;
      margin: 7px 0;
      width: 100%;
      font-size: 18px;
    }

    button:hover {
      opacity: 0.6;
      cursor: pointer;
    }

    .headingsContainer {
      text-align: center;
    }

    .headingsContainer p {
      color: gray;
    }

    .mainContainer {
      padding: 16px;
    }

    .subcontainer {
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: space-between;
    }

    .subcontainer a {
      font-size: 16px;
      margin-bottom: 12px;
    }

    span.forgotpsd a {
      float: right;
      color: whitesmoke;
      padding-top: 16px;
    }

    .forgotpsd a {
      color: rgb(74, 146, 235);
    }

    .forgotpsd a:link {
      text-decoration: none;
    }

    .register {
      color: white;
      text-align: center;
    }

    .register a {
      color: rgb(74, 146, 235);
    }

    .register a:link {
      text-decoration: none;
    }

    /* Media queries for the responsiveness of the page */
  </style>
</head>

<body>
  <h1>Kalasam Info Tech</h1>
  @if(Session::has('success'))
    <div class="alert-success">{{Session::get('success')}}</div>
  @endif
  @if(Session::has('fail'))
    <div class="alert-danger">{{Session::get('fail')}}</div>
  @endif
  <form method="POST" action="{{route('home')}}">
    {{csrf_field()}}
    <div class="headingsContainer">
      <h3>Sign in</h3>
      <p>Sign in with your username and password</p>
    </div>

    <!-- Main container for all inputs -->
    <div class="mainContainer">
      <!-- Username -->
      <label for="username">Your username</label>
      <input type="text" placeholder="Enter Username" name="name" required>
      <br>
      <!-- Password -->
      <label for="pswrd">Your password</label>
      <input type="password" placeholder="Enter Password" name="password" required>
      <br>
      <!-- Submit button -->
      <button type="submit">Login</button>
      <!-- Sign up link -->
      <p class="register">Not a member? <a href="{{route('register')}}">Register here!</a></p>

    </div>

  </form>
</body>

</html>