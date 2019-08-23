
<?php
	
	include('../config.php');

	session_start();

	if(!$_SESSION['user_firstname'] AND $_SESSION['user_firstname'] != 1){

		header("location: ../index.php");
		exit();

	}
	
	if($_SESSION['user_level']!=1){
		header("location: ../index.php");
		exit();
	}

	$id = $_GET['kode'];
	try {
			$stmt_select = $conn->prepare('SELECT * FROM items WHERE item_id =:item_id');
			$stmt_select->execute(array(':item_id'=>$_GET['kode']));
			$data=$stmt_select->fetch(PDO::FETCH_ASSOC);
		}
	catch(PDOException $e)
		{
			echo $sql . "<br>" . $e->getMessage();
		}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Data Barang</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../asset/css/materialize.min.css">
	<link rel="shortcut icon" href="../favicon.ico" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
</head>

<body>

	<!-- Menu -->
	<!-- <div class="navbar-fixed"> -->
		
		<nav class="light-blue darken-3">
		<div class="container">
			<div class="nav-wrapper">
				<a href="index.php" class="brand-logo">KEP</a>
				<a href="#" data-activates="mobile-menu" class="button-collapse">
					<i class="material-icons">menu</i>
				</a>

				<ul class="right hide-on-med-and-down">
					<li><a href="index.php">Beranda</a></li>
					<li class="active"><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li><a href="pesanan.php">Detail Pesanan</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>

				<ul class="side-nav" id="mobile-menu">
					<li><a href="index.php">Beranda</a></li>
					<li class="active"><a href="barang.php">Data Barang</a></li>
					<li><a href="pelanggan.php">Data Pelanggan</a></li>
					<li><a href="approve_pesanan.php">Approve Pesanan</a></li>
					<li><a href="pesanan.php">Detail Pesanan</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
		</div>
		</nav>
	<!-- </div> -->

	<!-- Menu -->

	<!-- Konten -->
	<br><br>
	<div class="container">

		<!-- FORM EDIT -->
			<div class="row">
				<div class="container">
					 <?php

						if(isset($_POST["edit"])) {

							$id=$data['item_id'];
							$a=$_POST["nama"];
							$b=$_POST["harga"];

							$sql = "UPDATE items SET item_name=:item_name, item_price=:item_price";
							$imgFile = $_FILES['item_image']['name'];
							$tmp_dir = $_FILES['item_image']['tmp_name'];
							$imgSize = $_FILES['item_image']['size'];

							if($imgFile)
							{
								$upload_dir = '../gambar_barang/';
								$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
								$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
								$itempic = rand(1000,1000000).".".$imgExt;
								if(in_array($imgExt, $valid_extensions))
								{			
									if($imgSize < 1000000)
									{
										unlink($upload_dir.$data['item_image']);
										move_uploaded_file($tmp_dir,$upload_dir.$itempic);
										$sql .= ", item_image=:item_image";
									}
									else
									{
										$display_error = "Maaf ukuran maksimal 1MB";
										echo "<script>alert('Maaf ukuran maksimal 1MB')</script>";				
										 
									}
								}
								else
								{
									$display_error = "Maaf, hanya menerima file gambar JPG, JPEG, PNG & GIF.";	
					              echo "<script>alert('Maaf, hanya menerima file gambar JPG, JPEG, PNG & GIF.')</script>";					
								}
							}

							$sql .= " WHERE item_id=:item_id";
							try {
									$stmt = $conn->prepare($sql);
									$stmt->bindParam(':item_name',$a);
									$stmt->bindParam(':item_price',$b);
									($imgFile) ? $stmt->bindParam(':item_image',$itempic) : "" ;
									$stmt->bindParam(':item_id',$id);
									$update = $stmt->execute();
								}
							catch(PDOException $e)
								{
									echo $sql . "<br>" . $e->getMessage();
								}

							if($update) {
								echo"<script>window.alert('Data berhasil di update');;window.location='../admin/barang.php'</script>";
							}
							else {
								echo"<script>window.alert('Data gagal dd update');;window.location='../admin/barang.php'</script>";
							}			
						}
					
					echo'
					<form method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<h4 class="center-align">
									Edit Data Barang
								</h4>
								<div class="row">
									<div class="input-field">
										<input type="text" name="nama" value="'.$data['item_name'].'" id="icon_prefix">
										<label for="icon_prefix">Nama</label>
									</div>
								</div>
								<div class="row">
									<div class="input-field">
										<input type="text" name="harga" value="'.$data['item_price'].'" id="icon_prefix">
										<label for="icon_prefix">Harga</label>
									</div>
								</div>
								<div class="row">
									<div class="col s12 m12 l12 input-field">
										<img width="100" src="../gambar_barang/'.$data['item_image'].'">
										<br><br>
										<p> <b>ubah gambar</b> </p>
								    	<input type="file" name="item_image" id="item_image">
								    </div>
							    </div>
								<div class="row">
									<div class="input-field center-align">
										<button class="btn waves-effect waves-light" type="submit" name="edit">Edit<i class="material-icons right">done</i></button>
										<a href="barang.php" class="waves-effect waves-light btn">Batal</a>
									</div>
								</div>
							</div>
					</form>
					';
					?>
				</div>
			</div>
		<!-- FORM EDIT -->

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
	<script>
		$(document).ready(function(){
			$('.button-collapse').sideNav();
		});
	</script>
</body>
</html>