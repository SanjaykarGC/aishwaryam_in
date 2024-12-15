<?php 

  require('admin/inc/essentials.php');
  require('admin/inc/db_config.php');
  require('admin/inc/mpdf/vendor/autoload.php');

  if(isset($_GET['id']))
  {
    $frm_data = filteration($_GET);

    $query = "SELECT  * FROM rooms as r INNER JOIN booking_order as b ON r.id=b.room_id INNER JOIN user_cred as u
    ON b.user_id=u.id where b.booking_id='".$_GET['id']."' AND b.booking_status='confirmed' ";

    $res = mysqli_query($con,$query);

   
    $data = mysqli_fetch_assoc($res);

    $date = date("h:ia | d-m-Y",strtotime($data['datentime']));
    $checkin = date("d-m-Y",strtotime($data['check_in']));
    $checkout = date("d-m-Y",strtotime($data['check_out']));

    $table_data = "
    <h2>BOOKING RECIEPT</h2>
    <table border='1'>
      <tr>
        <td>Order ID: $data[order_id]</td>
        <td>Booking Date: $date</td>
      </tr>
      <tr>
        <td colspan='2'>Status: $data[booking_status]</td>
      </tr>
      <tr>
        <td>Name: $data[user_name]</td>
        <td>Email: $data[email]</td>
      </tr>
      <tr>
        <td>Phone Number: $data[phonenum]</td>
        <td>Address: $data[address]</td>
      </tr>
      <tr>
        <td>Room Name: $data[room_name]</td>
        <td>Cost: ₹$data[price] per night</td>
      </tr>
      <tr>
        <td>Check-in: $checkin</td>
        <td>Check-out: $checkout</td>
      </tr>
    ";

    if($data['booking_status']=='cancelled')
    {
      $refund = ($data['refund']) ? "Amount Refunded" : "Not Yet Refunded";

      $table_data.="<tr>
        <td>Amount Paid: ₹$data[trans_amt]</td>
        <td>Refund: $refund</td>
      </tr>";
    }
    else if($data['booking_status']=='payment failed')
    {
      $table_data.="<tr>
        <td>Transaction Amount: ₹$data[trans_amt]</td>
        <td>Failure Response: $data[trans_resp_msg]</td>
      </tr>";
    }
    else
    {
      $table_data.="<tr>
        <td>Room Number: $data[room_no]</td>
        <td>Amount Paid: ₹$data[trans_amt]</td>
      </tr>";
    }

    $table_data.="</table>";

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($table_data);
    $mpdf->Output($data['order_id'].'.pdf','D');

  }
  
  
?>