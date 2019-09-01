
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

	if(isset($_GET['approve']))
	{
		try {
				$stmt_delete = $conn->prepare('UPDATE orderdetails SET order_status="Ordered_Finished"  WHERE user_id =:user_id AND order_status="Ordered"');
				$stmt_delete->bindParam(':user_id',$_GET['approve']);
	 			$stmt_delete->execute();
		    	echo"<script>window.alert('Order ".$_GET['approve']." berhasil diapprove');window.location='approve_pesanan.php'</script>";
		    }
		catch(PDOException $e)
		    {
		    	echo $sql . "<br>" . $e->getMessage();
		    }
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Approve Pesanan</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../asset/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../asset/datatables/datatables.min.css">
	<link rel="stylesheet" type="text/css" href="../asset/css_pribadi.css">
	<link rel="shortcut icon" href="../favicon.ico" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>

	<!-- Menu -->
	<!-- <div class="navbar-fixed"> -->

		<nav class="light-blue darken-3">
		<div class="container_body">
			<div class="nav-wrapper">
				<a href="index.php" class="brand-logo">KEP</a>
				<a href="#" data-activates="mobile-menu" class="button-collapse">
					<i class="material-icons">menu</i>
				</a>

				<ul class="right hide-on-med-and-down">
					<li><a href="index.php">Beranda</a></li>
					<li><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li class="active"><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li><a href="pesanan.php">Detail Pesanan</a></li>
					<li><a href="profil.php">Profil</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li><a href="index.php">Beranda</a></li>
					<li><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li class="active"><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li><a href="pesanan.php">Detail Pesanan</a></li>
					<li><a href="profil.php">Profil</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
		</nav>
	<!-- </div> -->

	<!-- Menu -->

	<!-- Konten -->
	<br><br>
	<!-- <div class="container"> -->
	<div class="container_body">
		<div class="row">
			<div class="col s12 white">
				<h5>Approve Pesanan </h5>
				<p>
					<?php
			        	$Today=date('y:m:d');
			        	$new=date('l, F d, Y',strtotime($Today));
			        	echo $new;
		            ?>
				</p>
			</div>
		</div>
		<div class="row">

			<table id="datafauna" class="display responsive-table" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		            	<th>No</th>
		                <th>Nama</th>
		                <th>Alamat</th>
		                <th>Email</th>
		                <th>Aksi</th>
		            </tr>
		        </thead>
		        <tbody>
					<?php

					$no =1;
					$stmt = $conn->prepare("SELECT * FROM users AS us JOIN orderdetails AS ord ON ord.user_id=us.user_id WHERE user_level = '0' AND order_status='ordered' GROUP BY us.user_id");
                  	$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){;?>
					    <tr>
					    	<td><?php echo $no++;?></td>
					        <td><?php echo $row['user_firstname']." ".$row['user_lastname'];?></td>
					        <td><?php echo $row['user_address'];?></td>
					        <td><?php echo $row['user_email'];?></td>
					        <td>
					        	<?php echo '<a href="det_pesan.php?user_id='.$row['user_id'].'" target="_blank" class="tooltipped btn-floating waves-effect waves-light green" data-position="bottom" data-tooltip="Pesanan"><i class="material-icons left">local_grocery_store</i></a>' ?>

					        	<?php echo '<a onclick="return approve()" href="?approve='.$row['user_id'].'" class="tooltipped btn-floating waves-effect waves-light orange" data-position="bottom" data-tooltip="Approve Pesanan"><i class="material-icons left">delete_sweep</i></a>' ?>

					        	<?php echo '<a href="cetak_laporan.php?view_id='.$row['user_id'].'" target="_blank" class="tooltipped btn-floating waves-effect waves-light yellow" data-position="bottom" data-tooltip="Cetak"><i class="material-icons left">print</i></a>' ?>

					        	<?php echo '<a href="pesanan_sebelum.php?user_id='.$row['user_id'].'" target="_blank" class="tooltipped btn-floating waves-effect waves-light blue" data-position="bottom" data-tooltip="Pesanan Sebelumnya"><i class="material-icons left">remove_red_eye</i></a>' ?>
					        </td>
					    </tr>
					<?php };?>
				</tbody>
		    </table>

		</div>
		<br>
	</div>
	<!-- Konten -->

	<!-- Footer -->
	<br>
	<br>
	<footer class="page-footer light-blue darken-3 black-text">
			<div class="footer-copyright">
				<div class="container center-align">
					&copy; Kebakkramat Elang Perkasa - materialize <?php echo date('Y'); ?>
					<br>
					Yudhistira Gilang
				</div>
			</div>
	</footer>
	<!-- Footer -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../asset/js/materialize.min.js"></script>
	<script src="../asset/js/jquery.dataTables.min.js"></script>
	<script src="../asset/datatables/datatables.min.js"></script>
	<script>
		$(document).ready(function(){
			$('.button-collapse').sideNav();
			$('.tooltipped').tooltip();
			$('select').material_select();
			$('.modal').modal();
			$('#datafauna').DataTable();
		});
	</script>
	<script type="text/javascript" language="JavaScript">
		function hapus(){
			takon = confirm("Anda Yakin Akan Menghapus Data ?");
				if (takon == true) return true;
				else return false;
		}
		function approve(){
			takon = confirm("Anda Yakin Akan Approvee Data Orderan Ini ?");
				if (takon == true) return true;
				else return false;
		}
	</script>
</body>
</html>