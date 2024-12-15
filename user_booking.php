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
      
        <h3 class="mb-4">ALL BOOKINGS</h3>

        <div class="card border-0 shadow-sm mb-4">
          <div class="card-body">

           
            <div class="table-responsive">
              <table class="table table-hover border" style="min-width: 1200px;">
                <thead>
                  <tr class="bg-dark text-light">
                    <th scope="col">Order ID</th>
                    <th scope="col">User Details</th>
                    <th scope="col">Room Details</th>
                    <th scope="col">Check In</th>
                    <th scope="col">Check Out</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total Amount & GST</th>
                    <th scope="col">Net Amount</th>
                    <th scope="col">Booked Date</th>
                    <th scope="col">PDF</th>
                    <th scope="col">Action</th>
                    
                  </tr>
                </thead>
                <tbody>      
                    <?php 
                          $i=1;
                          $sql="select * from rooms as r INNER JOIN booking_order as b ON r.id=b.room_id 
                          INNER JOIN user_cred as u ON b.user_id=u.id where b.user_id='".$_SESSION['uId']."'  ";
                          $res = mysqli_query($con,$sql);
                          while($row=mysqli_fetch_array($res)) {

                    ?>   
                    <tr>
                        <td><span class="btn btn-primary"><?php echo $row['order_id'];?></span></td>
                        <td><?php echo $row['uname'];?> <?php echo $row['email'];?> <br> <?php echo $row['phonenum'];?></td>
                         <td><?php echo $row['name'];?></td>
                         <td><?php echo $row['check_in'];?></td>
                         <td><?php echo $row['check_out'];?></td>
                        <td> <?php echo $row['price'];?> Rs</td>
                         <td> <?php echo $row['trans_amt'];?> & <?php echo $row['gst'];?> Rs 18%</td>
                        <td> <?php echo $row['final_amt'];?> Rs </td>
                        <td> <?php echo $row['datentime'];?></td>
                        <td><a href="admin/generate_pdf.php?id=<?php echo $row['booking_id'];?>" target="_blank" class="badge badge-warning" style="background: orange;">Generate PDF</a></td>

                        <td> 

                          <?php if($row['booking_status'] == 'confirmed') { ?>
                          <span class="badge badge-warning" style="background: green;">Booked</span>
                        <?php } elseif($row['booking_status'] == 'cancelled') { ?> <span class="badge badge-warning" style="background: red;">Cancelled</span><?php } else { ?>
 <span class="badge badge-warning" style="background: orange;">Waiting to Confrim</span>
                          <?php } ?>                        </td>
                    </tr>  
                    <?php $i++; } ?>      
                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

 
  


   <?php require('inc/footer.php'); ?>
</body>
</html>