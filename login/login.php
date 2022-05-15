<?php 
 // mengecek session apakah user sudah berhasil masuk
session_start();
if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}
// melakukan koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

// memasukkan data user baru ke dalam database
function registrasi($data){
    
    global $conn;
    $username = strtolower(stripcslashes( $data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi = mysqli_real_escape_string($conn, $data["konfirmasi"]);

    // mengecek apakah username yang dimasukkan sudah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "
        <script>
            alert('username sudah ada');
        </script>";
        return false;
    }

    // mengecek apakah password yang di masukkan sudah sama
    if($password !== $konfirmasi){
        echo "
        <script>
            alert('password yang dimasukan tidak sama');
        </script>";
        return false;
    }

    // jika pasword sudah sesuai tambahkan data user baru ke database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");
    mysqli_affected_rows($conn);
    echo "
        <script>
            alert('berhasil membuat akun silahkan login');
        </script>";
}

// untuk signup
if (isset($_POST["signup"])){
    if (registrasi ($_POST) > 0 ){
        // jika user telah berhasil membuat akun
        echo "
        berhasil membuat akun
        ";
    }
    else{
        // jika user gagal membuat akun
        echo mysqli_error($conn);
    }
}

// untuk login
if (isset($_POST["login"])){
    global $conn;
    // mengambil data yang diimput dengan metode post
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // mencari apakah username yang dimasukan ada di dalam database
    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // cek username
    if(mysqli_num_rows($result)===1){
        // cek password
        $row = mysqli_fetch_assoc($result);
        if($password === $row['password']){
                header("Location: index.php");
                exit;
            }
        }
        $error = true; 
        
    }

 ?>

<html>
<head>
    <title>Login </title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container">

<div class="card">
<div class="inner-box" id="card">
<div class="card-front">
    <h2>LOGIN</h2>
    <form action="" method="post">
        <input type="text" class="input-box" placeholder="Username" name="username" required>
        <input type="Password" class="input-box" placeholder="Password" name="password" required>
        <?php if(isset($error)): ?>
        <p style="color: red; font-style: italic; text-align: center;">username atau password salah</p>
    <?php endif; ?>
        <button type="submit" class="summit-btn" name="login">Submit</button>
        
    </form>
    <button type="button" class="btn" onclick="openRegister()">I'm New Here</button>

</div>
<div class="card-back">
    <h2>REGISTER</h2>
    <?php if(isset($error)): ?>
        <p style="color: red; font-style: italic; text-align: center;">username atau password salah</p>
    <?php endif; ?>
    <form action="" method="post">
        <input type="text" class="input-box" placeholder="Username" required name="username">
        <input type="Password" class="input-box" placeholder="Password" name="password" required>
        <input type="Password" class="input-box" placeholder="Confirm" name="konfirmasi" required>
        <button type="submit" class="summit-btn" name="signup">Submit</button>
        
    </form>
    <button type="button" class="btn" onclick="openLogin()">I've an account</button>
 
</div>
</div>
</div>
</div>

    <script>

    var card = document.getElementById("card");
    
    function openRegister(){
        card.style.transform = "rotateY(-180deg)";
    }
    function openLogin(){
        card.style.transform = "rotateY(0deg)";
    }


    </script>

</body>
</html>