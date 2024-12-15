<?php
require('inc/links.php');
require('inc/header.php');
$msg="";
if(isset($_POST['submit']))
{
  $allowedExts = array("gif", "jpeg", "jpg", "png");
    $temp = explode(".", $_FILES['profile']['name']);
    $extension = end($temp);
    if (in_array($extension, $allowedExts))
    {
      $name = rand(10000,99999)."_".$_FILES["profile"]["name"];
      move_uploaded_file($_FILES["profile"]["tmp_name"], "images/users/".$name);
      if(!$name)
      {
        $error="Invalid file type";
      }
      
    
  
  $sql="insert into user_cred(uname,email,address,phonenum,pincode,dob,profile,password,is_verified,status,datentime)values('".$_POST['name']."','".$_POST['email']."'
    ,'".$_POST['address']."','".$_POST['phonenum']."','".$_POST['pincode']."','".$_POST['dob']."','".$name."','".$_POST['pass']."','1','1',curdate())";
    $res=mysqli_query($con,$sql) or die(mysqli_error($con));
    if($res)
    {
      $msg="Registered Successfully.";
    }
} }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link  rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
 
  <title><?php echo $settings_r['site_title'] ?> - REGISTER</title>
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
      <form id="register-form" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title d-flex align-items-center">
            <i class="bi bi-person-lines-fill fs-3 me-2"></i> User Registration
          </h5>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Name</label>
                <input name="name" type="text" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input name="email" type="email" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Phone Number</label>
                <input name="phonenum" type="number" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Picture</label>
                <input name="profile" type="file" accept=".jpg, .jpeg, .png, .webp" class="form-control shadow-none" required>
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control shadow-none" rows="1" required></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Pincode</label>
                <input name="pincode" type="number" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Date of birth</label>
                <input name="dob" type="date" class="form-control shadow-none" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="form-label">Password</label>
                <input name="pass" type="password" class="form-control shadow-none" required>
              </div>
          <div class="text-center my-1">
            <input type="submit" class="btn btn-dark shadow-none" name="submit" value="REGISTER">
          </div>
        </div>
      </form>
</div>
<?php require('inc/footer.php'); ?>
   