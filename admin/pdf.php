<?php 

  require('inc/essentials.php');
  require('inc/db_config.php');
  require('inc/mpdf/vendor/autoload.php');

  
    $query = "SELECT  * FROM rooms as r INNER JOIN booking_order as b ON r.id=b.room_id INNER JOIN user_cred as u
    ON b.user_id=u.id ";

    $res = mysqli_query($con,$query);

   
    while($data = mysqli_fetch_assoc($res)) {

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
        <td>Name: $data[uname]</td>
        <td>Email: $data[email]</td>
      </tr>
      <tr>
        <td>Phone Number: $data[phonenum]</td>
        <td>Address: $data[address]</td>
      </tr>
      <tr>
        <td>Room Name: $data[name]</td>
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
      <td>Total Amount: ₹$data[trans_amt]</td>
      <td>GST : 18%</td>
        <td>GST Amount: ₹$data[gst]</td>
        <td>Net Paid: ₹$data[final_amt]</td>
      </tr>";
    }

    $table_data.="</table>";

    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($table_data);
    $mpdf->Output($data['order_id'].'.pdf','D');

  
  
  }
?>