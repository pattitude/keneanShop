<?php
include "includes/header.php";
require_once "./php/auth.php";


?>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

<script src="assets/jquery.js" ></script>
  <script>
$(document).ready(function(){
      
  $('form').on('submit', function(e){
          e.preventDefault()
          $('form').on('submit', function(){
          $.ajax({
              url: 'login.php',
              type: 'post',
              data: $('form').serialize(),
              success: function(data){
                // alert(data)
              }
          })
          return false;
      })
    })
          

})
  </script>
    <!-- Custom styles for this template -->
    <link href="assets/css/loginstyle.css" rel="stylesheet">

  </head>
  <body class="text-center">
    
<main class="form-signin">
  <form  method="POST" >
    <img class="mb-4" src="/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <div class="form-floating">
      <input type="email" class="form-control" name="username" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email address / Phone Number</label>
    </div>
    <div class="form-floating">
      <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
   <a href="./register.php"><label>Register</label></a>
   <button class="w-50 btn btn-primary mx-auto " type="submit">Continue to checkout</button>
   <?php
   
   //////////////////LOGIN USER //////////////////////////

if(isset($_POST['username'], $_POST['password'])){
  // echo 'in login';
  $us = $_POST['username'];
  $pa = $_POST['password'];
  $check = $auth->loginAuth($us);
  // $check = $auth->loginAuth()
  if($check->num_rows == 0){
      $login = 'Not valid password or Username';
      echo $login;

  }else{
      

      $row = $check->fetch_assoc();
          
         echo password_verify($pa, $row['password']);
          if(password_verify($pa, $row['password'])){
              ob_start();
              session_start();
              $_SESSION['userId'] = $row['id'];
              
              header('Location: index.php');
          }else{
              echo 'password not correct';
          }

      

  }
  
}

   
   ?>

    <!-- <a class="w-100 btn btn-lg btn-primary" type="submit">Sign in</a> -->
    <div id="alertVacancy" ></div>
    <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
  </form>
</main>