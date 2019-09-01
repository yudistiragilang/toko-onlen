<?php

	include('../config.php');

	session_start();

	if(!$_SESSION['user_firstname'] AND $_SESSION['user_level'] != 1){

		header("location: ../index.php");
		exit();

	}

	if($_SESSION['user_level']!=1){
		header("location: ../index.php");
		exit();
	}

	if(isset($_GET['view_id']) && !empty($_GET['view_id']))
	{
		$view_id = $_GET['view_id'];
		$stmt = $conn->prepare('SELECT * FROM users WHERE user_id=:user_id');
		$stmt->execute(array(':user_id'=>$view_id));
		$edit_row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
	}
?>

           
       
<table class="display table table-bordered" id="example" align="center" cellspacing="4" cellpadding="10"width="40%">
  <tr>
    <th colspan="5" align="center" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="5">PT KEBAKKRAMAT ELANG PERKASA</th>
  </tr>
    <th colspan="4" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2">_____________________________________________________________________________</th>
  </tr>
  

</table> 

            <table class="display table table-bordered" id="example" align="center" cellspacing="1" cellpadding="5"width="40%">
              <thead>
                <tr>
                  <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="4" >NAMA BARANG</th>
                  <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="4">HARGA</th>
				  <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="4">JUMLAH</th>
                  <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="4">TOTAL</th>
				  
                </tr>
              </thead>
              <tbody>
			  <?php
	$stmt = $conn->prepare("SELECT * FROM orderdetails where user_id='$user_id' and order_status='Ordered'");
	$stmt->execute();
	
	if($stmt->rowCount() > 0)
	{
		while($row=$stmt->fetch(PDO::FETCH_ASSOC))
		{
			extract($row);
			
			
			?>
			
                <tr>
                  
                 <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2"><?php echo $order_name; ?></th>
				 <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2">Rp. <?php echo $order_price; ?> </th>
				 <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2"><?php echo $order_quantity; ?></th>
				 <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2">Rp. <?php echo $order_total; ?></th>
				  
				 
				 
                </tr>
               
              <?php
		}
		 $stmt = $conn->prepare("select sum(order_total) as totalx from orderdetails where user_id=:user_id and order_status='Ordered'");
		$stmt->execute(array(':user_id'=>$user_id));
		$edit_row = $stmt->fetch(PDO::FETCH_ASSOC);
		extract($edit_row);
		
		
		echo "<tr>";
		echo "<th colspan='15' align='left' scope='col'><font color='#000000' face='Tahoma, Geneva, sans-serif' size='2'><span style='color:black;'>Customer: ".$user_firstname." ".$user_lastname." | <span style='color:black'>Total Harga Pesanan:</span>";
		echo "</th>";
		
		echo "<th colspan='20' align='left' scope='col'><font color='#000000' face='Tahoma, Geneva, sans-serif' size='2'><span style='color:black;'>Rp. ".$totalx."</span>";
		echo "</th>";
		
		
	}
	
	
?>
</table><br>

<table class="display table table-bordered" id="example" align="center" cellspacing="1" cellpadding="10"width="40%">
<?php
          $stmt = $conn->prepare("SELECT * FROM alamatdetails");
          $stmt->execute();
          
          if($stmt->rowCount() > 0)
          
          while($row=$stmt->fetch(PDO::FETCH_ASSOC))
          
          extract($row);
      
          ?>
          
<tr>
<th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="4">Berikut adalah data lengkap Anda : </th>
</tr>

<tr>
<th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2">Nama Lengkap  : &nbsp;<?php echo $name; ?> </th>
</tr>
<tr>
<th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2">Alamat tujuan : &nbsp;<?php echo $adress; ?> </th>
 </tr>
 <tr>
 <th colspan="5" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2">No telepon/hp          : &nbsp;<?php echo $phone; ?></th>
</tr>
</tabel>

<table width="500" border="0" align="center" cellpadding="5" cellspacing="1">
<tr>
    <th colspan="5" align="right" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2"><b>                     Tanda terima</b></th>
  </tr>
  <br>		
<tr><th></th></tr>
<tr><th></th></tr>
<tr><th></th></tr>
<tr><th></th></tr>
<tr><th></th></tr>
<tr><th></th></tr>

<tr>

    <th colspan="5" align="right" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2"><b>                     . . . . . . . . . . </b></th>
  </tr>
  <tr><th></th></tr><tr>
  <table class="display table table-bordered" id="example" align="center" cellspacing="4" cellpadding="10"width="40%">
  <th colspan="4" align="left" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="2">_____________________________________________________________________________</th></tr>
  </table>
  <tr><th></th></tr>
  	<table class="display table table-bordered" id="example" align="center" cellspacing="4" cellpadding="10"width="30%">
    <th colspan="5" align="center" scope="col"><font color="#000000" face="Tahoma, Geneva, sans-serif" size="3"><b>Jl.Pakel no.135 Solo/02717654552/infousahakarya@gmail.com</b></th>
  </tr>

</table>

<script language="javascript">
window.print()
</script>