<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('inc/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> - BOOKINGS</title>
</head>
<body class="bg-light">

  <?php 
    require('inc/header.php'); 

    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
      redirect('index.php');
    }
  ?>

  <div class="container" id="main-content">
    <div class="row">
      
        <h3 class="mb-4">Payment Status</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

           
            
        <div class="alert alert-success"><strong>Payment Paid Successfully...</strong></div>
        <a href="user_booking.php" class="btn btn-primary">VIEW BOOKINGS</a>

          </div>
        </div>

      </div>
    </div>
  </div>

 
  


   <?php require('inc/footer.php'); ?>
</body>
</html>