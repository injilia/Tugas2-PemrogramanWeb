<?php 
	// melakukan koneksi ke database
	$conn = mysqli_connect("localhost", "root", "", "phpdasar");

	//mengambil data id dari $_GET 
	$id = $_GET['id'];
	// function untuk menghapus gambar
	function hapus($id){
	// mengambil variabel $conn dari luar function
	global $conn;
	// menghapus data di database
	mysqli_query($conn, "DELETE FROM image WHERE id = $id");
	return mysqli_affected_rows($conn);
	}

	//untuk menampilkan apakah foto yang dipilih telah berhasil dihapus atau belum  
	if(hapus ($id) !== 0){
			echo "
			<script>
			alert('data berhasil dihapus');
			document.location.href = 'index.php';
			</script>
		";
	}
	else{
		echo "
			<script>
			alert('data gagal dihapus');
			document.location.href = 'index.php';
			</script>
		";
	}

 ?>