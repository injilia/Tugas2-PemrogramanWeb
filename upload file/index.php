<?php 
// melakukan koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

// untuk mengupload gambar
	if(isset($_POST['submit'])){
		global $conn;
		$directori = "directori/";
		$namafile = $_FILES['input']['name'];
		$error = $_FILES['input']['error'];

		// mengecek apakah ada gambar yang diupload
		if ($error === 4){
		echo "
		<script>
			alert('pilih gambar terlebih dahulu');
		</script>";
		return false;
		}
		// mengecek ekstensi file yang di upload
		$ekstensi = ['jpg','jpeg','png'];
		$ekstensiGambar = explode('.', $namafile);
		$ekstensiGambar = strtolower(end($ekstensiGambar));
		// jika ekstensi yang dimasukkan tidak sesuai

		if(!in_array($ekstensiGambar, $ekstensi)){
			echo "
			<script>
				alert('yang anda upload bukan gambar');
			</script>";
			return false;
		}

		// mengambil file gambar dan memasukkannya di dalam directori
		move_uploaded_file($_FILES['input']['tmp_name'], $directori.$namafile);
		mysqli_query($conn, "INSERT INTO image set nama = '$namafile'");

		// menampilkan alert jika gambar telah berhasil di tambahakan
		echo "
			<script>
				alert('berhasil menambahkan gambar');
			</script>";
	}

	// function untuk melakukan query data dari database
	function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while($row = mysqli_fetch_assoc($result)){
		$rows[] = $row;
	}
	return $rows;
	}

	// mengambil data dari gambar kemudian disimpan ke variabel $img
	$img = query("select * from image ORDER BY id ASC");

 ?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>upload file</title>
	<style type="text/css">

		.container{
			width: 80%;
			margin: auto;
		}
		label{
			font-size: 20px;
		}
		input{

		}
		button{
			background-color: rgba(0, 0, 255, 0.2);
			border: 1px solid navy;
			border-radius: 2px;
			transition: 0.1s ease;
		}
		button:hover{
			background-color: rgba(0, 0, 255, 1);
			color: white;
			
		}
		.itu{
			align-items: center;
		}
		.box{
			height: 250px;
			width: 230px;
			border: 1px solid black;
			border-radius: 2px;
			float: left;
			margin: 10px;
		}

		img{
			display: block;
			height: 150px;
			width: 150px;
			left: 0;		
		}
		a{
			margin: 20px auto;
			font-weight: bold;
			color: red;
			display: inline-block;
			border: 1px solid red;
			padding: 5px 12px;
			border-radius: 3px;
			text-align: center;
			text-decoration: none;
		}
		a:hover{
			color: black;
			background-color: red;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Upload Gambar</h1>
		<form action="" method="post" enctype="multipart/form-data">
			
			<label for="input">Tambahkan Gambar</label><br>
			<input type="file" name="input" id="input">
			<br><br>
			<button type="submit" name="submit">Tambahkan</button>
		</form>
		<br>
		<div class="itu">
		<?php $i=1; ?>
	    <?php foreach($img as $row): ?>
		<div class="box">
			<ul>
				<img src="directori/<?= $row["nama"]; ?>">
				<a href="hapus.php?id=<?= $row["id"]; ?>" onclick= "return confirm('anda ingin menghapus gambar ini, yakin?')">hapus</a>
			</ul>
		</div>
		<?php $i++; ?>
		<?php endforeach; ?>
		</div>
	</div>

</body>
</html>