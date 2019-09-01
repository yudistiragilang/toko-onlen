
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

	if(isset($_GET['delete']))
	{

		try {
				$sql = "DELETE FROM orderdetails WHERE order_id =:order_id";
		    	$stmt_delete = $conn->prepare($sql);
		    	$stmt_delete->bindParam(':order_id',$_GET['delete']);
		    	$stmt_delete->execute();
		    	echo"<script>window.alert('DATA BERHASIL DIHAPUS');window.location='pesanan.php'</script>";
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
	<title>Data Detail Pesanan</title>
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
					<li><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li class="active"><a href="pesanan.php">Detail Pesanan</a></li>
					<li><a href="profil.php">Profil</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li><a href="index.php">Beranda</a></li>
					<li><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li class="active"><a href="pesanan.php">Detail Pesanan</a></li>
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
				<h5>Data Detail Pesanan </h5>
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
	                    <th>Tanggal Pesanan</th>
	                    <th>Nama Pelanggan</th>
	                    <th>Menu</th>
	                    <th>Harga</th>
	                    <th>Jumlah</th>
	                    <th>Total</th>
	                    <th>Aksi</th>
		            </tr>
		        </thead>
		        <tbody>
					<?php

					$no =1;
					$stmt = $conn->prepare("SELECT order_id, order_date, users.user_firstname, users.user_lastname, order_name, order_price, order_quantity, order_total FROM orderdetails, users WHERE orderdetails.user_id=users.user_id AND order_status='ordered' ORDER BY order_date DESC");
                  	$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){;?>
					    <tr>
					    	<td><?php echo $no++;?></td>
					        <td><?php echo $row['order_date'];?></td>
					        <td><?php echo $row['user_firstname']." ".$row['user_lastname'];?></td>
					        <td><?php echo $row['order_name'];?></td>
					        <td><?php echo $row['order_price'];?></td>
					        <td><?php echo $row['order_quantity'];?></td>
					        <td><?php echo $row['order_total'];?></td>
					        <td>
					        	<?php echo'<a onclick="return hapus()" href="?delete='.$row['order_id'].'" class="tooltipped btn-floating waves-effect waves-light red" data-position="bottom" data-tooltip="Hapus Pelanggan"><i class="material-icons">delete</i></a>';?>
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
		function hapus_order(){
			takon = confirm("Anda Yakin Akan Menghapus Data Orderan Ini ?");
				if (takon == true) return true;
				else return false;
		}
	</script>
</body>
</html>