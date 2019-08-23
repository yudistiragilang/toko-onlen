
<?php

	include('../config.php');

	session_start();

	if(!$_SESSION['user_firstname']){

		header("location: ../index.php");
		exit();

	}
	
	if($_SESSION['user_level']!=1){
		header("location: ../index.php");
		exit();
	}

	if(isset($_GET['kode']))
	{

		try {
		      $stmt_select = $conn->prepare('SELECT item_image FROM items WHERE item_id =:item_id');
		      $stmt_select->execute(array(':item_id'=>$_GET['kode']));
		      $imgRow=$stmt_select->fetch(PDO::FETCH_ASSOC);
		      unlink("../gambar_barang/".$imgRow['item_image']);

		      $stmt_delete = $conn->prepare('DELETE FROM items WHERE item_id =:item_id');
		      $stmt_delete->bindParam(':item_id',$_GET['kode']);
		      $stmt_delete->execute();
		      echo"<script>window.alert('DATA BERHASIL DIHAPUS');window.location='barang.php'</script>";
		    }
		catch(PDOException $e)
		    {
		      echo $sql . "<br>" . $e->getMessage();
		    }
	    
	}

	function rupiah($angka){
		$hasil_rupiah = "Rp " . number_format($angka,2,',','.');
		return $hasil_rupiah;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Data Barang</title>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../asset/css/materialize.min.css">
	<link rel="stylesheet" type="text/css" href="../asset/datatables/datatables.min.css">
	<link rel="stylesheet" type="text/css" href="../asset/css_pribadi.css">
	<link rel="shortcut icon" href="../favicon.ico" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		/*body{
			background: gambar/back.jpg;
		}*/
	</style>
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
	<div class="container_body">

		<!-- MODAL -->
			<div id="modal1" class="modal">
			    <div class="modal-content">
					 <?php

						if(isset($_POST["simpan"])) {

							$item_name=$_POST["nama"];
							$item_price=$_POST["harga"];

							try {
									$stmt = $conn->prepare("SELECT * FROM items WHERE item_name = '$item_name'"); 
								    $stmt->execute();
								    $count = $stmt->rowCount();
								    if ($count > 0) {
								    	echo "<script>alert('Item is already exist, Please try another one!')</script>";
										echo"<script>window.open('index.php','_self')</script>";
										exit();
								    } else {

								    	$imgFile = $_FILES['item_image']['name'];
										$tmp_dir = $_FILES['item_image']['tmp_name'];
										$imgSize = $_FILES['item_image']['size'];
										$upload_dir = '../gambar_barang/';
										$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
										$valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
										$itempic = rand(1000,1000000).".".$imgExt;

										if(in_array($imgExt, $valid_extensions)){

											if($imgSize < 1000000){
												move_uploaded_file($tmp_dir,$upload_dir.$itempic);

												try {
												    	$sql = "INSERT INTO items (item_name, item_price, item_image, item_date) VALUES ('$item_name', '$item_price', '$itempic', CURDATE())";
													    $conn->exec($sql);
													    echo "<script>alert('Data successfully saved!')</script>";
														echo "<script>window.open('barang.php','_self')</script>";
												    }
												catch(PDOException $e)
												    {
												    echo $sql . "<br>" . $e->getMessage();
												    }
											}
											else{
												echo "<script>alert('Sorry, your file is too large.')</script>";
												echo "<script>window.open('barang.php','_self')</script>";
											}
										}
										else{
											echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.')</script>";
											echo "<script>window.open('barang.php','_self')</script>";
										}
								    }
								}
							catch(PDOException $e)
								{
								    echo "Error: " . $e->getMessage();
								}
						}
					
					echo'
					<form method="POST" action="" enctype="multipart/form-data">
							<div class="row">
								<h4 class="center-align">
									Tambah Data Barang
								</h4>
								<div class="row">
									<div class="col s12 m12 l12 input-field">
										<input type="text" name="nama" required id="icon_prefix">
										<label for="icon_prefix">Nama</label>
									</div>
								</div>
								<div class="row">
									<div class="col s12 m12 l12 input-field">
										<textarea id="harga" name="harga" required class="materialize-textarea" data-length="200"></textarea>
			            				<label for="harga">Harga</label>
									</div>
								</div>
								<div class="row">
									<div class="col s12 m12 l12 input-field">
								    	<input type="file" required name="item_image" id="item_image">
								    </div>
							    </div>

							    <div class="row">
									<div class="input-field center-align">
										<button class="btn waves-effect waves-light" type="submit" name="simpan">Simpan<i class="material-icons right">send</i></button>
									</div>
								</div>
							</div>
					</form>
					';
					?>

				</div>
			</div>
		<!-- MODAL -->

		<div class="row">
			<div class="col s12 white">
				<h5>Data Barang </h5>
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
			<a class="btn-floating btn-large waves-effect waves-light green modal-trigger" href="#modal1"><i class="material-icons">add</i></a>
		</div>
		<div class="row">

			<table id="datafauna" class="display responsive-table" cellspacing="0" width="100%">
		        <thead>
		            <tr>
		            	<th>No</th>
		                <th>Nama</th>
		                <th>Harga</th>
		                <th>Foto</th>
		                <th>Aksi</th>
		            </tr>
		        </thead>
		        <tbody>
					<?php

					$no =1;
					$stmt = $conn->prepare('SELECT * FROM items');
                  	$stmt->execute();
					while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){;?>
					    <tr>
					    	<td><?php echo $no++;?></td>
					        <td><?php echo $row['item_name'];?></td>
					        <td><?php echo rupiah($row['item_price']);?></td>
					        <td><?php echo'<img width="100" src="../gambar_barang/'.$row['item_image'].'">  ';?></td>
					        <td>
					        	<?php echo'<a class="btn-floating waves-effect waves-light blue" href="eba.php?kode='.$row['item_id'].'"><i class="material-icons">mode_edit</i></a>';?>
					        	<?php echo'<a onclick="return hapus()" href="?kode='.$row['item_id'].'" class="btn-floating waves-effect waves-light red"><i class="material-icons">delete</i></a>';?>
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
			$('.modal').modal();
		    $('.tooltipped').tooltip();
			$('#datafauna').DataTable();
		});
	</script>
	<script type="text/javascript" language="JavaScript">
		function hapus(){
			takon = confirm("Anda Yakin Akan Menghapus Data ?");
				if (takon == true) return true;
				else return false;
				}
	</script>
</body>
</html>