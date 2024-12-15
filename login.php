<?php
ob_start();
require('inc/links.php');
require('inc/header.php');
$msg="";
if(isset($_POST['signup']))
{
  $check = "SELECT * FROM user_cred where email='".$_POST['email_mob']."' OR phonenum='".$_POST['email_mob']."'  AND password='".$_POST['pass']."'";
  $login = mysqli_query($con,$check) or die(mysqli_error($con));
  $res =  mysqli_fetch_array($login);  
  if($res)
  {
  session_start();
  $_SESSION['login'] = true;
  $_SESSION['uId'] = $res['id'];
  $_SESSION['uName'] = $res['uname'];
  $_SESSION['uPic'] = $res['profile'];
  $_SESSION['uPhone'] = $res['phonenum'];

    header("Location:index.php");
    
  }
  else
  { 
    $msg="Invalid Username or Password";
  }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link  rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
 
  <title><?php echo $settings_r['site_title'] ?> - LOGIN</title>
  <style>
    .availability-form{
      margin-top: -50px;
      z-index: 2;
      position: relative;
    }

    @media screen and (max-width: 575px) {
      .availability-form{
        margin-top: 25px;
        padding: 0 35px;
      } 
    }
  </style>
</head>
<body class="bg-light">

 
  <div class="container">
    <?php 
    if($msg) { ?>
    <div class="alert alert-success"><strong>
    <?php echo $msg;  ?></strong></div> <?php } ?>
   <form id="login-form" method="post">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-person-circle fs-3 me-2"></i> User Login
          </h5>
         
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Email / Mobile</label>
            <input type="text" name="email_mob" required class="form-control shadow-none">
          </div>
          <div class="mb-4">
            <label class="form-label">Password</label>
            <input type="password" name="pass" required class="form-control shadow-none">
          </div>
          <div class="d-flex align-items-center justify-content-between mb-2">
            <input type="submit" class="btn btn-dark shadow-none" value="LOGIN" name="signup">
            <!--<button type="button" class="btn text-secondary text-decoration-none shadow-none p-0" data-bs-toggle="modal" data-bs-target="#forgotModal" data-bs-dismiss="modal">
              Forgot Password?
            </button>-->
          </div>
        </div>
      </form>
</div>
<?php require('inc/footer.php'); ?>
   