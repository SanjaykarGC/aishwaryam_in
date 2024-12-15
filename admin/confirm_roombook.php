<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link  rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  <?php require('inc/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> - HOME</title>
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

<body>
 
  <?php 
  ob_start();
  require('inc/essentials.php');
  require('inc/db_config.php');
  adminLogin();
    require('inc/header.php'); 
  if(isset($_GET['id']))
  {
    
      $sql = "update booking_order set booking_status='confirmed' where booking_id='".$_GET['id']."'";
      $res = mysqli_query($con,$sql) or die(mysqli_error($con));
      if($res)
      {
        header("Location:all_record.php");
      }
  }

ob_end_flush();

  ?>

</body>