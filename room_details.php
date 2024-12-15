<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require('inc/links.php'); ?>
  <title><?php echo $settings_r['site_title'] ?> - ROOM DETAILS</title>
      <script src="js.js" type="text/javascript"></script>

</head>
<body class="bg-light">

  <?php require('inc/header.php'); ?>

  <?php 
    if(!isset($_GET['id'])){
      redirect('rooms.php');
    }

    $data = filteration($_GET);

    $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?",[$data['id'],1,0],'iii');

    if(mysqli_num_rows($room_res)==0){
      redirect('rooms.php');
    }

    $room_data = mysqli_fetch_assoc($room_res);
  ?>



  <div class="container">
    <div class="row">

      <div class="col-12 my-5 mb-4 px-4">
        <h2 class="fw-bold"><?php echo $room_data['name'] ?></h2>
        <div style="font-size: 14px;">
          <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
          <span class="text-secondary"> > </span>
          <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
        </div>
      </div>

      <div class="col-lg-7 col-md-12 px-4">
        <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php 

              $room_img = ROOMS_IMG_PATH."thumbnail.jpg";
              $img_q = mysqli_query($con,"SELECT * FROM `room_images` 
                WHERE `room_id`='$room_data[id]'");

              if(mysqli_num_rows($img_q)>0)
              {
                $active_class = 'active';

                while($img_res = mysqli_fetch_assoc($img_q))
                {
                  echo"
                    <div class='carousel-item $active_class'>
                      <img src='".ROOMS_IMG_PATH.$img_res['image']."' class='d-block w-100 rounded'>
                    </div>
                  ";
                  $active_class='';
                }

              }
              else{
                echo"<div class='carousel-item active'>
                  <img src='$room_img' class='d-block w-100'>
                </div>";
              }

            ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>

      </div>

      <div class="col-lg-5 col-md-12 px-4">
        <div class="card mb-4 border-0 shadow-sm rounded-3">
          <div class="card-body">
            <?php 

              echo<<<price
                <h4>₹$room_data[price] per night</h4>
              price;

              $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review`
                WHERE `room_id`='$room_data[id]' ORDER BY `sr_no` DESC LIMIT 20";
  
              $rating_res = mysqli_query($con,$rating_q);
              $rating_fetch = mysqli_fetch_assoc($rating_res);
    
              $rating_data = "";
    
              if($rating_fetch['avg_rating']!=NULL)
              {
                for($i=0; $i < $rating_fetch['avg_rating']; $i++){
                  $rating_data .="<i class='bi bi-star-fill text-warning'></i> ";
                }
              }

              echo<<<rating
                <div class="mb-3">
                  $rating_data
                </div>
              rating;

              $fea_q = mysqli_query($con,"SELECT f.name FROM `features` f 
                INNER JOIN `room_features` rfea ON f.id = rfea.features_id 
                WHERE rfea.room_id = '$room_data[id]'");

              $features_data = "";
              while($fea_row = mysqli_fetch_assoc($fea_q)){
                $features_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                  $fea_row[name]
                </span>";
              }

              echo<<<features
                <div class="mb-3">
                  <h6 class="mb-1">Features</h6>
                  $features_data
                </div>
              features;

              $fac_q = mysqli_query($con,"SELECT f.name FROM `facilities` f 
                INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id 
                WHERE rfac.room_id = '$room_data[id]'");

              $facilities_data = "";
              while($fac_row = mysqli_fetch_assoc($fac_q)){
                $facilities_data .="<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                  $fac_row[name]
                </span>";
              }
              
              echo<<<facilities
                <div class="mb-3">
                  <h6 class="mb-1">Facilities</h6>
                  $facilities_data
                </div>
              facilities;

              echo<<<guests
                <div class="mb-3">
                  <h6 class="mb-1">Guests</h6>
                  <span class="badge rounded-pill bg-light text-dark text-wrap">
                    $room_data[adult] Adults
                  </span>
                  <span class="badge rounded-pill bg-light text-dark text-wrap">
                    $room_data[children] Children
                  </span>
                </div>
              guests;

              echo<<<area
                <div class="mb-3">
                  <h6 class="mb-1">Area</h6>
                  <span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                    $room_data[area] sq. ft.
                  </span>
                </div>
              area;

              if(!$settings_r['shutdown']){
                $login=0;
                if(isset($_SESSION['login']) && $_SESSION['login']==true){
                  $login=1;
                }
                echo<<<book
                  <button onclick='checkLoginToBook($login,$room_data[id])' class="btn w-100 text-white custom-bg shadow-none mb-1">Book Now</button>
                book;
              }

            ?>
          </div>
        </div>
      </div>
<div class="col-12 mt-4 px-4">
        <div class="mb-5">
          <h5>Description</h5>
          <p>
            <?php echo $room_data['description'] ?>
          </p>
        </div>

        </div>
<?php

if(isset($_SESSION['uId']))
  {
  $seee="select * from user_cred where id='".$_SESSION['uId']."'";
  $chhhh=mysqli_query($con,$seee);
  $rwwww=mysqli_fetch_array($chhhh);
    if(isset($_POST['feedb'])){
    $ins="insert into comment(user_id,room_id,rating,comment,date)
    values('".$_SESSION['uId']."','".$_GET['id']."','','".$_POST['feed']."',curdate())";
    $dele=mysqli_query($con,$ins) or die(mysqli_error($con));
    if($dele)
    {
      $msg="Successfully Posted Your feedback";
    }
    } ?>
  <div class="container" style="margin-top:100px; text-align:justify;">
    


  
    <div class="view-comment">
    <div class="pull-right">
    <?php
    if(isset($_GET['id']))
    {
    $sql="select AVG(rating) from comment where room_id='".$_GET['id']."'" ;
    $res=mysqli_query($con,$sql);
    while($row=mysqli_fetch_array($res))
    {
    $rate=$row['AVG(rating)'];
    echo "<div style='color:#000;'><b>Average Rating: ".$row['AVG(rating)']."</b></div>";
    
    }
    if(isset($_GET['id'])&&!empty($rate))
    {
      $sql="UPDATE rating set rating='$rate' where room_id='".$_GET['id']."'";
      $rat=mysqli_query($con,$sql);
      
    }
    else
    {
      $sql11="insert into rating(room_id,rating) values('".$_GET['id']."','$rate') ";
      $res12=mysqli_query($con,$sql11) or die(mysqli_error($con)); 
    }
    }
    ?>
    </div>
          <?php
            $coun="select COUNT(comment) from comment where room_id='".$_GET['id']."'";
            $coun1=mysqli_query($con,$coun) or die(mysqli_error($con));
            while($coun2=mysqli_fetch_array($coun1))
            {
              echo "<h3 class='heading' style='text-align:left;padding-left:30px;padding-bottom:30px;color:#000;'>".$coun2['COUNT(comment)']."&nbspFeedBack</h3>";
            }
    
?>
    <script src="js.js" type="text/javascript"></script>
    <style>
    
      .demo-table {width: 100%;border-spacing: initial;margin: 20px 0px;word-break: break-word;table-layout: auto;line-height:1.8em;color:#333;}
      .demo-table th {background: #999;padding: 5px;text-align: left;color:#FFF;}
      .demo-table td {border-bottom: #f0f0f0 1px solid;background-color: #ffffff;padding: 5px;}
      .demo-table td div.feed_title{text-decoration: none;color:#00d4ff;font-weight:bold;}
      .demo-table ul{margin:0;padding:0;}
      .demo-table li{cursor:pointer;list-style-type: none;display: inline-block;color: #F0F0F0;text-shadow: 0 0 1px #666666;font-size:20px;}
      .demo-table .highlight, .demo-table .selected {color:#F4B30A;text-shadow: 0 0 1px #F48F0A;}
    </style>
      <script>function highlightStar(obj,id) {
        removeHighlight(id);    
        $('.demo-table #tutorial-'+id+' li').each(function(index) {
          $(this).addClass('highlight');
          if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
            return false; 
          }
        });
      }

      function removeHighlight(id) {
        $('.demo-table #tutorial-'+id+' li').removeClass('selected');
        $('.demo-table #tutorial-'+id+' li').removeClass('highlight');
      }

      function addRating(obj,id) {
        $('.demo-table #tutorial-'+id+' li').each(function(index) {
          $(this).addClass('selected');
          $('#tutorial-'+id+' #rating').val((index+1));
          if(index == $('.demo-table #tutorial-'+id+' li').index(obj)) {
            return false; 
          }
        });
        $.ajax({
        url: "add_rating.php",
        data:'id='+id+'&rating='+$('#tutorial-'+id+' #rating').val(),
        type: "POST"
        });
      }

      function resetRating(id) {
        if($('#tutorial-'+id+' #rating').val() != 0) {
          $('.demo-table #tutorial-'+id+' li').each(function(index) {
            $(this).addClass('selected');
            if((index+1) == $('#tutorial-'+id+' #rating').val()) {
              return false; 
            }
          });
        } 
      } </script>

    <div class="row demo-table" >
      <?php
      $commnent="select * from comment as c INNER JOIN user_cred as u ON c.user_id=u.id where c.room_id='".$_GET['id']."'";
                $ucom=mysqli_query($con,$commnent);
                while($fet=mysqli_fetch_array($ucom))
        {?>
        <div class="col-md-2">
      
        <img src="images/users/<?php echo $fet['profile'];?>" class="img-circle" >
      
        </div>
        <div class="col-md-10" style="background:#fff; padding:20px;border-radius:10px;margin-bottom:30px;">
          <div class="pull-left" style="color: #39F; font: bold 15px Georgia; padding-bottom: 15px;">
            Username: <?php echo $fet['uname'];?>
            <div id="tutorial-<?php echo $fet["rating_id"]; ?>">
              <input type="hidden" name="rating" id="rating" value="<?php echo $fet["rating"]; ?>" />
              <ul onMouseOut="resetRating(<?php echo $fet["rating_id"]; ?>);">
                <?php
                for($i=1;$i<=5;$i++) {
                $selected = "";
                if(!empty($fet["rating"]) && $i<=$fet["rating"]) {
                $selected = "selected";
                }
                ?>
                <li class='<?php echo $selected; ?>' onmouseover="highlightStar(this,<?php echo $fet["rating_id"]; ?>);" 
                onmouseout="removeHighlight(<?php echo $fet["rating_id"]; ?>);" 
                onClick="addRating(this,<?php echo $fet["rating_id"]; ?>);">&#9733;</li>  
              <?php }  ?>
              <ul>
            </div>
          </div>
          <div class="pull-right" style="color: #39F; font: bold 15px Georgia; padding-bottom: 15px;" >
            Posted on: <?php echo $fet['date']; 
            ?>
            
          </div>
          <div style="clear:both;"></div>
        
        
          <div style="text-align:left;"><?php echo $fet['comment'];?></div>
      
        </div>
      
          <div style="clear:both;"></div>
        <?php } ?>
        
    </div>
      <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data" style="margin-top:20px;    padding-left: 20px;">
        <div class="form-group">
          <label class="control-label col-sm-2">Post Your FeedBack</label>
          <div class="col-sm-10">
            <textarea  class="form-control" name="feed" style="height:200px;"></textarea>
          </div>
        </div><br>
        <div class="form-group"> 
          <div class="col-sm-offset-2 col-sm-10" style="text-align:right;">
            <input type="submit" class="btn btn-success" value="Post Your Feedback" name="feedb">
          </div>
        </div>
      </form>
  </div>
</div>

  <?php }
  
  
?>

</html>
<script type = "text/javascript">
    $(function () {
        $(document).keydown(function (e) {
            return (e.which || e.keyCode) != 116;
        });
    });
</script>
<script>
 if (document.layers) {
    //Capture the MouseDown event.
    document.captureEvents(Event.MOUSEDOWN);
 
    //Disable the OnMouseDown event handler.
    document.onmousedown = function () {
        return false;
    };
}
else {
    //Disable the OnMouseUp event handler.
    document.onmouseup = function (e) {
        if (e != null && e.type == "mouseup") {
            //Check the Mouse Button which is clicked.
            if (e.which == 2 || e.which == 3) {
                //If the Button is middle or right then disable.
                return false;
            }
        }
    };
} 
 
//Disable the Context Menu event.
document.oncontextmenu = function () {
    return false;
};
</script>
























      
    </div>
  </div>


  <?php require('inc/footer.php'); ?>

</body>
</html>